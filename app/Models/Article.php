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


}