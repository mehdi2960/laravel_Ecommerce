<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders=Order::query()->latest()->paginate(10);
        return view('admin.orders.index',compact('orders'));
    }

    public function show(Order $order)
    {
        return view('admin.orders.show' , compact('order'));
    }

    public function edit($id)
    {
        //
    }
}
