<?php

namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Jobs\ProcessOrder;

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $order = Order::create([
            'user_id' => auth()->user()->id,
            'product_id' => $request->input('product_id'),
            'status' => 'pending',
        ]);

        ProcessOrder::dispatch($order);

        return response()->json(['message' => 'Order placed successfully']);
    }

    public function orderHistory()
    {
        $user = auth()->user();
        $orderHistory = Order::where('user_id', $user->id)->get();

        return response()->json(['order_history' => $orderHistory]);
    }

    public function updateOrderStatus(Request $request, $orderId)
    {
        
        $request->validate([
            'status' => 'required|in:shipped,delievered',
        ]);

        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['error' => 'Invalid order_id'], 404);
        }
        
        $order->update(['status' => $request->input('status')]);

        return response()->json(['message' => 'Order status updated successfully']);
    }
}
