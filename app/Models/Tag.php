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

    const TAG_CREATE_SUCCESS = '200000001';
    const TAG_CREATE_ERROR  = '200000002';
    const TAG_UPDATE_SUCCESS = '200000003';
    const TAG_UPDATE_ERROR = '200000004';
    const TAG_DELETE_SUCCESS = '200000005';
    const TAG_DELETE_ERROR = '200000006';
    const TAG_NAME_IS_EXIST = '200000007';
    const TAG_ID_NOT_EXIST = '200000008';

    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'iphpt_tag';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'tag_name',
        'tag_number'
    ];

    public function getTags()
    {
        return $this->belongsToMany('App\Models\Article','iphpt_tags','tag_id','art_id');
    }


}