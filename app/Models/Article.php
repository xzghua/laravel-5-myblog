<?php
/**
 * Created by PhpStorm.
 * User: ylsc
 * Date: 16-8-3
 * Time: 下午6:21
 */
namespace App\Models;

use App\Http\Controllers\Admin\Parsedown;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Article extends Model
{
    use SoftDeletes;
    const ARTICLE_CREATE_ERROR = '300000002';
    const ARTICLE_ID_NOT_EXIST = '300000007';
    const ARTICLE_CREATE_SUCCESS = '300000001';
    const ARTICLE_UPDATE_SUCCESS = '300000003';
    const ARTICLE_UPDATE_ERROR = '300000004';
    const ARTICLE_DELETE_SUCCESS = '300000005';
    const ARTICLE_DELETE_ERROR = '300000006';
    const ARTICLE_RESTORE_SUCCESS = '300000008';
    const ARTICLE_RESTORE_ERROR = '300000009';

    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'iphpt_article';

    protected $primaryKey = 'id';

    /**
     * 需要被转换成日期的属性。
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title',
        'content',
        'user_id',
        'password',
        'read_status',
        'desc'
    ];

    /**
     * 文章对应作者信息
     * @date 2016年08月04日12:12:50
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getAuthor()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    /**
     * 文章对应的浏览数
     * @date 2016年08月04日17:05:06
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getViews()
    {
        return $this->hasOne('App\Models\View','art_id');
    }

    /**
     * 文章对应的分类
     * @date 2016年08月04日13:39:51
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getCategories()
    {
        return $this->belongsToMany('App\Models\Category','iphpt_categories','art_id','cate_id');
    }

    /**
     * @date 2016年08月04日14:26:33
     * @param $cateId
     */
    public function attachCate($cateId)
    {
        if (is_array($cateId)) {
            foreach ($cateId as $item) {
                $this->cate($item);
            }
        }
    }

    /**
     * @date 2016年08月04日14:26:26
     * @param $cateId
     */
    public function cate($cateId)
    {
        return $this->getCategories()->attach($cateId);
    }

    /**
     * 文章对应的标签
     * @date 2016年08月04日13:41:13
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getTags()
    {
        return $this->belongsToMany('App\Models\Tag','iphpt_tags','art_id','tag_id');
    }

    /**
     * @date 2016年08月04日14:26:19
     * @param $tagId
     */
    public function attachTag($tagId)
    {
        if (is_array($tagId)) {
            foreach ($tagId as $item) {
                $this->tag($item);
            }
        }
    }

    /**
     * @date 2016年08月04日14:26:11
     * @param $tagId
     */
    public function tag($tagId)
    {
        return $this->getTags()->attach($tagId);
    }

    /**
     * 整理文章表数据,用于前端展示
     * @date 2016年08月09日11:41:45
     * @param $allData
     * @param $page
     * @return mixed
     */
    public static function sortData($allData,$page = 'Admin')
    {
        foreach ($allData as $key => $item) {
            $allData[$key]['author'] = $item['get_author']['name'];
            $allData[$key]['views']  = $item['get_views']['view_num'];
            if (!empty($item['get_tags'])) {
                $allData[$key]['tags'] = implode(',',array_column($item['get_tags'], 'tag_name'));
            } else {
                $allData[$key]['tags'] = '';
            }

            if (!empty($item['get_categories'])) {
                $allData[$key]['categories'] = implode(',',array_column($item['get_categories'], 'cate_name'));
            } else {
                $allData[$key]['categories'] = '';
            }

            if ($page != 'Admin') {
                $parser = new Parsedown();
                $allData[$key]['content'] = cut_html_str($parser->text($item['content']),100);
            }

        }
        return $allData;
    }

    /**
     * 处理新建文章标签,返回一个已经存在的标签数组和不存在的标签数组
     * @date 2016年08月10日14:03:02
     * @param $tags
     * @return array
     */
    public static function dealWithPostTags($tags)
    {
        $tagArr = explode(',',$tags);
        $existTags      = [];
        $notExistTags   = [];
        foreach ($tagArr as $key => $value) {
            $getTagId = Tag::where('tag_name',$value)->first();

            if ($getTagId) {
                array_push($existTags,$getTagId->id);
            } else {
                array_push($notExistTags,$value);
            }
        }

        return ['existTag' => $existTags, 'notExistTag' => $notExistTags];
    }

    /**
     * 将新建的标签添入Tag表中,已有的标签 数量自增1
     * @date 2016年08月10日14:03:57
     * @param $tag
     * @param $code
     * @return array
     */
    public static function attachThisTags($tag,$code = 'create')
    {
        if (empty($tag)) {
            return [];
        }

        $tags = self::dealWithPostTags($tag);

        $existTag = $tags['existTag'];
        $notExistTag = $tags['notExistTag'];

        $newCreateTagIds = [];
        foreach ($notExistTag as $item) {
            array_push($newCreateTagIds,Tag::create(['tag_name' => $item,'tag_number' => '1'])->id);
        }

        //此处是判断当前是新建还是修改,修改时 标签计算是不一样的！
        if ($code != 'create') {
            $oldTags = self::find($code)->getTags()->lists('id')->toArray();
            $arrayDiff = array_diff($oldTags,$existTag);

            foreach ($arrayDiff as $k => $v) {
                Tag::where('id',$v)->decrement('tag_number',1);
            }

            $arrayDiff2 = array_diff($existTag,$oldTags);
            foreach ($arrayDiff2 as $k => $v) {
                Tag::where('id',$v)->increment('tag_number',1);
            }
        } else {
            foreach ($existTag as $k => $v) {
                Tag::where('id',$v)->increment('tag_number',1);
            }
        }

        $mergeTags = array_merge($newCreateTagIds,$existTag);

        return $mergeTags;

    }

}