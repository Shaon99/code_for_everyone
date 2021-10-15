<?php

namespace App\Http\Controllers\Admin;

use App\LogActivity;
use App\Models\Admin;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;

class adminController extends Controller
{
    public function index()
    {
        return view('admin.login.index');
    }
//login
    public function check(Request $req){
        $validated = $req->validate([
        'email' => 'required|max:25|min:4',
        'password' => 'required|string|min:8|max:20',
    
        ]);

        $userInfo=Admin::where('email','=',$req->email)->first();

        if(!$userInfo){
            return back()->with('fail','Invalid Username');
        }
        else{
            if(Hash::check($req->password, $userInfo->password) &&  $userInfo->role=="Admin"){
                $req->session()->put('LoggedUser', $userInfo->id);
                return redirect('/admin/dashboard');
            }
            else{
                return back()->with('fail','Incorrect password');
            } 
        }
}
//view

    public function dashboard()
    {

        $d=['LoggedUserInfo'=>Admin::where('id','=',session('LoggedUser'))->first()];

    
        return view('admin.dashboard',$d);
    }

  

//logout
    public function logout(){
        if(session()->has('LoggedUser')){
          session()->pull('LoggedUser');
            return redirect('/admin/login');
        }
        
    }


}
