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
    ];

}