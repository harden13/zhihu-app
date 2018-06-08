<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Answer
 * @package App
 */
class Answer extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'question_id', 'body'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 返回答案的所有者
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 返回答案所属的问题
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     * 返回答案的评论
     */
    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }
}
