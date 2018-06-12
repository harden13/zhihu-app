<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\Request;
use Hash;

/**
 * Class PasswordController
 * @package App\Http\Controllers
 */
class PasswordController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 修改密码页面
     */
    public function reset()
    {
        return view('users.reset');
    }

    /**
     * @param ChangePasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * 修改密码
     */
    public function update(ChangePasswordRequest $request)
    {
        if (Hash::check($request->get('old_password'), user()->password)) {
            user()->password = bcrypt($request->get('password'));
            user()->save();
            flash('密码修改成功', 'success');
            return back();
        }
        flash('密码修改失败', 'danger');
        return back();
    }
}
