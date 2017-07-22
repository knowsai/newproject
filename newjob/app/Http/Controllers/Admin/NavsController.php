<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Model\Navs;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;


class NavsController extends CommonController
{
    public function index()
    {
    	$data = Navs::orderBy('nav_order','asc')->get();
    	return view('admin.navs.index',compact('data'));
    }

    //排序的方法
    public function changeorder()
    {
   		$input = Input::all();
       	$nav = Navs::find($input['nav_id']);
       	$nav ->nav_order = $input['nav_order'];
       	$re = $nav->update();
		if($re){
		    $data = [
		        'status' => 0,
		        'msg' =>'导航排序更新成功, 请稍后刷新'
		        ];
		}else{
		    $data = [
		        'status' => 1,
		        'msg' =>'导航排序更新失败，请稍后重试！'
		        ];
		}
		return $data;
    }
    
    //get.admin/Navs/create 	添加自定义导航栏
    public function create()
    {
    	return view('admin.navs.add');
    }
        //post.admin/Navs   添加自定义导航栏方法提交
    public function store()
    {
    	$input = Input::except('_token');
        $rules = [
            'nav_name' => 'required',
            'nav_url' => 'required'];
        $message = [
            'nav_name.required' => '自定义导航栏名称不能为空',
            'nav_url.required' => '自定义导航栏不能为空'];

        $validator = Validator::make($input,$rules,$message);

        if($validator -> passes()){
                $re = Navs::create($input);
                if($re){
                    return redirect('admin/navs');
                }else{
                    return back()->with('errors','添加自定义导航栏失败');
                }
            }else{
                return back() -> withErrors($validator);
                
            }
    }
    //get.admin/Navs/{Navs}   显示单个自定义导航栏
    public function show()
    {

    }
    //put.admin/Navs/{Navs}   	更新自定义导航栏
    public function update($nav_id)
    {
        $input = Input::except('_token','_method');
        $re = Navs::where('nav_id',$nav_id)->update($input);
        if($re){
            return redirect('admin/navs');
        }else{
            return back()->with('errors','自定义导航栏更新失败');
        }
    }
    //delete.admin/Navs/{Navs}   删除单个自定义导航栏
    public function destroy($nav_id)
    {
        $re = Navs::where('nav_id',$nav_id)->delete();
		if($re){
		    $data = [
		    'status' => 0,
		    'msg' => '自定义导航栏删除成功',
		    ];
		}else{
		    $data = [
		    'status' => 0,
		    'msg' => '自定义导航栏删除失败',
		    ];
		}
		return $data; 
    }
    //get.admin/Navs/{Navs}/edit   编辑自定义导航栏
    public function edit($nav_id)
    {
		$field = Navs::find($nav_id);
		return view('admin.navs.edit',compact('field'));
    }
}
