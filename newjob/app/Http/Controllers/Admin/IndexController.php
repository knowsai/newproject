<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use App\Http\Model\User;


class IndexController extends CommonController
{
    public function index()
    {
        return view('admin.index');
    }
    public function info()
    {
        return view('admin.info');
    }    
    //修改超级管理员密码
    public function pass()
    {
        if($input = Input::all()){
            
            $rules = [
                'password' => 'required|between:6,20|confirmed',
            ];
            $message = [
                'password.required' => '密码不能为空',
                'password.between' => '密码必须在6-20位之间',
                'password.confirmed' => '两次输入的密码不一致',
            ];


            $validator = Validator::make($input,$rules,$message);

            if($validator -> passes()){
                $user = User::first();
                $_password = Crypt::decrypt($user ->user_pass);
                if($input['password_o'] == $_password){
                    $user->user_pass = Crypt::encrypt($input['password']);
                    $user->update();
                    return back()->with('errors','修改密码成功');
                }else{
                    return back()->with('errors','原密码错误！');
                }
            }else{
                return back() -> withErrors($validator);
                dd($validator -> errors() -> all());
            }
        }else{
            return view('admin.pass');
        }
        
    }  
}
