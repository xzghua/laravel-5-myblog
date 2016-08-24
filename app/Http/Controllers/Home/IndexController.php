<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Admin\behaviorController;
use App\Http\Controllers\Admin\Parsedown;
use App\Http\Controllers\Admin\Parser;
use App\Jobs\InsertBehaviorData;
use App\Jobs\TestJob;
use App\Models\Article;
use App\Models\Behavior;
use App\Models\Category;
use App\Models\Link;
use App\Models\Seo;
use App\Models\Tag;
use App\Models\View;
use Illuminate\Http\Request;
use Cache;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Mockery\CountValidator\Exception;
use Mail;

class IndexController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        //
        $this->getBehavior($request);
        $page = empty($request->get('page')) ? 1 : $request->get('page');
        if (Cache::tags(['paginate',$page])->get($page)) {
            $data['paginate'] = Cache::tags(['paginate',$page])->get($page);
        } else {
            $data['paginate'] = Article::orderBy('created_at','desc')
               ->with('getAuthor')
               ->with('getTags')
               ->with('getCategories')
               ->with('getViews')
               ->paginate(12, ['*'], 'page', $page);

            Cache::tags(['paginate',$page])->put($page,$data['paginate'],100000);
        }

        $data['article'] = Article::sortData($data['paginate']->toArray()['data'],'Home');
        $data = array_merge($data,$this->common());

        return view("Home.".$data['theme'].".index",$data);
    }

    /**
     * @param $id
     * @param Request $request
     * @return View
     */
    public function getDetail($id,Request $request)
    {
        $this->getBehavior($request);
        $data = $this->common();
        View::where('art_id',$id)->increment('view_num',1);

        if (Cache::tags(['articleDetail',$id])->get($id)) {
            $data['article'] = Cache::tags(['articleDetail',$id])->get($id);
        } else {
            $data['article'] = Article::where('id',$id)
                ->with('getAuthor')
                ->with('getTags')
                ->with('getCategories')
                ->with('getViews')
                ->first()
                ->toArray();

            Cache::tags(['articleDetail',$id])->put($id,$data['article'],100000);
        }

        $parser = new Parsedown();
        $data['article']['content'] = $parser->text($data['article']['content']);
        $data['last'] = Article::where('id','<',$id)
            ->orderBy('created_at','desc')
            ->skip(0)
            ->take(1)
            ->first();
        $data['next'] = Article::where('id','>',$id)
            ->skip(0)
            ->take(1)
            ->first();

        return view("Home.".$data['theme'].".detail",$data);
    }

    /**
     * 公共获取系统设置,所有标签和分类
     * @date 2016年08月13日15:06:49
     * @return mixed
     */
    public function common()
    {

        $seo = Cache::rememberForever('seo',function(){
           return Seo::all()->toArray();

        });

        $data['seo'] = empty($seo) ? $seo : $seo['0'];
        $data['theme'] = empty($data['seo']['theme']) ? 'default' : $data['seo']['theme'];
        $data['link'] = Cache::rememberForever('link',function(){
            return Link::all()->toArray();
        });

        $data['tag'] = Cache::rememberForever('tag',function(){
            return Tag::all()->toArray();
        });

        $data['category'] = Category::getCateArr();

        return $data;
    }

    /**
     * @date 2016年08月13日15:37:53
     * @param string $cate_name
     */
    public function getCategories($cate_name,Request $request)
    {
        $this->getBehavior($request);

        $data = $this->common();
        $data['artList'] = Category::where('cate_name',$cate_name)
            ->with('getArticle')
            ->first();

        return view('Home.'.$data['theme'].".categories",$data);
    }

    /**
     * 某标签下所有文章
     * @date 2016年08月13日16:52:54
     * @param string $tag_name
     */
    public function getTags($tag_name,Request $request)
    {
        $this->getBehavior($request);

        $data = $this->common();
        $data['artList'] = Tag::where('tag_name',$tag_name)
            ->with('getTags')
            ->first();

        return view('Home.'.$data['theme'].".tags",$data);

    }

    /**
     * 关于页面
     * @date 2016年08月13日16:53:34
     */
    public function getAbout(Request $request)
    {
        $this->getBehavior($request);
        $data = $this->common();
        return view('Home.'.$data['theme'].".about",$data);
    }

    /**
     * 归档文章
     * @return View
     */
    public function getMonthArticle(Request $request)
    {
        $this->getBehavior($request);
        $data = $this->common();
        $article = Article::all()->toArray();

        $data['article'] = [];
        foreach ( $article as $key => $value) {
            $data['article'][date('Y-m',strtotime($value['created_at']))][] = $value;
        }

        return  view('Home.'.$data['theme'].".monthList",$data);
    }

    /**
     * 记录访问各个页面的访问者的一些信息,并且放入队列,第二天凌晨12点入库
     * @param $request
     */
    public function getBehavior($request)
    {
        date_default_timezone_set('PRC');

        $be = new behaviorController();
        $behavior = $be->GetAddress();
        $behavior['browser'] = $be->GetBrowser();
        $behavior['system']  = $be->GetOS();
        $behavior['ip']      = $be->GetIP();
        $behavior['x']       = $be->GetXY()['x'];
        $behavior['y']       = $be->GetXY()['y'];
        $behavior['cookie'] = isset($_SERVER['HTTP_COOKIE']) ? $_SERVER['HTTP_COOKIE'] : '';
        $behavior['url'] = $request->url();
        $behavior['port'] = $_SERVER['REMOTE_PORT'];
        $behavior['mobile'] = '';
        $behavior['created_at'] = date('Y-m-d H:i:s',time());
        $behavior['updated_at'] = date('Y-m-d H:i:s',time());

        $tomorrow = strtotime(date('Y-m-d',strtotime("+1 day")) );
        $now = time();
        $time = $tomorrow - $now + rand(1,60);

//        dd(date('Y-m-d H:i:s',$tomorrow),date('Y-m-d H:i:s',$now),$time);

        $this->dispatch((new InsertBehaviorData($behavior))->delay($time));

    }

    public function createBehavior($data)
    {
        try {
            Behavior::create($data);

        } catch (Exception $e) {
            redirect()->route('Home.default.about');
        }
    }

    public function someOneIsBadGay($ip)
    {

    }

    public function TestJob()
    {
        $this->dispatch((new TestJob())->delay(40));
    }

}
