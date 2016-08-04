<?php
/**
 * Created by PhpStorm.
 * User: ylsc
 * Date: 16-8-4
 * Time: 下午12:17
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'iphpt_tag';

    protected $primaryKey = 'id';


    protected $fillable = [
        'tag_name',
        'tag_number',
    ];

}