<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Admin\Parser;
use App\Models\Article;
use App\Models\Category;
use App\Models\Link;
use App\Models\Seo;
use App\Models\Tag;
use App\Models\View;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\View\

use App\Http\Controllers\Controller;


class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data['paginate'] = Article::orderBy('created_at','desc')
            ->with('getAuthor')
            ->with('getTags')
            ->with('getCategories')
            ->with('getViews')
            ->paginate(12);
        $data['article'] = Article::sortData($data['paginate']->toArray()['data'],'Home');
        $data = array_merge($data,$this->common());
        return view("Home.".$data['theme'].".index",$data);
    }

    /**
     * @param $id
     * @return View
     */
    public function getDetail($id)
    {
        $data = $this->common();
        View::where('art_id',$id)->increment('view_num',1);

        $data['article'] =  Article::where('id',$id)
            ->with('getAuthor')
            ->with('getTags')
            ->with('getCategories')
            ->with('getViews')
            ->first()
            ->toArray();
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

        $seo = Seo::all()->toArray();
        $data['seo'] = empty($seo) ? $seo : $seo['0'];
        $data['theme'] = empty($data['seo']['theme']) ? 'default' : $data['seo']['theme'];
        $data['link'] = Link::all()->toArray();
        $data['tag'] = Tag::all()->toArray();
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
