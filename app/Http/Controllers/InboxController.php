<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;

/**
 * Class InboxController
 * @package App\Http\Controllers
 */
class InboxController extends Controller
{
    /**
     * InboxController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 私信首页
     */

    public function index()
    {
        $messages = Message::where('to_user_id', user()->id)
            ->orWhere('from_user_id', user()->id)
            ->with(['fromUser' => function ($query) {
                return $query->select(['id', 'name', 'avatar']);
            }, 'toUser' => function ($query) {
                return $query->select(['id', 'name', 'avatar']);
            }])
            ->latest()
            ->get();
        return view('inbox.index', ['messages' => $messages->groupBy('dialog_id')]);
    }
//    public function index()
//    {
//        $userId = user()->id;
//
//        $msgIds = Message::selectRaw('max(id) as id')
//            ->where('from_user_id', $userId)
//            ->orWhere('to_user_id', $userId)
//            ->groupBy('dialog_id')
//            ->pluck('id')
//            ->toArray();
//
//        $messages = Message::with('toUser', 'fromUser')
//            ->whereIn('id', $msgIds)
//            ->get();
//
//        return view('inbox.index', ['messages' => $messages->keyBy('to_user_id')]);
//    }

    /**
     * @param $dialogId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 私信列表展示私信
     */
    public function show($dialogId)
    {
        $messages = Message::where('dialog_id', $dialogId)
            ->with(['fromUser' => function ($query) {
                return $query->select(['id', 'name', 'avatar']);
            }, 'toUser' => function ($query) {
                return $query->select(['id', 'name', 'avatar']);
            }])
            ->latest()->get();
        $messages->markAsRead();
        return view('inbox.show', compact('messages', 'dialogId'));
    }

    /**
     * @param $dialogId
     * @return \Illuminate\Http\RedirectResponse
     * 私信列表页发送私信
     */
    public function store($dialogId)
    {
        $message = Message::where('dialog_id', $dialogId)->first();
        $to_user_id = user()->id === $message->to_user_id ? $message->from_user_id : $message->to_user_id;
        Message::create([
            'to_user_id' => $to_user_id,
            'from_user_id' => user()->id,
            'body' => request('body'),
            'dialog_id' => $dialogId
        ]);
        return back();

    }
}
