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
     * 文章对应的分类
     * @date 2016年08月04日13:39:51
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getCategories()
    {
        return $this->belongsToMany('App\Models\Category','iphpt_categories','art_id','cate_id');
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

}