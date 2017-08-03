<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Model\Article;

use App\Http\Requests;
use App\Http\Model\Category;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;


class ArticleController extends CommonController
{
    //get.admin/article  全部文章列表
    public function index()
    {
        $data = Article::orderBy('art_id','desc')->paginate(3);
    	return view('admin.article.index',compact('data'));
    }
    //get.admin/article/create 	添加文章
    public function create()
    {
        $data = (new Category) -> tree();
        return view('admin/article/add',compact('data'));
    }
    //post.admin/article   添加文章方法提交
    public function store()
    {
        $input = Input::except('_token');
        $input['art_time'] = time();

        $rules = [
            'art_title' => 'required',
            'art_content' => 'required',];
        $message = [
            'art_title.required' => '文章名称不能为空',
            'art_content.required' => '文章内容不能为空',
            ];

        $validator = Validator::make($input,$rules,$message);

        if($validator -> passes()){
                $re = Article::create($input);
                if($re){
                    return redirect('admin/article');
                }else{
                    return back()->with('errors','数据填充失败，请稍后重试！');
                }
            }else{
                return back() -> withErrors($validator);
                
            }
    }
    //get.admin/article/{article}/edit编辑文章
    public function edit($art_id)
    {
        $field = Article::find($art_id);
        $data = (new Category) -> tree();
        return view('admin.article.edit',compact('field','data'));
    }
    //put.admin/article/{article}     更新文章
    public function update($art_id)
    {
        $input = Input::except('_token','_method');
        $re = Article::where('art_id',$art_id)->update($input);
        if($re){
            return redirect('admin/article');
        }else{
            return back()->with('errors','文章更新失败');
        }
    }
    //delete.admin/article/{article}   删除单个分类
    public function destroy($art_id)
    {
        $re = Article::where('art_id',$art_id)->delete();
        if($re){
            $data = [
            'status' => 0,
            'msg' => '文章删除成功',
            ];
        }else{
            $data = [
            'status' => 0,
            'msg' => '文章删除失败',
            ];
        }
        return $data;
    }
}
