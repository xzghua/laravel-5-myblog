<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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

        $data['article'] = Article::sortData($data['paginate']->toArray());

        return view('Admin.Article.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data['category'] = Category::getCateArr();
        return view('Admin.Article.create',$data);
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
        $data = [
            'title'     => trim(Input::get('title')),
            'content'   => Input::get('test-editormd-markdown-doc'),
            'user_id'   => /*Auth::user()->id*/ '2' //还没写登陆
        ];
        $tags = Input::get('tag');
        $mergeTags = Article::attachThisTags($tags);
        $category = Input::get('category');

        try {
            $article =  Article::create($data);

            if ($article) {
                $article->attachTag($mergeTags);
                $article->attachCate([$category]);
                $article->getViews()->create(['art_id' => $article->id]);
                reminder()->success(config("code.".Article::ARTICLE_CREATE_SUCCESS),'创建成功');
                return redirect()->route('article.index');
            }

        } catch (\Exception $e) {
            reminder()->error(config("code.".Article::ARTICLE_CREATE_ERROR),'创建失败');
            return redirect()->back()->withErrors(array('error' => $e->getMessage()))->withInput();
        }
        reminder()->error(config("code.".Article::ARTICLE_CREATE_ERROR),'创建失败');
        return redirect()->back();
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


    public function uploadPhotosByEditor()
    {

    }
}
