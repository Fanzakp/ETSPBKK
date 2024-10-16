<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('My Wishlist') }}
        </h2>
    </x-slot>

    <div class="py-0 bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900">
                <div class="p-6">
                    @if ($message = Session::get('success'))
                        <div class="bg-green-500 text-white p-4 mb-6 rounded" role="alert">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                        @forelse ($wishlistItems as $item)
                        <div class="bg-gray-900 rounded-lg overflow-hidden transition-transform duration-300 hover:scale-105">
                            <a href="{{ route('products.show', $item->product->id) }}" class="block">
                                <img src="{{ asset('storage/' . $item->product->image_url) }}" alt="{{ $item->product->name }}" class="w-full h-64 object-cover">
                                <div class="p-4">
                                    <h3 class="font-semibold text-sm text-white mb-1">{{ $item->product->name }}</h3>
                                    <p class="text-gray-400 text-xs mb-2">Rp{{ number_format($item->product->price, 0, ',', '.') }}</p>
                                </div>
                            </a>
                            <div class="p-4 pt-0 grid grid-cols-2 md:grid-cols-2 gap-4">
                                <form action="{{ route('cart.add', $item->product->id) }}" method="POST" class="inline-block w-full">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="w-full bg-gray-900 text-white text-xs font-bold py-2 px-4 rounded hover:bg-gray-800 transition duration-300">
                                        Move to Cart
                                    </button>
                                </form>
                                
                                <form action="{{ route('wishlist.remove', $item->id) }}" method="POST" class="inline-block w-full">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full bg-gray-900 text-white text-xs font-bold py-2 px-4 rounded hover:bg-red-900 transition duration-300">
                                        Remove
                                    </button>
                                </form>                                
                            </div>
                        </div>
                        @empty
                        <div class="bg-gray-800 text-white p-4 rounded-lg text-center">
                            <p class="text-gray-100">Your wishlist is empty.</p>
                            <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 mt-4 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Continue Shopping
                            </a>
                        </div>
                        @endempty                        
                    </div>

                    <!-- Pagination Links -->
                    @if($wishlistItems instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="mt-6">
                            {{ $wishlistItems->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
