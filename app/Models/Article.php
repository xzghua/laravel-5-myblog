<?php
/**
 * Created by PhpStorm.
 * User: ylsc
 * Date: 16-8-3
 * Time: 下午6:21
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Article extends Model
{

    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'iphpt_article';

    protected $primaryKey = 'id';


    protected $fillable = [
        'title',
        'content',
        'user_id',
        'password',
        'read_status',
        'desc'
    ];

    /**
     * 文章对应作者信息
     * @date 2016年08月04日12:12:50
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getAuthor()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    /**
     * 文章对应的浏览数
     * @date 2016年08月04日17:05:06
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getViews()
    {
        return $this->hasOne('App\Models\View','art_id');
    }


    /**
     * 文章对应的分类
     * @date 2016年08月04日13:39:51
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getCategories()
    {
        return $this->belongsToMany('App\Models\Category','iphpt_categories','art_id','cate_id');
    }

    /**
     * @date 2016年08月04日14:26:33
     * @param $cateId
     */
    public function attachCate($cateId)
    {
        if (is_array($cateId)) {
            foreach ($cateId as $item) {
                $this->cate($item);
            }
        }
    }

    /**
     * @date 2016年08月04日14:26:26
     * @param $cateId
     */
    public function cate($cateId)
    {
        return $this->getCategories()->attach($cateId);
    }



    /**
     * 文章对应的标签
     * @date 2016年08月04日13:41:13
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getTags()
    {
        return $this->belongsToMany('App\Models\Tag','iphpt_tags','art_id','tag_id');
    }

    /**
     * @date 2016年08月04日14:26:19
     * @param $tagId
     */
    public function attachTag($tagId)
    {
        if (is_array($tagId)) {
            foreach ($tagId as $item) {
                $this->tag($item);
            }
        }
    }

    /**
     * @date 2016年08月04日14:26:11
     * @param $tagId
     */
    public function tag($tagId)
    {
        return $this->getTags()->attach($tagId);
    }

    /**
     * 整理文章表数据,用于前段展示
     * @date 2016年08月09日11:41:45
     * @param $allData
     * @return mixed
     */
    public static function sortData($allData)
    {
        foreach ($allData['data'] as $key => $item) {
            $allData['data'][$key]['author'] = $item['get_author']['name'];
            $allData['data'][$key]['views']  = $item['get_views']['view_num'];
            if (!empty($item['get_tags'])) {
                $allData['data'][$key]['tags'] = implode(',',array_column($item['get_tags'], 'tag_name'));
            } else {
                $allData['data'][$key]['tags'] = '';
            }

            if (!empty($item['get_categories'])) {
                $allData['data'][$key]['categories'] = implode(',',array_column($item['get_categories'], 'cate_name'));
            } else {
                $allData['data'][$key]['categories'] = '';
            }
        }
        return $allData;
    }

}