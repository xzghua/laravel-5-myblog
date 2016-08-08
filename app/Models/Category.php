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

}