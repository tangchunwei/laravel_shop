<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;
use Endroid\QrCode\QrCode;
use App\Exceptions\InvalidRequestException;
class PaymentController extends Controller
{
    public function payByAlipay(Order $order,Request $request){
        // 判断订单是否属于当前用户
        $this->authorize('own',$order);
        // 订单已支付或者已关闭
        if($order->paid_at || $order->closed){
            throw new InvalidRequestException('订单状态不正确');
        }
        // 调用支付宝的网页支付
        return app('alipay')->web([
            'out_trade_no' => $order->no,
            'total_amount' => $order->total_amount,
            'subject' => '支付 品优 shop 的订单：'.$order->no,
        ]);
    }
    // 判断前端回调
    public function alipayReturn(){
        // 检验提交的参数是否合法
        try{
            app('alipay')->verify();
        }catch(\Exception $e){
            return view('pages.error',['msg' => '数据不正确']);
        }
        return view('pages.success',['msg' => '付款成功']);
    }
    // 服务器端回调
    public function alipayNotify(){
        // 检验输入参数
        $data=app('alipay')->verify();
        // 拿到订单流水号，并在数据库中查询
        $order=Order::where('no',$data->out_trade_no)->first();
        // 正常来说不太可能出现支付了一笔不存在的订单，这个判断只是加强了系统的健壮性
        if(!$order){
            return 'fail';
        }
        // 如果这笔订单的状态是已支付
        if($order->paid_at){
            // 返回数据给支付宝
            return app('alipay')->success();
        }
        $order->update([
            'paid_at'  => Carbon::now(),//支付时间
            'payment_method'  => 'alipay',
            'payment_no' => $data->trade_no,//支付宝订单号
        ]);
        return app('alipay')->success();
    }
    // 微信支付
    public function payByWechat(Order $order,Request $request){
        // 检验权限
        $this->authorize('own',$order);
        // 检验订单状态
        if($order->paid_at || $order->closed){
            throw new InvalidRequestException('订单状态不正确');
        }
        // 调用微信支付
        $wechatOrder= app('wechat_pay')->scan([
            'out_trade_no' => $order->no,//订单流水
            'total_fee' => $order->total_amount * 100,  //微信支付金额单位是分
            'body' => '支付 淡定电子商城  的订单'.$order->no //订单描述
        ]);
        $qrCode=new QrCode($wechatOrder->code_url);
        // 将生成的二维码图片输出，并带上响应类型
        return response($qrCode->writeString(),200,['Content-Type' => $qrCode->getContentType()]);
    }
    // 微信服务器回调
    public function wechatNotify(){
        // 检验回调参数是否正确
        $data=app('wechat_pay')->verify();
        // 找到对应的订单
        $order = Order::where('no',$data->out_trade_no)->first();
        // 订单不存在则告知微信支付
        if(!$order){
            return 'fail';
        }
        // 订单已支付
        if($order->paid_at){
            // 告知微信支付此订单已处理
            return app('wechat_pay')->success();
        }
        // 将订单标记为已支付
        $order->update([
            'paid_at' =>Carbon::now(),
            'payment_method' => 'wechat',
            'payment_no' => $data->transaction_id,
        ]);
        return app('wechat_pay')->success();
    }
}
