<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Order Confirmation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Thank you for your order!</h3>
                    <div class="space-y-2 text-gray-600 dark:text-gray-400">
                        <p>Your order number is: <strong class="text-gray-800 dark:text-gray-200">{{ $order->id }}</strong></p>
                        <p>Total amount: <strong class="text-gray-800 dark:text-gray-200">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</strong></p>
                        <p>Status: <strong class="text-gray-800 dark:text-gray-200">{{ ucfirst($order->status) }}</strong></p>
                    </div>
                    <p class="mt-4 text-gray-600 dark:text-gray-400">We will process your order soon. You can check your order status in your account.</p>
                    <div class="mt-6">
                        <a href="{{ route('orders.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            View All Orders
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>