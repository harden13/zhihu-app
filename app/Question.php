<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Question
 * @package App
 */
class Question extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['title', 'body', 'user_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * 返回问题的话题
     */
    public function topics()
    {
        return $this->belongsToMany(Topic::class)->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 返回问题的所有者
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param $query
     * @return mixed
     * 判断问题是否展示
     */
    public function scopePublished($query)
    {
        return $query->where('is_hidden', 'F');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * 返回问题的答案
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * 返回问题的关注者
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_question')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     * 返回问题的答案
     */
    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }
}