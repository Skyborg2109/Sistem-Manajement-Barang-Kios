<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Kasir / Transaksi</h2>
    </x-slot>

    <!-- App layout using full width for POS -->
    <div x-data="posApp()" class="flex flex-col lg:flex-row gap-6 h-[calc(100vh-140px)] animate-in fade-in duration-700">
        <!-- Left: Product List -->
        <div class="flex flex-col flex-[2] bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100/80 overflow-hidden h-full">
            <div class="p-4 border-b border-slate-100/80 bg-slate-50/50">
                <input type="text" x-model="search" placeholder="Cari barang..." class="w-full px-4 py-3 border border-slate-200 rounded-xl bg-white focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors">
            </div>
            
            <div class="flex-1 overflow-y-auto p-4 hide-scrollbar grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-4 items-start content-start">
                <template x-for="product in filteredProducts" :key="product.id">
                    <button @click="addToCart(product)" :disabled="product.stock <= 0" class="group text-left p-4 rounded-2xl border transition-all duration-200" :class="product.stock > 0 ? 'border-slate-100 hover:border-emerald-300 hover:shadow-[0_8px_20px_rgb(16,185,129,0.1)] bg-white' : 'border-red-100 bg-red-50/50 opacity-60 cursor-not-allowed'">
                        <div class="flex items-center justify-between mb-2">
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-slate-100 text-slate-500" x-text="product.unit"></span>
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-md" :class="product.stock > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700'" x-text="product.stock > 0 ? 'Sisa: ' + product.stock : 'Habis'"></span>
                        </div>
                        <h4 class="font-bold text-slate-800 text-sm mb-1 line-clamp-2 min-h-[40px]" x-text="product.name"></h4>
                        <p class="font-extrabold text-emerald-600 text-md" x-text="formatRupiah(product.price)"></p>
                    </button>
                </template>
                <div x-show="filteredProducts.length === 0" class="col-span-full text-center py-10 text-slate-500">Barang tidak ditemukan.</div>
            </div>
        </div>

        <!-- Right: Cart & Payment -->
        <div class="flex flex-col flex-1 bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.06)] border border-slate-100/80 overflow-hidden h-full">
            <div class="p-6 border-b border-slate-100/80 bg-slate-50/50">
                <h3 class="font-bold text-xl text-slate-800">Keranjang</h3>
            </div>
            
            <div class="flex-1 overflow-y-auto p-4 hide-scrollbar">
                <div x-show="cart.length === 0" class="text-center py-10 text-slate-400 font-medium">Belum ada barang di keranjang.</div>
                
                <div class="space-y-3">
                    <template x-for="(item, index) in cart" :key="index">
                        <div class="p-4 border border-slate-100 rounded-2xl bg-white shadow-sm hover:shadow-md transition-all duration-300 group">
                            <!-- Row 1: Name & Remove -->
                            <div class="flex justify-between items-start gap-4 mb-3">
                                <h5 class="text-[13px] font-extrabold text-slate-800 leading-snug line-clamp-2 flex-1" x-text="item.name"></h5>
                                <button @click="removeItem(index)" class="flex-shrink-0 w-8 h-8 flex items-center justify-center text-slate-300 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </div>
                            
                            <!-- Row 2: Price & Quantity -->
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex flex-col">
                                    <span class="text-xs font-black text-emerald-600" x-text="formatRupiah(item.price)"></span>
                                    <span class="text-[10px] font-bold text-slate-300" x-text="'Stok: ' + item.max_stock"></span>
                                </div>
                                
                                <div class="flex items-center bg-slate-50 border border-slate-200 rounded-xl p-0.5">
                                    <button @click="updateQty(index, -1)" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-white rounded-lg transition-all">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" /></svg>
                                    </button>
                                    <input type="text" x-model.number="item.qty" @change="checkQty(index)" class="w-10 text-center text-[13px] font-black border-none focus:ring-0 p-0 text-slate-800 bg-transparent h-8">
                                    <button @click="updateQty(index, 1)" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-emerald-600 hover:bg-white rounded-lg transition-all">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <div class="p-6 border-t border-slate-100/80 bg-white">
                <form action="{{ route('transactions.store') }}" method="POST" x-ref="checkoutForm" @keydown.window.f9.prevent="submitForm">
                    @csrf
                    <input type="hidden" name="cart" :value="JSON.stringify(cart)">
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between items-end">
                            <span class="text-slate-500 font-medium">Subtotal</span>
                            <span class="text-2xl font-extrabold text-slate-800 tracking-tight" x-text="formatRupiah(total)"></span>
                        </div>
                        
                        <div class="mb-5">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Metode Pembayaran</label>
                            <div class="grid grid-cols-2 gap-2 p-1 bg-slate-100 rounded-2xl border border-slate-200">
                                <button type="button" @click="setExactAmount" :class="payment >= total ? 'bg-white text-emerald-600 shadow-sm border-slate-200' : 'text-slate-500 hover:text-slate-700 border-transparent'" class="py-2 rounded-xl font-bold text-xs transition-all border">
                                    Tunai (Lunas)
                                </button>
                                <button type="button" @click="payment = 0" :class="payment < total ? 'bg-white text-red-500 shadow-sm border-slate-200' : 'text-slate-500 hover:text-slate-700 border-transparent'" class="py-2 rounded-xl font-bold text-xs transition-all border">
                                    Piutang (Hutang)
                                </button>
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Pelanggan <span x-show="payment < total" class="text-red-500 font-black">*</span></label>
                                <a href="{{ route('customers.create') }}" class="text-[10px] font-bold text-emerald-600 hover:text-emerald-700 bg-emerald-50 px-2 py-1 rounded" target="_blank">+ Pelanggan Baru</a>
                            </div>
                            <select name="customer_id" x-model="customerId" class="w-full px-4 py-2.5 border rounded-xl bg-slate-50 focus:outline-none focus:ring-1 text-sm font-medium transition-all" :class="payment < total && !customerId ? 'border-red-400 focus:border-red-500 focus:ring-red-500 ring-1 ring-red-100' : 'border-slate-200 focus:border-emerald-500 focus:ring-emerald-500'">
                                <option value="" :disabled="payment < total" x-text="payment < total ? '-- Pilih Pelanggan (Wajib) --' : 'Pelanggan Umum'"></option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->phone }})</option>
                                @endforeach
                            </select>
                            <p x-show="payment < total && !customerId" class="mt-1.5 text-[10px] font-bold text-red-500 italic">
                                * Transaksi piutang wajib memilih pelanggan tertentu
                            </p>
                        </div>
                        
                        <div class="mt-4">
                            <div class="flex justify-between items-center mb-2">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Terima Pembayaran</label>
                                <button type="button" @click="setExactAmount" class="text-[10px] font-bold text-emerald-600 hover:text-emerald-700 bg-emerald-50 px-2 py-1 rounded">Uang Pas</button>
                            </div>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400 font-bold">Rp</span>
                                <input type="number" name="payment" x-model.number="payment" class="w-full pl-12 pr-4 py-3 border border-slate-200 rounded-xl bg-white focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-lg font-bold shadow-inner transition-colors" :class="payment < total ? 'text-red-600 border-red-200 bg-red-50/20' : 'text-emerald-700'" required min="0">
                            </div>
                        </div>

                        <div class="flex justify-between items-center p-3 bg-slate-50 border border-slate-100 rounded-xl">
                            <span class="text-slate-500 font-bold text-sm" x-text="payment < total ? 'Piutang / Hutang' : 'Kembalian'"></span>
                            <span class="font-extrabold text-lg" :class="payment < total ? 'text-red-500' : 'text-emerald-500'" x-text="formatRupiah(Math.abs(payment - total))"></span>
                        </div>
                    </div>

                    <button type="submit" :disabled="cart.length === 0 || loading" @click.prevent="submitForm" class="w-full py-4 text-white font-bold rounded-xl transition-all shadow-lg" :class="(cart.length === 0 || loading) ? 'bg-slate-300 cursor-not-allowed shadow-none' : (payment < total && !customerId ? 'bg-red-400 hover:bg-red-500' : 'bg-emerald-600 hover:bg-emerald-700 shadow-emerald-500/30')">
                        <span x-show="!loading">Proses Pembayaran (F9)</span>
                        <span x-show="loading">Memproses...</span>
                    </button>
                    
                    @if(session('error'))
                        <div class="mt-4 p-3 bg-red-50 text-red-600 text-xs font-bold rounded-lg border border-red-200 text-center animate-pulse">
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
            'price' => $p->sell_price, 
            'stock' => $p->stock, 
            'unit' => $p->unit
        ])->values()->all();
    @endphp
    <script>
        function posApp() {
            return {
                products: @json($mappedProducts),
                search: '',
                cart: [],
                payment: 0,
                customerId: '',
                loading: false,
                
                init() {
                    // Initialize focus or anything else
                },

                submitForm() {
                    if (this.loading || this.cart.length === 0) return;
                    
                    // Specific validation for debt
                    if (this.payment < this.total) {
                        if (!this.customerId) {
                            alert('Pilih pelanggan terlebih dahulu untuk transaksi piutang / hutang!');
                            return;
                        }
                    }
                    
                    this.loading = true;
                    this.$refs.checkoutForm.submit();
                },

                setExactAmount() {
                    this.payment = this.total;
                },
                get filteredProducts() {
                    return this.products.filter(p => p.name.toLowerCase().includes(this.search.toLowerCase()));
                },
                
                get total() {
                    return this.cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
                },
                
                addToCart(product) {
                    if(product.stock <= 0) return;
                    
                    const el = this.cart.find(item => item.id === product.id);
                    if(el) {
                        if (el.qty < product.stock) {
                            el.qty++;
                        }
                    } else {
                        this.cart.push({
                            id: product.id,
                            name: product.name,
                            price: product.price,
                            qty: 1,
                            max_stock: product.stock
                        });
                    }
                },
                
                updateQty(index, change) {
                    const el = this.cart[index];
                    const newQty = el.qty + change;
                    if(newQty > 0 && newQty <= el.max_stock) {
                        el.qty = newQty;
                    } else if (newQty === 0) {
                        this.removeItem(index);
                    }
                },

                checkQty(index) {
                    const el = this.cart[index];
                    if (el.qty > el.max_stock) el.qty = el.max_stock;
                    if (el.qty <= 0) this.removeItem(index);
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
