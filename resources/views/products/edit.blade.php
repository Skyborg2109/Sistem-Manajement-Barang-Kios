<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('products.index') }}" class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Edit Barang</h2>
                <p class="text-sm text-slate-500 mt-1">Perbarui data stok dan harga</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100/80 p-8 animate-in fade-in slide-in-from-bottom-6 duration-700">
        <form action="{{ route('products.update', $product->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-1 md:col-span-2">
                    <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Nama Barang <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50/50 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors @error('name') border-red-500 @enderror" value="{{ old('name', $product->name) }}" required>
                    @error('name') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-bold text-slate-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                    <select name="category_id" id="category_id" class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50/50 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors @error('category_id') border-red-500 @enderror" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="unit" class="block text-sm font-bold text-slate-700 mb-2">Satuan (Unit) <span class="text-red-500">*</span></label>
                    <input type="text" name="unit" id="unit" class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50/50 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors @error('unit') border-red-500 @enderror" value="{{ old('unit', $product->unit) }}" required>
                    @error('unit') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="buy_price" class="block text-sm font-bold text-slate-700 mb-2">Harga Beli (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="buy_price" id="buy_price" class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50/50 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors @error('buy_price') border-red-500 @enderror" value="{{ old('buy_price', $product->buy_price) }}" min="0" required>
                    @error('buy_price') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="sell_price" class="block text-sm font-bold text-slate-700 mb-2">Harga Jual (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="sell_price" id="sell_price" class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50/50 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors @error('sell_price') border-red-500 @enderror" value="{{ old('sell_price', $product->sell_price) }}" min="0" required>
                    @error('sell_price') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="stock" class="block text-sm font-bold text-slate-700 mb-2">Stok Saat Ini <span class="text-red-500">*</span></label>
                    <input type="number" name="stock" id="stock" class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50/50 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors @error('stock') border-red-500 @enderror" value="{{ old('stock', $product->stock) }}" min="0" required>
                    @error('stock') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="min_stock" class="block text-sm font-bold text-slate-700 mb-2">Minimum Stok Peringatan <span class="text-red-500">*</span></label>
                    <input type="number" name="min_stock" id="min_stock" class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50/50 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors @error('min_stock') border-red-500 @enderror" value="{{ old('min_stock', $product->min_stock) }}" min="0" required>
                    @error('min_stock') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t border-slate-100 text-right mt-8">
                <a href="{{ route('products.index') }}" class="px-5 py-2.5 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">Batal</a>
                <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 shadow-lg shadow-emerald-500/20 rounded-xl transition-all">
                    Perbarui Barang
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
