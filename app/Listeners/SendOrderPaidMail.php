<?php

namespace App\Listeners;

use App\Models\Order;
use App\Events\OrderPaid;
use App\Notifications\OrderPaidNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOrderPaidMail implements  ShouldQueue
{

    public function __construct()
    {
    }


    public function handle(OrderPaid $event)
    {
        //从事件对象中取出对应的订单
        $order=$event->getOrder();
        //调用notify方法来发送通知
        $order->user->notify(new OrderPaidNotification($order));
    }
}
