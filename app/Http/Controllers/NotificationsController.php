<?php

namespace App\Http\Controllers;


/**
 * Class NotificationsController
 * @package App\Http\Controllers
 */
class NotificationsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 站内通知
     */
    public function index()
    {
        $user = user();
        return view('notifications.index', compact('user'));
    }
}
