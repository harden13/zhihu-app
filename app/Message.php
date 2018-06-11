<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Message
 * @package App
 */
class Message extends Model
{
    /**
     * @var string
     */
    protected $table = 'messages';

    /**
     * @var array
     */
    protected $fillable = ['from_user_id', 'to_user_id', 'body', 'dialog_id'];

    /**
     * 获取私信的发件人
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    /**
     * 获取私信的收件人
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    /**
     * 私信标记为已读
     */
    public function markAsRead()
    {
        if (is_null($this->read_at)) {
            $this->forceFill([
                'has_read' => 'T',
                'read_at' => $this->freshTimestamp()
            ])->save();
        }
    }

    /**
     * @param array $models
     * @return MessageCollection
     */
    public function newCollection(array $models =[])
    {
        return new MessageCollection($models);
    }
}
