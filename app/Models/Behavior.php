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

    public $timestamps = false;

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
        'province',
        'city',
        'district',
        'street',
        'street_number',
        'created_at',
        'updated_at'
    ];
}
