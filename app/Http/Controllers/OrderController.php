<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Add this if not already present
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderItem;

class OrderController extends Controller
{
    use AuthorizesRequests; // This ensures that the authorize method is available

    public function index()
    {
        if (auth()->user()->isAdmin()) {
            return $this->adminIndex();
        }
        return $this->userIndex();
    }

    public function adminIndex()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return view('orders.Adminindex', compact('orders'));
    }

    protected function userIndex()
    {
        $orders = auth()->user()->orders()->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }


    public function create()
    {
        $cartItems = session()->get('cart', []);
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return view('orders.checkout', compact('cartItems', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'payment_method' => 'required|in:credit_card,bank_transfer',
        ]);

        $order = Order::create([
            'user_id' => auth()->id(),
            'total_amount' => $request->total_amount,
            'shipping_address' => $request->shipping_address,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
        ]);

        $cartItems = session()->get('cart', []);
        foreach ($cartItems as $id => $details) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $details['quantity'],
                'price' => $details['price'],
            ]);
        }

        session()->forget('cart');

        return redirect()->route('orders.confirmation', $order)->with('success', 'Order placed successfully!');
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        return view('orders.show', compact('order'));
    }

    public function confirmation(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        return view('orders.confirmation', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $this->authorize('update', $order);
        
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Order status updated successfully.');
    }
}