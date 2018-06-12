<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;


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

    public function show(DatabaseNotification $notificationId)
    {
        $notificationId->markAsRead();
        return redirect(\Request::query('redirect_url'));
    }
}
