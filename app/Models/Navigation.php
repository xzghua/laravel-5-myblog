<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    //
    const NAVIGATION_SAVE_SUCCESS  = '500000005';
    const NAVIGATION_SAVE_ERROR    = '500000006';

    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'iphpt_navigation';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nav_name',
        'links',
        'parent_id',
    ];
}
