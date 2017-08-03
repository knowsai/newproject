<?php

namespace App\Http\Controllers\Admin;
use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Crypt;

require_once 'resources/org/code/Code.class.php';

class LoginController extends CommonController
{
    public function login()
    {
        if($input = Input::all()){
            $code = new \Code;
            $_code = $code->get();
            if(strtoupper($input['code'])!=$_code){
                return back()->with('msg','验证码错误！');
            }
            $user = User::first();
            if($user->user_name != $input['user_name'] || Crypt::decrypt($user->user_pass) != $input['user_pass']){
                return back()->with('msg','用户名或密码错误！');
            }

            session(['user' => $user]);
            return redirect('admin/index');

        }else {
            
            return view('admin.login');

        }
    }

    public function code()
    {
        $code = new \Code;
        $code->make();
    }
    
    public function quit()
    {
        session(['user' =>null]);
        return redirect('admin/login');
    }   

    public function crypt()
    {
        $str = '123456';
        $str_p = 'eyJpdiI6ImpiWldjZUJYd1plYjF0bEtMYVZ5TkE9PSIsInZhbHVlIjoiVU9QaGxSZ1pmYnJITHUxbFpsWlNQUT09IiwibWFjIjoiMjQyZTU1ZDc4YTQ4NTc1ZGZhZjNjMjBiNTM5ZTJhODI1NGY3MzU2YjYyOTE0NjhjOGZmM2Q5NWE4OWRhOTc1YiJ9';
        echo Crypt::encrypt($str);
        echo "<br />";
        echo Crypt::decrypt($str_p);
        $admin =  \DB::table('blogs')->get();
        print_r($admin);
    }

}
