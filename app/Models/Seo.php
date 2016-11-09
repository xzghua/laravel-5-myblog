<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    const SEO_SAVE_SUCCESS  = '500000001';
    const SEO_SAVE_ERROR    = '500000002';

    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'system';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'title',
        'theme',
        's_title',
        'description',
        'seo_key',
        'seo_des',
        'record_number'
    ];
}
