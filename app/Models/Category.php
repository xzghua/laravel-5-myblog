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

    public function getAllCate()
    {
        $all = self::all()->toArray();

        $return = $this->tree($all);

        return $return;

    }

    public function tree($data,$newArr = [])
    {
        foreach ($data as $key => $value) {
            $checkChild = self::select('cate_name')->find($value->id);

            if (empty($checkChild)) return false;

            $newArr[] = $value;
            unset($data[$key]);

            return $this->tree($data,$newArr);
        }
    }

}