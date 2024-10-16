<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Detail Product') }}
        </h2>
    </x-slot>

    <div class="py-2 bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 overflow-hidden">
                <div class="p-4">
                    <div class="flex flex-col md:flex-row md:space-x-8">
                        <div class="md:w-1/2">
                            <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="w-full h-auto object-cover rounded-lg">
                        </div>
                        <div class="md:w-1/2 mt-4 md:mt-0">
                            <h1 class="text-3xl font-bold text-white mb-2">{{ $product->name }}</h1>
                            <p class="text-2xl font-semibold text-gray-300 mb-4">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                            <p class="text-gray-400 mb-4">{{ $product->description }}</p>
                            
                            @if($product->stock > 0)
                                <p class="text-green-500 mb-4">In stock</p>
                            @else
                                <p class="text-red-500 mb-4">Out of stock</p>
                            @endif

                            @if($product->category && $product->category->name == 'T-Shirt')
                                <div class="mb-6">
                                    <p class="text-gray-300 mb-2">Size</p>
                                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                        @foreach(['SMALL', 'MEDIUM', 'LARGE', 'X-LARGE'] as $size)
                                            <button type="button" class="size-button w-full px-4 py-2 bg-gray-800 text-gray-300 hover:bg-gray-700 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $size }}</button>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="flex space-x-4 mb-6">
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-grow">
                                    @csrf
                                    <input type="hidden" name="size" id="selected-size" value="">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex items-center bg-gray-800 rounded-lg">
                                            <button type="button" class="px-2 py-1 text-gray-300 hover:bg-gray-700 rounded-l-lg" onclick="decrementQuantity()">-</button>
                                            <span id="quantity-display" class="px-4 py-2 text-white">1</span>
                                            <button type="button" class="px-2 py-1 text-gray-300 hover:bg-gray-700 rounded-r-lg" onclick="incrementQuantity()">+</button>
                                        </div>
                                        <input type="hidden" name="quantity" id="quantity" value="1">
                                        <button type="submit" class="flex-grow bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300">
                                            ADD TO CART
                                        </button>
                                    </div>
                                </form>
                                @if(Auth::check() && Auth::user()->wishlistItems && Auth::user()->wishlistItems->contains('product_id', $product->id))
                                    <form action="{{ route('wishlist.remove', Auth::user()->wishlistItems->where('product_id', $product->id)->first()->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-gray-800 text-white py-2 px-4 rounded-lg hover:bg-gray-700 transition duration-300">
                                            Remove from Wishlist
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('wishlist.add', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-gray-800 text-white py-2 px-4 rounded-lg hover:bg-gray-700 transition duration-300">
                                            Add to Wishlist
                                        </button>
                                    </form>
                                @endif
                            </div>

                            @if(Auth::user() && Auth::user()->isAdmin())
                                <div class="grid grid-cols-2 gap-4 mt-4">
                                    <a href="{{ route('products.edit', $product->id) }}" class="w-full bg-gray-800 text-white font-bold py-2 px-4 rounded hover:bg-blue-900 transition duration-300 text-center">Edit</a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="w-full">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full bg-gray-800 text-white font-bold py-2 px-4 rounded hover:bg-red-900 transition duration-300" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                    </form>
                                </div>
                            @endif

                            <!-- Reviews section -->
                            <div class="mt-8">
                                <h3 class="text-xl font-bold text-white mb-4">Customer Reviews</h3>
                                @forelse($product->reviews as $review)
                                    <div class="mb-4 pb-4 border-b border-gray-700">
                                        <div class="flex items-center mb-2">
                                            <div class="text-yellow-400">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating)
                                                        ★
                                                    @else
                                                        ☆
                                                    @endif
                                                @endfor
                                            </div>
                                            <span class="ml-2 text-gray-400">{{ $review->user->name }}</span>
                                        </div>
                                        <p class="text-gray-300">{{ $review->comment }}</p>

                                        <!-- Button to delete the review, only visible to admins -->
                                        @if(auth()->user()->isAdmin()) <!-- Assuming isAdmin method exists in User model -->
                                            <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" class="mt-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 transition duration-300">
                                                    Delete Review
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @empty
                                    <p class="text-gray-400">No reviews yet.</p>
                                @endforelse
                            </div>

                                
                                @auth
                                    <form action="{{ route('reviews.store', $product->id) }}" method="POST" class="mt-6">
                                        @csrf
                                        <div class="mb-4">
                                            <label for="rating" class="block text-sm font-medium text-gray-300">Rating</label>
                                            <select name="rating" id="rating" class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white">
                                                <option value="5">5 Stars</option>
                                                <option value="4">4 Stars</option>
                                                <option value="3">3 Stars</option>
                                                <option value="2">2 Stars</option>
                                                <option value="1">1 Star</option>
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label for="comment" class="block text-sm font-medium text-gray-300">Your Review</label>
                                            <textarea name="comment" id="comment" rows="3" class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white"></textarea>
                                        </div>
                                        <button type="submit" class="bg-gray-800 text-white py-2 px-4 rounded-lg hover:bg-gray-700 transition duration-300">
                                            Submit Review
                                        </button>
                                    </form>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let quantity = 1;
        const quantityDisplay = document.getElementById('quantity-display');
        const quantityInput = document.getElementById('quantity');
        const sizeButtons = document.querySelectorAll('.size-button');
        const selectedSizeInput = document.getElementById('selected-size');
        const addToCartButton = document.querySelector('button[type="submit"]');

        function updateQuantity(newQuantity) {
            quantity = Math.max(1, newQuantity);
            quantityDisplay.textContent = quantity;
            quantityInput.value = quantity;
        }

        function incrementQuantity() {
            updateQuantity(quantity + 1);
        }

        function decrementQuantity() {
            updateQuantity(quantity - 1);
        }

        sizeButtons.forEach(button => {
            button.addEventListener('click', function() {
                sizeButtons.forEach(btn => btn.classList.remove('bg-blue-600', 'text-white'));
                this.classList.add('bg-blue-600', 'text-white');
                selectedSizeInput.value = this.textContent.trim();
                addToCartButton.disabled = false;
            });
        });

        if (sizeButtons.length > 0) {
            addToCartButton.disabled = true;
        }
    </script>
</x-app-layout>