<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Form Barang Masuk</h2>
    </x-slot>

    <!-- App layout using full width -->
    <div x-data="purchaseApp()" class="flex flex-col lg:flex-row gap-6 h-[calc(100vh-140px)] animate-in fade-in duration-700">
        <!-- Left: Product List -->
        <div class="flex flex-col flex-[2] bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100/80 overflow-hidden h-full">
            <div class="p-4 border-b border-slate-100/80 bg-slate-50/50">
                <input type="text" x-model="search" placeholder="Cari barang yang ingin ditambah stok..." class="w-full px-4 py-3 border border-slate-200 rounded-xl bg-white focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors">
            </div>
            
            <div class="flex-1 overflow-y-auto p-4 hide-scrollbar grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-4 items-start content-start">
                <template x-for="product in filteredProducts" :key="product.id">
                    <button @click="addToCart(product)" class="group text-left p-4 rounded-2xl border transition-all duration-200 border-slate-100 hover:border-emerald-300 hover:shadow-[0_8px_20px_rgb(16,185,129,0.1)] bg-white">
                        <div class="flex items-center justify-between mb-2">
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-slate-100 text-slate-500" x-text="product.unit"></span>
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-emerald-50 text-emerald-600" x-text="'Stok: ' + product.stock"></span>
                        </div>
                        <h4 class="font-bold text-slate-800 text-sm mb-1 line-clamp-2 min-h-[40px]" x-text="product.name"></h4>
                        <p class="font-extrabold text-blue-600 text-sm" x-text="'HB: ' + formatRupiah(product.price)"></p>
                    </button>
                </template>
                <div x-show="filteredProducts.length === 0" class="col-span-full text-center py-10 text-slate-500">Barang tidak ditemukan.</div>
            </div>
        </div>

        <!-- Right: Cart & Supplier -->
        <div class="flex flex-col flex-1 bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.06)] border border-slate-100/80 overflow-hidden h-full">
            <div class="p-6 border-b border-slate-100/80 bg-slate-50/50">
                <h3 class="font-bold text-xl text-slate-800">Daftar Masuk</h3>
            </div>
            
            <div class="flex-1 overflow-y-auto p-4 hide-scrollbar">
                <div x-show="cart.length === 0" class="text-center py-10 text-slate-400 font-medium">Belum ada barang di daftar.</div>
                
                <div class="space-y-3">
                    <template x-for="(item, index) in cart" :key="index">
                        <div class="p-4 border border-slate-100 rounded-xl bg-slate-50/50 group">
                            <div class="flex items-start justify-between mb-3">
                                <h5 class="text-sm font-bold text-slate-800 line-clamp-1 flex-1 pr-2" x-text="item.name"></h5>
                                <button @click="removeItem(index)" class="w-6 h-6 flex items-center justify-center text-red-300 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-1/3">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase">Qty</label>
                                    <input type="number" x-model.number="item.qty" class="w-full text-sm font-bold border border-slate-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 p-1.5 text-slate-800 mt-1" min="1">
                                </div>
                                <div class="w-2/3">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase">Harga Beli Baru</label>
                                    <input type="number" x-model.number="item.price" class="w-full text-sm font-bold border border-slate-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 p-1.5 text-slate-800 mt-1" min="0">
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <div class="p-6 border-t border-slate-100/80 bg-white">
                <form action="{{ route('purchases.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="cart" :value="JSON.stringify(cart)">
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between items-end border-b border-slate-100 pb-3">
                            <span class="text-slate-500 font-medium">Total Masuk</span>
                            <span class="text-2xl font-extrabold text-blue-600 tracking-tight" x-text="formatRupiah(total)"></span>
                        </div>
                        
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Supplier <span class="text-red-500">*</span></label>
                                <a href="{{ route('suppliers.create') }}" class="text-[10px] font-bold text-blue-600 hover:text-blue-700 bg-blue-50 px-2 py-1 rounded" target="_blank">+ Supplier Baru</a>
                            </div>
                            <select name="supplier_id" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-slate-50 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-sm font-medium" required>
                                <option value="">-- Pilih Supplier --</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button type="submit" :disabled="cart.length === 0" class="w-full py-4 text-white font-bold rounded-xl transition-all shadow-lg" :class="cart.length === 0 ? 'bg-slate-300 cursor-not-allowed shadow-none' : 'bg-blue-600 hover:bg-blue-700 shadow-blue-500/30'">
                        Proses Barang Masuk
                    </button>
                    
                    @if(session('error'))
                        <div class="mt-4 p-3 bg-red-50 text-red-600 text-xs font-bold rounded-lg border border-red-200 text-center">
                            {{ session('error') }}
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    @php
        $mappedProducts = $products->map(fn($p) => [
            'id' => $p->id, 
            'name' => $p->name, 
            'price' => $p->buy_price, 
            'stock' => $p->stock, 
            'unit' => $p->unit
        ])->values()->all();
    @endphp
    <script>
        function purchaseApp() {
            return {
                products: @json($mappedProducts),
                search: '',
                cart: [],
                
                get filteredProducts() {
                    return this.products.filter(p => p.name.toLowerCase().includes(this.search.toLowerCase()));
                },
                
                get total() {
                    return this.cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
                },
                
                addToCart(product) {
                    const el = this.cart.find(item => item.id === product.id);
                    if(el) {
                        el.qty++;
                    } else {
                        this.cart.push({
                            id: product.id,
                            name: product.name,
                            price: product.price,
                            qty: 1
                        });
                    }
                },
                
                removeItem(index) {
                    this.cart.splice(index, 1);
                },
                
                formatRupiah(angka) {
                    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka);
                }
            }
        }
    </script>
    @endpush
</x-app-layout>
