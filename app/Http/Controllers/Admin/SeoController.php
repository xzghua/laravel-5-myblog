<?php

namespace App\Http\Controllers\Admin;

use App\Models\Seo;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\CountValidator\Exception;

class SeoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $seo = Seo::all()->toArray();
        $data['seo'] = empty($seo) ? $seo : $seo['0'];
        return view('Admin.Setting.Seo.index',$data);
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
        $data = [
            'title'         => trim($request->get('title')),
            'theme'         => trim($request->get('theme')),
            's_title'       => trim($request->get('s_title')),
            'description'   => trim($request->get('description')),
            'seo_key'       => trim($request->get('seo_key')),
            'seo_des'       => trim($request->get('seo_des')),
            'record_number' => trim($request->get('record_number')),
        ];

        try {
            if (!empty(Seo::all()->toArray())) {
                DB::table('system')->truncate();
            }

           if (Seo::create($data)) {
               reminder()->success(config("code.".Seo::SEO_SAVE_SUCCESS), '操作成功');
               return redirect()->route('seo.index');
           }

        } catch (Exception $e) {
            reminder()->error(config("code.".Seo::SEO_SAVE_ERROR), '操作失败');
            return redirect()->back()->withErrors(array('error' => $e->getMessage()))->withInput();
        }

        reminder()->error(config("code.".Seo::SEO_SAVE_ERROR), '操作失败');
        return redirect()->route('seo.index');
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
