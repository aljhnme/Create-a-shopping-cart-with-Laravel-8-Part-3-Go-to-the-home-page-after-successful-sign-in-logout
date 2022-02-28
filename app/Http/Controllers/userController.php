<?php
 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\tbl_user;
use Hash;
class userController extends Controller
{
    function insert(Request $request)
    {
        $request->validate([
          'name'                  => 'required',
          'email'                 => 'required',
          'password'              => 'required|min:6|confirmed',
          'address'               => 'required',
        ]);
        
        $user = new tbl_user;

        $user->name     = $request->input('name');
        $user->email    = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->address  = $request->input('address');

        $user->save();

    }

    function check_login(Request $request)
    {
         $request->validate([
           'email_l'    => 'required',
           'password_l' => 'required',
         ]);
          
         if (Auth::attempt(['email' => $request->email_l, 'password' => $request->password_l])) 
         {
         	  return redirect('index');
         }

          return back()->with('failed_lgoin','This account doesn t exist.');
    }

    function logout()
    {
       Session::flush();
       Auth::logout();
       return redirect('/register');
    }
}
