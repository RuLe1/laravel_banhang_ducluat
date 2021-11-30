<?php
namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(){
        return view('admin_login');
    }
    //dùng Auth để đăng nhập thì phải tạo name, email, pass theo hệ thống
    public function login(Request $request){
        $credentials = $request->only('email','password');
        if (Auth::guard('admin')->attempt($credentials)) {
           return redirect()->route('admin.dashboard');//admin.dashboard là name của cái route
        }else{
            return redirect('/admin')->with('status','Email hoặc mật khẩu sai');
        }
    }
    public function dashboard(){ 
        if(Auth::guard('admin')->check()){
            $adminUser = Auth::guard('admin')->user();
            return view('admin.dashboard',['user'=>$adminUser]);
        }else{
            return redirect('/admin');
        }    
    }
    public function logout(){ 
        Auth::guard('admin')->logout();
            return redirect('/admin');
        }
}
