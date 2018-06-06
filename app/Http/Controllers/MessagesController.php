<?php

namespace App\Http\Controllers;

use Auth;
use App\Repositories\MessageRepository;

class MessagesController extends Controller
{
    protected $message;

    /**
     * MessagesController constructor.
     * @param $message
     */
    public function __construct(MessageRepository $message)
    {
        $this->message = $message;
    }

    /**
     * 保存用户私信
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $message = $this->message->create([
            'to_user_id' => request('user'),
            'from_user_id' => Auth::guard('api')->user()->id,
            'body' => request('body')
        ]);
        if ($message) {
            return response()->json(['status' => true]);
        }
        return response()->json(['status' => false]);
    }
}
