<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
class CommonController extends Controller
{
    public function upload()
    {
    	$file = Input::file('Filedata');
    	//检验文件是否有效
    	if($file ->isValid()){
    		$entension = $file ->getClientOriginalExtension();//获取上传文件的后缀
    		$newName = date('YmdHis').mt_rand(100,999).'.'.$entension;
    		$path = $file ->move(base_path().'/uploads',$newName);//移动文件
    		$filepath ='uploads/'.$newName;
    		return $filepath;//返回文件路径信息
    	}
    }
}
