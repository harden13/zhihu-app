<?php

namespace App\Http\Controllers;

use App\Notifications\NewMessageNotification;
use App\Repositories\MessageRepository;
use Illuminate\Http\Request;

/**
 * Class InboxController
 * @package App\Http\Controllers
 */
class InboxController extends Controller
{
    protected $message;

    /**
     * InboxController constructor.
     */
    public function __construct(MessageRepository $message)
    {
        $this->middleware('auth');
        $this->message=$message;
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 私信首页
     */

    public function index()
    {
        $messages = $this->message->getAllMessages();
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
        $messages = $this->message->getDialogMessageById($dialogId);
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
        $message = $this->message->getSingleMessageById($dialogId);
        $to_user_id = user()->id === $message->to_user_id ? $message->from_user_id : $message->to_user_id;
        $newMessage = $this->message->create([
            'to_user_id' => $to_user_id,
            'from_user_id' => user()->id,
            'body' => request('body'),
            'dialog_id' => $dialogId
        ]);
        $newMessage->toUser->notify(new NewMessageNotification($newMessage));
        return back();
    }
}
