<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Order Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    @if(session('success'))
                        <div class="mb-4 px-4 py-2 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Order Details</h3>
                    <div class="space-y-2 text-gray-600 dark:text-gray-400">
                        <p>Order number: <strong class="text-gray-800 dark:text-gray-200">{{ $order->id }}</strong></p>
                        <p>Customer: <strong class="text-gray-800 dark:text-gray-200">{{ $order->user->name }}</strong></p>
                        <p>Total amount: <strong class="text-gray-800 dark:text-gray-200">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</strong></p>
                        <p>Status: <strong class="text-gray-800 dark:text-gray-200">{{ ucfirst($order->status) }}</strong></p>
                    </div>
                    
                    <h4 class="text-md font-semibold mt-6 mb-2 text-gray-800 dark:text-gray-200">Order Items:</h4>
                    <div class="space-y-2 text-gray-600 dark:text-gray-400">
                        @foreach($order->orderItems as $item)
                            <p>{{ $item->product->name }} - Quantity: {{ $item->quantity }} - Price: Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                        @endforeach
                    </div>

                    @if(auth()->user()->isAdmin())
                        <form action="{{ route('orders.update', $order) }}" method="POST" class="mt-6">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <button type="submit" class="mt-3 inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 dark:hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Update Status
                            </button>
                        </form>
                    @endif

                    <div class="mt-6">
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Back to All Orders
                            </a>
                        @else
                            <a href="{{ route('orders.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Back to My Orders
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>