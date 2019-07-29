<?php
/**
 * Created by PhpStorm.
 * User: illya
 * Date: 23.07.2019
 * Time: 16:44
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Image;
class UserController extends Controller
{
    public function profile()
    {
        if(Auth::user() == NULL)
        {
            return redirect('home');
        }
        return view('profile',array('user'=>Auth::user()));
    }
    public function update_avatar(Request $request){
        $user = Auth::user();
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed']
        );
        // Handle the user upload of avatar
        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, 300)->save( public_path('/uploads/avatars/' . $filename ) );
            $user->avatar = $filename;
        }
        if(trim($request->get("email")) != "" and $request->get("email") != $user->email)
            $user->email = $request->get("email");
        if(isEmpty($request->get("password")) == false)
            $user->password = bcrypt($request->get("password"));
        $user->save();
        return redirect('home');
    }

}