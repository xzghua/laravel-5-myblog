<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Behavior extends Model
{
    //
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'iphpt_user_behavior';

    protected $primaryKey = 'id';


    protected $fillable = [
        'ip',
        'port',
        'browser',
        'cookie',
        'url',
        'mobile',
        'x',
        'y',
        'address',
        'system',

    ];
}
