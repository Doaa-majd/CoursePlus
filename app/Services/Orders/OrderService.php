<?php

declare(strict_types=1);

namespace App\Services\Orders;

use App\Models\Order;
use App\Models\CourseOrder;

class OrderService
{

    public function getOrders()
    {
        return $orders = Order::with('user')->orderBy('created_at', 'desc')->paginate(6);
    }

    public function showOrder(Order $order)
    {
        return CourseOrder::leftJoin('courses as c', 'c.id', '=', 'course_orders.course_id')
                ->select('course_orders.*', 'c.title as course_name')
                ->where('order_id', $order->id)
                ->paginate(10);
    }
}
