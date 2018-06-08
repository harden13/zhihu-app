<?php
/**
 * Created by PhpStorm.
 * User: young
 * Date: 2018/6/6
 * Time: 下午4:00
 */

namespace App\Mailer;


use App\User;
class UserMailer extends Mailer
{
    /**
     * 发送用户关注邮件
     * @param $email
     */
    public function followNotifyEmail($email)
    {
        $data = ['url' => '127.0.0.1:8000', 'name' => user('api')->name];
        $this->sendTo('zhihu_app_new_user_follow', $email, $data);
    }

    /**
     * 发送密码重置邮件
     * @param $email
     * @param $token
     */
    public function passwordReset($email, $token)
    {
        $data = ['url' => url('password/reset', $token)];
        $this->sendTo('zhihuResetPassword', $email, $data);
    }

    /**
     * 发送用户注册邮件
     * @param User $user
     */
    public function welcome(User $user)
    {
        $data = [
            'url' => route('email.verify', ['token' => $user->confirmation_token]),
            'name' => $user->name
        ];
        $this->sendTo('zhihuRegister', $user->email, $data);
    }
}