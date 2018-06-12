<?php
/**
 * Created by PhpStorm.
 * User: young
 * Date: 2018/6/6
 * Time: 下午10:39
 */

namespace App\Repositories;


use App\Message;

/**
 * Class MessageRepository
 * @package App\Repositories
 */
class MessageRepository
{
    /**
     * @param array $attributes
     * @return static
     * 保存私信
     */
    public function create(array $attributes)
    {
        return Message::create($attributes);
    }

    /**
     * @return mixed
     * 获取私信列表
     */
    public function getAllMessages()
    {
        return Message::where('to_user_id', user()->id)
            ->orWhere('from_user_id', user()->id)
            ->with(['fromUser' => function ($query) {
                return $query->select(['id', 'name', 'avatar']);
            }, 'toUser' => function ($query) {
                return $query->select(['id', 'name', 'avatar']);
            }])
            ->latest()
            ->get();
    }

    /**
     * @param $dialogId
     * @return mixed
     * 获取对话列表
     */
    public function getDialogMessageById($dialogId)
    {
        return Message::where('dialog_id', $dialogId)
            ->with(['fromUser' => function ($query) {
                return $query->select(['id', 'name', 'avatar']);
            }, 'toUser' => function ($query) {
                return $query->select(['id', 'name', 'avatar']);
            }])
            ->latest()->get();
    }

    /**
     * @param $dialogId
     * @return mixed
     * 根据对话id查找其中一条消息
     */
    public function getSingleMessageById($dialogId)
    {
        return Message::where('dialog_id', $dialogId)->first();
    }
}