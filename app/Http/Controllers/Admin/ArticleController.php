<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\File;

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


    /**
     * 编辑器自带上传图片处理方法 (此方法并未验证图片安全性,需要请自行添加)
     * @date 2016年09月12日18:20:32
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadPhotosByEditor()
    {
        $form_data = Input::all();

        $photo = $form_data['editormd-image-file'];

        $original_name = $photo->getClientOriginalName();
        $original_name_without_ext = substr($original_name, 0, strlen($original_name) - 4);

        $filename = $this->sanitize($original_name_without_ext);
        $allowed_filename = $this->createUniqueFilename( $filename );

        $filename_ext = $allowed_filename .'.jpg';

        $manager = new ImageManager();
        $image = $manager->make( $photo )->encode('jpg')->save(env('UPLOAD_PATH') . $filename_ext );

        if( !$image) {
            return response()->json([
                'success' => 0,
                'message' => '图片上传失败',
            ]);

        } else {
            return response()->json([
                'success' => 1,
                'message' => '图片上传成功',
                'url' => "/uploads/".$filename_ext
            ]);
        }
    }

    /**
     * 上传图片带的
     * @param $string
     * @param bool $force_lowercase
     * @param bool $anal
     * @return mixed|string
     */
    private function sanitize($string, $force_lowercase = true, $anal = false)
    {
        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<", ".", ">", "/", "?");
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;

        return ($force_lowercase) ?
            (function_exists('mb_strtolower')) ?
                mb_strtolower($clean, 'UTF-8') :
                strtolower($clean) :
            $clean;
    }

    /**
     * 编辑器上传图片命名
     * @param $filename
     * @return string
     */
    private function createUniqueFilename( $filename )
    {
        $upload_path = env('UPLOAD_PATH');
        $full_image_path = $upload_path . $filename . '.jpg';

        if ( File::exists( $full_image_path ) )
        {
            // Generate token for image
            $image_token = substr(sha1(mt_rand()), 0, 5);
            return $filename . '-' . $image_token;
        }

        return $filename;
    }

}
