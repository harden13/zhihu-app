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

    public function owns(Model $model)
    {
        return $this->id == $model->user_id;
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function follows()
    {
        return $this->belongsToMany(Question::class, 'user_question')->withTimestamps();
    }

    public function followThis($question)
    {
        return $this->follows()->toggle($question);
    }

    public function followed($question)
    {
        return !! $this->follows()->where('question_id', $question)->count();
    }
}
