<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Orders\OrderService;
use App\Models\Order;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $orders = $this->orderService->getOrders();
        return view('admin.orders.index', [
            'orders' => $orders,
        ]);
    }

    public function show(Order $order)
    {
        $orders = $this->orderService->showOrder($order);
        return view('admin.orders.show', [
            'orders' => $orders,
            ]);
    }

    public function delete(Order $order)
    {
        $order->delete();
        return response()->json('order Deleted ');
    }
}
