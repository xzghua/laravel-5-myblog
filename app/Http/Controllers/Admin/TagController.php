<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['tag'] = Tag::orderBy('tag_number','desc')
            ->paginate(12);
        return view('Admin.Tag.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Admin.Tag.create');
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

        if (Tag::where('tag_name',$data['tag_name'])->value('id')) {
            reminder()->error(config("code.".Tag::TAG_NAME_IS_EXIST),'创建失败');
            return redirect()->back();
        }

        unset($data['_token']);
        try {
            if (Tag::create($data)) {
                reminder()->success(config("code.".Tag::TAG_CREATE_SUCCESS),'创建成功');
                return redirect()->route('tag.index');
            }
        } catch (\Exception $e) {
            reminder()->error(config("code.".Tag::TAG_CREATE_ERROR),'创建失败');
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
        if (!Tag::find($id)) {
            reminder()->error(config("code.".Tag::TAG_ID_NOT_EXIST),'操作失败');
            return redirect()->back();
        }

        $data['tag'] = Tag::find($id);
        return view('Admin.Tag.edit',$data);

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
        $data = changeHumpToUnderLine($request->all());
        Log::info('route is '.$request->url().',the data is '.json_encode($request->all()));

        $checkTagId = Tag::where('tag_name',$data['tag_name'])->value('id');
        if ($checkTagId != null && $checkTagId != $id ) {
            reminder()->error(config("code.".Tag::TAG_NAME_IS_EXIST),'操作失败');
            return redirect()->back();
        }

        unset($data['_token']);
        unset($data['_method']);
        try {
            if (Tag::where('id',$id)->update($data) >= 0) {
                reminder()->success(config("code.".Tag::TAG_UPDATE_SUCCESS),'更新成功');
                return redirect()->route('tag.index');
            }
        } catch (\Exception $e) {
            reminder()->error(config("code.".Tag::TAG_UPDATE_ERROR),'更新失败');
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

        $tag = Tag::find($id);

        $log = 'destroy the Tag , the ID is'.$id;
        if (!$tag) {
            reminder()->error(config("code.".Tag::TAG_ID_NOT_EXIST),'操作失败');
            Log::info($log.'errorCode is '.config("code.".Tag::TAG_ID_NOT_EXIST));
            return redirect()->back();
        }
        try {
            if ( $tag->getTags()->detach() >= 0  && Tag::destroy($id)) {
                reminder()->success(config("code.".Tag::TAG_DELETE_SUCCESS),'删除成功');
                Log::info($log.'errorCode is '.config("code.".Tag::TAG_DELETE_SUCCESS));
                return redirect()->route('tag.index');
            }
        } catch (\Exception $e) {
            reminder()->error(config("code.".Tag::TAG_DELETE_ERROR),'删除失败');
            Log::info($log.'errorCode is '.config("code.".Tag::TAG_DELETE_ERROR));
            return redirect()->back()->withErrors(array('error' => $e->getMessage()))->withInput();
        }

        return redirect()->back();
    }

    /**
     * 写文章时,自动填充标签
     * @date 2016年08月09日18:55:44
     * @return \Illuminate\Http\JsonResponse
     */
    public function autoFillTags()
    {
        $term = Input::get('term');
        return response()->json(Tag::where('tag_name','like',"%$term%")->lists('tag_name')->toArray());
    }
}
