<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Rry\Reminder\Reminder;

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['category'] = Category::getCateArr();
        return view('Admin.Category.categoryList',$data);

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
        return view('Admin.Category.createCategory',$data);
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
        $data = changeHumpToUnderLine($request->all());
        Log::info('route is '.$request->url().',the data is '.json_encode($request->all()));
        try {
            if (Category::create($data)) {
                reminder()->success(config("code.".Category::CREATE_CATEGORY_ERROR),'创建失败');
                return redirect()->route('category.index');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(array('error' => $e->getMessage()))->withInput();
        }
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
        $data['category'] = Category::getCateArr();
        $checkTheId = Category::find($id);

        if (empty($checkTheId)) {
            reminder()->error(config("code.".Category::CATEGORY_ID_NOT_EXIST),'查看失败',getToastParams());
            return redirect()->route('category.index');
        }

        $data['cate'] = Category::where('id',$id)
            ->first()
            ->toArray();

        return view('Admin.Category.editCategory',$data);

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
        dd($id);
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
        dd($id);
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
