<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    //
    const LINK_SAVE_SUCCESS  = '500000003';
    const LINK_SAVE_ERROR    = '500000004';
    const LINK_ID_NOT_EXIST  = '500000007';
    const LINK_DELETE_SUCCESS  = '500000008';
    const LINK_DELETE_ERROR  = '500000009';

    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'links';

    protected $primaryKey = 'id';

    protected $fillable = [
        'link',
        'name',
        'ordering',
    ];
}
