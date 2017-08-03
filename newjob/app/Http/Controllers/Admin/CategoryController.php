<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests;
use App\Http\Model\Category;

class CategoryController extends CommonController
{
    //get.admin/category  全部分类列表
    public function index()
    {
        //第一种方法
        $data = (new Category) -> tree();

        //第二种方法
        //$categorys = Category::tree();
        
    	//$data = $this->getTree($categorys,'cate_name','cate_id','cate_pid');
    	return view('admin.category.index') ->with('data',$data);
    }

    //排序的方法
    public function changeorder()
    {
       $input = Input::all();
       $cate = Category::find($input['cate_id']);
       $cate ->cate_order = $input['cate_order'];
       $re = $cate->update();
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
    
    //get.admin/category/create 	添加分类
    public function create()
    {
        $data = Category::where('cate_pid',0)->get();
        return view('admin/category/add',compact('data'));
    }
        //post.admin/Category   添加分类方法提交
    public function store()
    {
        $input = Input::except('_token');

        $rules = [
            'cate_name' => 'required',];
        $message = [
            'cate_name.required' => '分类名称不能为空'];

        $validator = Validator::make($input,$rules,$message);

        if($validator -> passes()){
                $re = Category::create($input);
                if($re){
                    return redirect('admin/category');
                }else{
                    return back()->with('errors','添加分类失败');
                }
            }else{
                return back() -> withErrors($validator);
                
            }
       
    }
    //get.admin/category/{category}   显示单个分类
    public function show()
    {

    }
    //put.admin/category/{category}   	更新分类
    public function update($cate_id)
    {
        $input = Input::except('_token','_method');
        $re = Category::where('cate_id',$cate_id)->update($input);
        if($re){
            return redirect('admin/category');
        }else{
            return back()->with('errors','分类更新失败');
        }
    }
    //delete.admin/category/{category}   删除单个分类
    public function destroy($cate_id)
    {
        $re = Category::where('cate_id',$cate_id)->delete();
        Category::where('cate_pid',$cate_id)->update(['cate_pid' => 0]);
        if($re){
            $data = [
            'status' => 0,
            'msg' => '分类删除成功',
            ];
        }else{
            $data = [
            'status' => 0,
            'msg' => '分类删除失败',
            ];
        }
        return $data;
    }
    //get.admin/category/{category}/edit   编辑分类
    public function edit($cate_id)
    {
        $field = Category::find($cate_id);
        $data = Category::where('cate_pid',0)->get();
        return view('admin.category.edit',compact('field','data'));
    }
    public function ad99()
    {
        for($i=1;$i<10;$i++){
            echo "<br>";
            for($j=1;$j<=$i;$j++){
                echo '<td>'.$j.'X'.$i.'='.$i*$j.'</td>'.'&nbsp';
            }
        }
    }    
}
