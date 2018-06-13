<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class SettingController
 * @package App\Http\Controllers
 */
class SettingController extends Controller
{


    /**
     * SettingController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 更新用户资料
     */
    public function index()
    {
        return view('users.setting');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * 保存用户资料
     */
    public function store(Request $request)
    {
        user()->setting()->merge($request->all());
        flash('修改成功', 'success');
        return back();
    }
}
