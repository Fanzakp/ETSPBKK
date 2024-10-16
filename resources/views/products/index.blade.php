<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-0 bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900">
                <div class="p-6">
                    @if(Auth::user() && Auth::user()->isAdmin())
                    <div class="mb-6">
                        <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Tambah Produk Baru
                        </a>
                    </div>
                    @endif
                    
                    @if ($message = Session::get('success'))
                        <div class="bg-green-500 text-white p-4 mb-6 rounded" role="alert">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <!-- Category filter -->
                    <form action="{{ route('products.index') }}" method="GET" class="mb-6">
                        <label for="category" class="block text-sm font-medium text-gray-300">Filter by Category:</label>
                        <select id="category" name="category" onchange="this.form.submit()" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-gray-800 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-white">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                        @foreach ($products as $product)
                        <div class="bg-gray-900 rounded-lg overflow-hidden transition-transform duration-300 hover:scale-105">
                            <a href="{{ route('products.show', $product->id) }}" class="block">
                                <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="w-full h-64 object-cover">
                                <div class="p-4">
                                    <h3 class="font-semibold text-sm text-white mb-1">{{ $product->name }}</h3>
                                    <p class="text-gray-400 text-xs mb-2">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                                </div>
                            </a>
                            @if(Auth::user() && Auth::user()->isAdmin())
                            <div class="p-4 pt-0 grid grid-cols-2 md:grid-cols-2 gap-4">
                                <form action="{{ route('products.edit', $product->id) }}" method="GET" class="inline-block w-full">
                                    <button type="submit" class="w-full bg-gray-900 text-white text-xs font-bold py-2 px-4 rounded hover:bg-blue-900 transition duration-300">Edit</button>
                                </form>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-block w-full">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full bg-gray-900 text-white text-xs font-bold py-2 px-4 rounded hover:bg-red-900 transition duration-300" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Delete</button>
                                </form>
                            </div>
                            @else
                                <div class="p-4 pt-0">
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full bg-gray-900 text-white text-xs font-bold py-2 px-4 rounded hover:bg-gray-800 transition duration-300">
                                            Add to Cart
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>