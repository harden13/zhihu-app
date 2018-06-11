<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;

/**
 * Class MessageCollection
 * @package App
 */
class MessageCollection extends Collection
{
    /**
     * 私信标记为已读
     */
    public function markAsRead()
    {
        $this->each(function ($message) {
            if (user()->id === $message->to_user_id) {
                $message->markAsRead();
            }
        });
    }
}