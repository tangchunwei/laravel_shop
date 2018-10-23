<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Str;
use Cache;

class EmailVerificationNotification extends Notification implements ShouldQueue
{
    use Queueable;


    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // 使用laravel内置的str类生成随机字符串，参数就是要生成字符串的长度
        $token=Str::random(16);
        // 往缓存中写入这个随机字符串，有效时间为1800秒
        Cache::set('email_verification_'.$notifiable->email,$token,1800);
        $url=route('email_verification.verify',['email'=>$notifiable->email,'token'=>$token]);
        return (new MailMessage)
                    ->greeting($notifiable->name.'您好：')
                    ->subject('注册成功，请验证您的邮箱')
                    ->line('请点击下方链接验证您的邮箱')
                    ->action('验证',$url);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
