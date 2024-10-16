<x-app-layout>
    <div class="bg-gray-900">
        <!-- New full-width banner image -->
        <div class="w-full h-70 mb-8 overflow-hidden">
            <a href="{{ route('products.index') }}" class="block w-full mb-8 transition-opacity duration-300 hover:opacity-90">
            <img src="{{ asset('build/assets/images/DISMEDIA BANNER.png') }}" alt="DIS MEDIA Banner" class="w-full h-full object-cover">
            </a>
        </div>

        <div class="max-w-full mx-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
                 <!-- Clickable Banner Image (dengan lebar terbatas) -->
                 <a href="{{ route('products.index') }}" class="block w-full transition-opacity duration-300 hover:opacity-90">
                    <img src="{{ asset('build/assets/images/carousel2 (2).png') }}" alt="DIS MEDIA Volume 4" class="w-full h-auto">
                </a>

                <!-- Product Categories -->
                <div class="px-6 pb-12 mt-12">
                    <div class="flex justify-center items-center space-x-8">
                        @foreach($categories as $category)
                            <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="group">
                                <div class="w-48 h-48 rounded-lg overflow-hidden bg-gray-700 transition-transform duration-300 ease-in-out transform group-hover:scale-105">
                                    @if($category->products->isNotEmpty())
                                        <img src="{{ asset('storage/' . $category->products->first()->image_url) }}" alt="{{ $category->name }}" class="w-full h-full object-cover object-center">
                                    @else
                                        <div class="flex items-center justify-center h-full bg-gray-600 text-gray-400">No Image</div>
                                    @endif
                                </div>
                                <h3 class="mt-4 text-lg font-semibold text-center text-gray-300 group-hover:text-white transition-colors duration-300">{{ strtoupper($category->name) }}</h3>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Products -->
                <h2 class="text-2xl font-bold text-white mb-6 text-center">Products</h2>
                <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                    @foreach($products as $product)
                        <div class="group relative">
                            <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-800">
                                <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="h-full w-full object-cover object-center group-hover:opacity-75">
                            </div>
                            <div class="mt-4 flex justify-between">
                                <div>
                                    <h3 class="text-sm text-gray-300">
                                        <a href="{{ route('products.show', $product) }}">
                                            <span aria-hidden="true" class="absolute inset-0"></span>
                                            {{ $product->name }}
                                        </a>
                                    </h3>
                                </div>
                                <p class="text-sm font-medium text-gray-400">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>
                            @if($product->stock <= 0)
                                <span class="absolute top-0 right-0 bg-red-600 text-white text-xs font-bold px-2 py-1 m-2 rounded">Sold out</span>
                            @endif
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</x-app-layout>