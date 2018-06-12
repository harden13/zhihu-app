<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function avatar()
    {
        return view('users.avatar');
    }

    public function changeAvatar(Request $request)
    {
        $file = $request->file('img');
        $filename = md5(user()->id.time()).'.'.$file->getClientOriginalExtension();
        $file->move(public_path('avatars'), $filename);
        user()->avatar='/avatars/'.$filename;
        user()->save();
        return ['url'=>user()->avatar];

    }
}
