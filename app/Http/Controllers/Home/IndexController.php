<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Admin\behaviorController;
use App\Http\Controllers\Admin\Parser;
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

class IndexController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        //
//        $be = new behaviorController();
//        dd($be->GetLang(),$be->GetBrowser(),$be->GetOS(),$be->GetIP(),$be->GetIsp(),$be->GetAdd());
//        dd($_SERVER,$request->url());

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
     * 文章详细页
     * @param $id
     * @return View
     */
    public function getDetail($id)
    {
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

        $parser = new Parser();
        $data['article']['content'] = $parser->makeHtml($data['article']['content']);
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
    public function getCategories($cate_name)
    {
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
    public function getTags($tag_name)
    {
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
    public function getAbout()
    {
        $data = $this->common();
        return view('Home.'.$data['theme'].".about",$data);
    }

    /**
     * 归档文章
     * @return View
     */
    public function getMonthArticle()
    {
        $data = $this->common();
        $article = Article::all()->toArray();

        $data['article'] = [];
        foreach ( $article as $key => $value) {
            $data['article'][date('Y-m',strtotime($value['created_at']))][] = $value;
        }

        return  view('Home.'.$data['theme'].".monthList",$data);
    }


    public function getBehavior()
    {
        $data = [];
        $be = new behaviorController();
        $data['browser'] = $be->GetBrowser();
        $data['system']  = $be->GetOS();
        $data['ip']      = $be->GetIP();
//        $data['x']       = $be->
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
