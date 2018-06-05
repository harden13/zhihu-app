<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Mail;
use Naux\Mail\SendCloudTemplate;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'confirmation_token', 'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 发送验证邮件
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        // 模板变量
        $bind_data = [
            'url' => url('password/reset', $token)
        ];

        $template = new SendCloudTemplate('zhihuResetPassword', $bind_data);

        Mail::raw($template, function ($message) {
            $message->from('80114019@qq.com', 'harden');

            $message->to($this->email);
        });
    }

    /**
     * 判断用户是否是该问题的所有者
     * @param Model $model
     * @return bool
     */
    public function owns(Model $model)
    {
        return $this->id == $model->user_id;
    }

    /**
     * 返回用户的所有答案
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * 返回用户关注的所有问题
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function follows()
    {
        return $this->belongsToMany(Question::class, 'user_question')->withTimestamps();
    }

    /**
     * 关注某个问题
     * @param $question
     * @return array
     */
    public function followThis($question)
    {
        return $this->follows()->toggle($question);
    }

    /**
     * 判断用户是否关注过该问题
     * @param $question
     * @return bool
     */
    public function followed($question)
    {
        return !! $this->follows()->where('question_id', $question)->count();
    }

    /**
     * 返回用户关注的所有用户
     * @return mixed
     */
    public function followers()
    {
        return $this->belongsToMany(self::class, 'followers', 'follower_id', 'followed_id')->withTimestamps();
    }

    /**
     * 判断用户是否关注过
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followersUser()
    {
        return $this->belongsToMany(self::class, 'followers', 'followed_id', 'follower_id')->withTimestamps();
    }

    /**
     * 关注用户
     * @param $user
     * @return mixed
     */
    public function followThisUser($user)
    {
        return $this->followers()->toggle($user);
    }
    
}
