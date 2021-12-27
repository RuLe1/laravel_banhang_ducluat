<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Social;
use App\Models\LoginFacebook;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function test(){
        return view('pages.test');
    }
    public function login_facebook(){
        return Socialite::driver('facebook')->redirect();
    }

    public function callback_facebook(){
        $provider = Socialite::driver('facebook')->user();
        $account = Social::where('provider','facebook')->where('provider_user_id',$provider->getId())->first();
        if($account){
            //login in vao trang quan tri  
            $account_name = LoginFacebook::where('admin_id',$account->user)->first();
            Session::put('admin_name',$account_name->admin_name);
            Session::put('admin_id',$account_name->admin_id);
            return redirect()->route('admin.dashboard')->with('status', 'Đăng nhập Admin thành công');
        }else{

            $luat = new Social([
                'provider_user_id' => $provider->getId(),
                'provider' => 'facebook'
            ]);

            $orang = LoginFacebook::where('admin_email',$provider->getEmail())->first();

            if(!$orang){
                $orang = LoginFacebook::create([
                    'admin_name' => $provider->getName(),
                    'admin_email' => $provider->getEmail(),
                    'admin_password' => '',
                    'admin_status' => 1

                ]);
            }
            $luat->login()->associate($orang);
            $luat->save();

            $account_name = LoginFacebook::where('admin_id',$account->user)->first();

            Session::put('admin_name',$account_name->admin_name);
            Session::put('admin_id',$account_name->admin_id);
            return redirect('/dashboard')->with('status', 'Đăng nhập Admin thành công');
        } 
    }
    public function login_google(){
        return Socialite::driver('google')->redirect();
    }

    public function callback_google(){
        $users = Socialite::driver('google')->stateless()->user(); 
       
        $authUser = $this->findOrCreateUser($users,'google');
       
        $account_name = LoginFacebook::where('admin_id',$authUser->user)->first();
        Session::put('admin_name',$account_name->admin_name);
        Session::put('admin_id',$account_name->admin_id);

        return redirect('/dashboard')->with('status', 'Đăng nhập Admin thành công');   
    }

    public function findOrCreateUser($users,$provider){
        $authUser = Social::where('provider_user_id', $users->id)->first();
        if($authUser){
            return $authUser;
        }
            $admin_new = new Social([
                'provider_user_id' => $users->id,
                'provider' => strtoupper($provider)
            ]);  
            $orang = LoginFacebook::where('admin_email',$users->email)->first();
    
                if(!$orang){
                    $orang = LoginFacebook::create([
                        'admin_name' => $users->name,
                        'admin_email' => $users->email,
                        'admin_password' => '',
                        'admin_phone' => '',
                        'admin_status' => 1
                    ]);
                }
            $admin_new->login()->associate($orang);
            $admin_new->save();

            $account_name = LoginFacebook::where('admin_id',$authUser->user)->first();
            Session::put('admin_name',$account_name->admin_name);
            Session::put('admin_id',$account_name->admin_id);
            
            return redirect()->route('admin.dashboard')->with('status', 'Đăng nhập Admin thành công');

        }
}
