<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;

/**
 * Class EmailController
 * @package App\Http\Controllers
 */
class EmailController extends Controller
{
    /**
     * @param $token
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * 发送认证邮件
     */
    public function verify($token)
    {
        $user = User::where('confirmation_token', $token)->first();

        if (is_null($user)) {
            flash('邮箱认证失败！', 'danger');
            return redirect('/');
        }

        $user->is_active = 1;
        $user->confirmation_token = str_random(40);
        $user->save();
        Auth::login($user);
        flash('邮箱认证成功！')->success();
        return redirect('/home');
    }
}
