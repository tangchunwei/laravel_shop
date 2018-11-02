<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;
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
}
