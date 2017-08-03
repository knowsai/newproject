<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Model\Links;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;


class LinksController extends CommonController
{
    public function index()
    {
    	$data = Links::orderBy('link_order','asc')->get();
    	return view('admin.links.index',compact('data'));
    }

    //排序的方法
    public function changeorder()
    {
   		$input = Input::all();
       	$link = Links::find($input['link_id']);
       	$link ->link_order = $input['link_order'];
       	$re = $link->update();
		if($re){
		    $data = [
		        'status' => 0,
		        'msg' =>'分类排序更新成功, 请稍后刷新'
		        ];
		}else{
		    $data = [
		        'status' => 1,
		        'msg' =>'分类排序更新失败，请稍后重试！'
		        ];
		}
		return $data;
    }
    
    //get.admin/links/create 	添加友情链接
    public function create()
    {
    	return view('admin.links.add');
    }
        //post.admin/links   添加友情链接方法提交
    public function store()
    {
    	$input = Input::except('_token');
        $rules = [
            'link_name' => 'required',
            'link_url' => 'required'];
        $message = [
            'link_name.required' => '友情链接名称不能为空',
            'link_url.required' => '友情链接不能为空'];

        $validator = Validator::make($input,$rules,$message);

        if($validator -> passes()){
                $re = Links::create($input);
                if($re){
                    return redirect('admin/links');
                }else{
                    return back()->with('errors','添加友情链接失败');
                }
            }else{
                return back() -> withErrors($validator);
                
            }
    }
    //get.admin/links/{links}   显示单个友情链接
    public function show()
    {

    }
    //put.admin/links/{links}   	更新友情链接
    public function update($link_id)
    {
        $input = Input::except('_token','_method');
        $re = Links::where('link_id',$link_id)->update($input);
        if($re){
            return redirect('admin/links');
        }else{
            return back()->with('errors','友情链接更新失败');
        }
    }
    //delete.admin/links/{links}   删除单个友情链接
    public function destroy($link_id)
    {
        $re = Links::where('link_id',$link_id)->delete();
		if($re){
		    $data = [
		    'status' => 0,
		    'msg' => '友情链接删除成功',
		    ];
		}else{
		    $data = [
		    'status' => 0,
		    'msg' => '友情链接删除失败',
		    ];
		}
		return $data; 
    }
    //get.admin/links/{links}/edit   编辑友情链接
    public function edit($link_id)
    {
		$field = Links::find($link_id);
		return view('admin.links.edit',compact('field'));
    }
}
