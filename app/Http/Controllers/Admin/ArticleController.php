<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

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
        $data['article'] = Article::sortData($data['paginate']->toArray()['data']);

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
            'user_id'   => Auth::user()->id
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
                $this->curlUrlToBaiDu($article->id);
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
        $art = Article::where('id',$id)
            ->with('getAuthor')
            ->with('getTags')
            ->with('getCategories')
            ->with('getViews')
            ->get()
            ->toArray();
        $data['article'] = Article::sortData($art)['0'];
        $data['category'] = Category::getCateArr();

        return view('Admin.Article.edit',$data);
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
        $data = [
            'title'     => trim($request->get('title')),
            'content'   => $request->get('test-editormd-markdown-doc'),
            'user_id'   => Auth::user()->id
        ];

        $tags = Input::get('tag');
        $mergeTags = Article::attachThisTags($tags,$id);
        $category = $request->get('category');

        try {
            $updateArt =  Article::find($id);

            if ($updateArt) {
                $updateArt->getTags()->sync($mergeTags);
                $updateArt->getCategories()->sync([$category]);
                $this->curlUrlToBaiDu($id);
                if ($updateArt->update($data)) {
                    reminder()->success(config("code.".Article::ARTICLE_UPDATE_SUCCESS),'修改成功');
                    return redirect()->route('article.index');
                }

            } else {
                reminder()->error(config("code.".Article::ARTICLE_UPDATE_ERROR),'修改失败');
                return redirect()->route('article.index');
            }

        } catch (\Exception $e) {
            reminder()->error(config("code.".Article::ARTICLE_UPDATE_ERROR),'修改失败');
            return redirect()->back()->withErrors(array('error' => $e->getMessage()))->withInput();
        }

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
        try {
            if ( Article::destroy($id)) {
                reminder()->success(config("code.".Article::ARTICLE_DELETE_SUCCESS),'删除成功');
                return redirect()->route('article.index');
            } else {
                reminder()->error(config("code.".Article::ARTICLE_DELETE_ERROR),'操作失败');
                return redirect()->route('article.index');
            }

        } catch (\Exception $e) {
            reminder()->error(config("code.".Article::ARTICLE_DELETE_ERROR),'操作失败');
            return redirect()->back()->withErrors(array('error' => $e->getMessage()))->withInput();
        }
    }

    public function curlUrlToBaiDu($id)
    {
        $urls = array(
            'http://www.iphpt.com/detail/'.$id.'/',
        );
        $api = 'http://data.zz.baidu.com/urls?site=www.iphpt.com&token=VAIRqrpBUvP60Hbq';
        $ch = curl_init();
        $options =  array(
            CURLOPT_URL => $api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => implode("\n", $urls),
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        Log::info('curl the url ('.$urls[0].') to baidu,the result is '.$result);
        curl_close($ch);
    }

    /**
     * 列出被删除的文章
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listDeleteArticle()
    {
        $data['paginate'] = Article::onlyTrashed()
            ->orderBy('created_at','desc')
            ->with('getAuthor')
            ->with('getTags')
            ->with('getCategories')
            ->with('getViews')
            ->paginate(12);
        $data['article'] = Article::sortData($data['paginate']->toArray()['data']);

        return view('Admin.Article.deleted',$data);
    }

    /**
     * 恢复文章
     * @date 2016年09月05日18:15:38
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function restoreArticle($id)
    {
//        dd(Article::withTrashed()->where('id', $id)->restore());
        try {
            if ( Article::withTrashed()->where('id', $id)->restore()) {
                reminder()->success(config("code.".Article::ARTICLE_RESTORE_SUCCESS),'操作成功');
                return redirect()->route('article.index');
            } else {
                reminder()->error(config("code.".Article::ARTICLE_RESTORE_ERROR),'操作失败');
                return back();
            }

        } catch (\Exception $e) {
            reminder()->error(config("code.".Article::ARTICLE_RESTORE_ERROR),'操作失败');
            return redirect()->back()->withErrors(array('error' => $e->getMessage()))->withInput();
        }
    }

    public function uploadPhotosByEditor()
    {

    }
}
