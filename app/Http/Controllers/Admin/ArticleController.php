<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


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
        $articlePag = Article::orderBy('created_at','desc')
            ->with('getAuthor')
            ->with('getTags')
            ->with('getCategories')
            ->with('getViews')
            ->paginate(20);

        $allData = $articlePag->toArray();

        foreach ($allData['data'] as $key => $item) {
            $allData['data'][$key]['author'] = $item['get_author']['name'];
            $allData['data'][$key]['views']  = $item['get_views']['view_num'];
            if (!empty($item['get_tags'])) {
                $allData['data'][$key]['tags'] = implode(',',array_column($item['get_tags'], 'tag_name'));
            } else {
                $allData['data'][$key]['tags'] = '';
            }

            if (!empty($item['get_categories'])) {
                $allData['data'][$key]['categories'] = implode(',',array_column($item['get_categories'], 'cate_name'));
            } else {
                $allData['data'][$key]['categories'] = '';
            }
        }

        $data['paginate'] = $articlePag;
        $data['article'] = $allData;

        return view('Admin.Article.articleList',$data);
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
