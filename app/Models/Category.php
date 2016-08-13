<?php
/**
 * Created by PhpStorm.
 * User: ylsc
 * Date: 16-8-4
 * Time: 下午12:16
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    const CATEGORY_CREATE_ERROR = '100000002';
    const CATEGORY_ID_NOT_EXIST = '100000001';
    const CATEGORY_CREATE_SUCCESS = '100000003';
    const CATEGORY_UPDATE_SUCCESS = '100000004';
    const CATEGORY_UPDATE_ERROR = '100000005';
    const CATEGORY_UPDATE_NOT_ALLOWED_TO_BE_MYSELF = '100000006';
    const CATEGORY_DELETE_SUCCESS = '100000007';
    const CATEGORY_DELETE_ERROR = '100000008';


    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'iphpt_category';


    protected $primaryKey = 'id';


    protected $fillable = [
        'cate_name',
        'as_name',
        'parent_id',
        'seo_desc',
        'seo_name',
        'seo_title'
    ];

    public $html;

    /**
     *
     * @date 2016年08月08日12:00:07
     * @return array
     */
    public static function  getCateArr()
    {
        $cate = self::all();
        $getTreeArr =  self::tree($cate);
        foreach ($getTreeArr as $key => $value) {
            $getTreeArr[$key]->newHtml = $value->html.$value->cate_name;
        }

        return $getTreeArr;
    }

    /**
     * 通过遍历拿到分类数组(此处参考他人写法 laravel-5-blog)
     * @date 2016年08月08日12:00:53
     * @param $model
     * @param int $parentId
     * @param int $level
     * @param string $html
     * @return array
     */
    public static function tree($model, $parentId = 0, $level = 0, $html = '-')
    {
        $data = array();
        foreach ($model as $k => $v) {
            if ($v->parent_id == $parentId) {
                if ($level != 0) {
                    $v->html = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level);
                    $v->html .= '|';
                }
                $v->html .= str_repeat($html, $level);
                $data[] = $v;
                $data = array_merge($data, self::tree($model, $v->id, $level + 1));
            }
        }
        return $data;
    }

    /**
     * 获得一组下的所有分类 一连串的
     * @date 2016年08月08日22:33:21
     * @return array
     */
    public static function getSimilarToArr()
    {
        $cate = self::all();
        $getTreeArr =  self::tree($cate);
        $similarArr = [];
        $i = 0;
        foreach ($getTreeArr as $value) {
            if ($value->parent_id == '0') $i++;
            if (empty($similarArr[$i])) $similarArr[$i] = [];
            array_push($similarArr[$i],$value->id);
        }
        return $similarArr;
    }

    /**
     * 获得某个ID下的所有子分类
     * @date 2016年08月08日22:34:26
     * @param $id
     * @return bool|mixed
     */
    public static function getChildIdsOfMyself($id)
    {
        $similarArr = self::getSimilarToArr();

        foreach ($similarArr as $key => $value) {
            if (in_array($id,$value)) {
                foreach ( $value as $k => $v) {
                    if ($v == $id) return $similarArr[$key];
                    unset($similarArr[$key][$k]);
                }
            }
        }
        return false;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getArticle()
    {
        return $this->belongsToMany('App\Models\Article','iphpt_categories','cate_id','art_id');
    }

}