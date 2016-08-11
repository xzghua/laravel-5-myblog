<?php

namespace App\Http\Controllers\Admin;

use App\Models\Link;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Mockery\CountValidator\Exception;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $link = Link::orderBy('ordering','asc')
            ->paginate(12);

        $data['link'] = $link;
        return view('Admin.Setting.Link.index',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Admin.Setting.Link.create');
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
        try {
            if (Link::create($request->all())) {
                reminder()->success(config("code.".Link::LINK_SAVE_SUCCESS),'创建成功');
                return redirect()->route('link.index');
            }

        } catch (Exception $e) {
            reminder()->error(config("code.".Link::LINK_SAVE_ERROR), '操作失败');
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
        if (!Link::find($id)) {
            reminder()->error(config("code.".Link::LINK_ID_NOT_EXIST), '操作失败');
            return redirect()->back();
        }

        $data['link'] = Link::find($id)->toArray();
        return view('Admin.Setting.Link.edit',$data);

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
        $data = $request->all();
        unset($data['_method']);
        unset($data['_token']);
        try {
            if (Link::where('id',$id)->update($data)) {
                reminder()->success(config("code.".Link::LINK_SAVE_SUCCESS),'创建成功');
                return redirect()->route('link.index');
            }

        } catch (Exception $e) {
            reminder()->error(config("code.".Link::LINK_SAVE_ERROR), '操作失败');
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
            if (Link::destroy($id)) {
                reminder()->success(config("code.".Link::LINK_DELETE_SUCCESS),'操作成功');
                return redirect()->route('link.index');
            }

        } catch (Exception $e) {
            reminder()->error(config("code.".Link::LINK_DELETE_ERROR), '操作失败');
            return redirect()->back()->withErrors(array('error' => $e->getMessage()))->withInput();
        }

        return redirect()->back();
    }
}
