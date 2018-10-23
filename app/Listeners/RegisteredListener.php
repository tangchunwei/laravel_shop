<?php

namespace App\Listeners;
use App\Notifications\EmailVerificationNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisteredListener implements ShouldQueue 
{
    public function __construct()
    {
        //
    }
    // 当事件被触发时，对应该事件的handle()方法就会被调用
    public function handle(Registered $event)
    {
        // 获取到刚刚注册的用户
        $user=$event->user;
        // 调用notify发送通知
        $user->notify(new EmailVerificationNotification());
    }
}
