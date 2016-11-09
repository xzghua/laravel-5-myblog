<?php
/**
 * Created by PhpStorm.
 * User: ylsc
 * Date: 16-8-4
 * Time: 下午5:00
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{

    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'iphpt_view';

    protected $primaryKey = 'id';


    protected $fillable = [
        'art_id',
        'view_num',
    ];

    public $timestamps = false;

}