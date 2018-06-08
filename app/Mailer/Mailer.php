<?php
/**
 * Created by PhpStorm.
 * User: young
 * Date: 2018/6/6
 * Time: 上午10:52
 */

namespace App\Mailer;


use Naux\Mail\SendCloudTemplate;
use Mail;

/**
 * Class Mailer
 * @package App\Mailer
 */
class Mailer
{
    /**
     * @param $template
     * @param $email
     * @param $data
     * 发送邮件
     */
    protected function sendTo($template, $email, $data)
    {

        $template = new SendCloudTemplate($template, $data);

        Mail::raw($template, function ($message) use ($email) {
            $message->from('80114019@qq.com', 'harden');

            $message->to($email);
        });
    }
}