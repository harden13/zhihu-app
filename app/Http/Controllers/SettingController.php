<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{


    /**
     * SettingController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('users.setting');
    }

    public function store(Request $request)
    {
        $settings = array_merge(user()->settings, array_only($request->all(), ['city', 'bio']));
        user()->update(['settings' => $settings]);
        flash('修改成功', 'success');
        return back();
    }
}
