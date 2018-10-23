<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\User;
use Cache;
use Illuminate\Http\Request;
use App\Notifications\EmailVerificationNotification;
use Mail;
class EmailVerificationController extends Controller
{
    public function verify(Request $requset){
        // 从url中获取email跟token
        $email=$requset->input('email');
        $token=$requset->input('token');
        // 如果有一个为空说明不是一个合法的验证链接，直接抛出异常
        if(!$email || !$token){
            throw new Exception('验证链接不正确');
        }
        // 从缓存中读取数据，我们把从url中获取的token与缓存中的值做对比
        // 如果缓存不存在或者返回的值与url中的token不一致就抛出异常
        if($token!=Cache::get('email_verification_'.$email)){
            throw new Exception('验证链接不正确或已过期');
        }
        // 根据邮箱从数据库中获取对应的用户
        // 通常来说，能通过token校验的情况下不可能出现用户不存在
        // 但是为了代码的健壮性我们还是需要做这个判断
        if(!$user=User::where('email',$email)->first()){
            throw new Exception('用户不存在');
        }
        // 将指定的key从缓存中删除，由于已经完成了验证，这个缓存就没必要继续保留
        Cache::forget('email_verification_'.$email);
        // 最关键的是，要把对应用户的email_verified字段改为true
        $user->update(['email_verified'=>true]);
        // 最后告知用户邮箱验证成功
        return view('pages.success',['msg'=>'邮箱验证成功']);

    }
    public function send(Request $requset){
        $user=$requset->user();
        if($user->email_verified){
            throw new Exception('你已经验证过邮箱了');
        }
        // 调用notify()方法用来发送我们定义好的通知类
        $user->notify(new EmailVerificationNotification());
        return view('pages.success', ['msg' => '邮件发送成功']);
    }
}
