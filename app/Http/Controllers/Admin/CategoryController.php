<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

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
        return view('Admin.Category.index',$data);

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
        return view('Admin.Category.create',$data);
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
        if ($data['parent_id'] == 'top') $data['parent_id'] = '0';
        Log::info('route is '.$request->url().',the data is '.json_encode($request->all()));
        try {
            if (Category::create($data)) {
                reminder()->success(config("code.".Category::CATEGORY_CREATE_SUCCESS),'创建成功');
                return redirect()->route('category.index');
            }
        } catch (\Exception $e) {
            reminder()->error(config("code.".Category::CATEGORY_CREATE_ERROR),'创建失败');
            return redirect()->back()->withErrors(array('error' => $e->getMessage()))->withInput();
        }
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
        $data['category'] = Category::getCateArr();
        $checkTheId = Category::find($id);

        if (empty($checkTheId)) {
            reminder()->error(config("code.".Category::CATEGORY_ID_NOT_EXIST),'查看失败',getToastParams());
            return redirect()->route('category.index');
        }

        $data['cate'] = Category::where('id',$id)
            ->first()
            ->toArray();

        return view('Admin.Category.edit',$data);

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
        $data = changeHumpToUnderLine($request->all());
        Log::info('route is '.$request->url().',the data is '.json_encode($request->all()));
        if (in_array($data['parent_id'],Category::getChildIdsOfMyself($id))) {
            reminder()->error(config("code.".Category::CATEGORY_UPDATE_NOT_ALLOWED_TO_BE_MYSELF),'更新失败');
            return redirect()->back();
        }

        unset($data['_token']);
        unset($data['_method']);

        if ($data['parent_id'] == 'top') $data['parent_id'] = '0';

        try {
            if (Category::where('id',$id)->update($data)) {
                reminder()->success(config("code.".Category::CATEGORY_UPDATE_SUCCESS),'更新成功');
                return redirect()->route('category.index');
            }
        } catch (\Exception $e) {
            reminder()->error(config("code.".Category::CATEGORY_UPDATE_ERROR),'更新失败');
            return redirect()->back()->withErrors(array('error' => $e->getMessage()))->withInput();
        }
        return redirect()->back();
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
            if (count(Category::getChildIdsOfMyself($id)) == 1 && Category::destroy($id)) {
                reminder()->success(config("code.".Category::CATEGORY_DELETE_SUCCESS),'删除成功');
                return redirect()->route('category.index');
            } else {
                reminder()->error(config("code.".Category::CATEGORY_DELETE_ERROR),'操作失败');
                return redirect()->route('category.index');
            }

        } catch (\Exception $e) {
            reminder()->error(config("code.".Category::CATEGORY_DELETE_ERROR),'操作失败');
            return redirect()->back()->withErrors(array('error' => $e->getMessage()))->withInput();
        }
    }
}
