<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('purchases.index') }}" class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Detail Barang Masuk</h2>
                <p class="text-sm text-slate-500 mt-1">ID Pembelian: #{{ str_pad($purchase->id, 5, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>
    </x-slot>

    @if (session('success'))
        <div class="mb-6 px-6 py-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center shadow-sm">
            <svg class="w-6 h-6 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100/80 p-10 animate-in fade-in slide-in-from-bottom-6 duration-700">
            <!-- Header Invoice -->
            <div class="flex justify-between border-b border-slate-100 pb-8 mb-8">
                <div>
                    <h1 class="text-3xl font-black text-slate-800 tracking-tighter">BUKTI TERIMA BARANG</h1>
                    <p class="text-slate-500 mt-2 text-sm">{{ $purchase->created_at->format('l, d F Y H:i') }}</p>
                </div>
                <div class="text-right">
                    <p class="text-slate-500 font-medium text-xs uppercase tracking-wider mb-1">Diterima Oleh (Admin)</p>
                    <p class="text-slate-800 font-bold mb-4">{{ $purchase->user->name }}</p>
                    
                    <p class="text-slate-500 font-medium text-xs uppercase tracking-wider mb-1">Dari Supplier</p>
                    <p class="text-slate-800 font-bold">{{ $purchase->supplier->name }}</p>
                    <p class="text-slate-500 text-sm mt-1">{{ $purchase->supplier->phone }}</p>
                </div>
            </div>

            <!-- Table Items -->
            <div class="overflow-x-auto mb-8">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider w-16">No</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Barang</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Harga Beli</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Qty</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @foreach($purchase->details as $index => $detail)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-400">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-800">{{ $detail->product->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-slate-600">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-bold text-slate-800">{{ $detail->quantity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-emerald-600">Rp {{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Summary -->
            <div class="flex flex-col items-end w-full space-y-3 pt-6 border-t border-slate-100">
                <div class="w-full max-w-sm flex justify-between p-4 bg-blue-50 rounded-2xl border border-blue-100">
                    <span class="text-blue-700 font-bold">Total Pembelian</span>
                    <span class="text-blue-700 font-black text-xl tracking-tight">Rp {{ number_format($purchase->total, 0, ',', '.') }}</span>
                </div>
            </div>
            
            <div class="mt-8 text-sm text-slate-400">
                <p>* Stok produk otomatis bertambah sesuai dengan jumlah Qty di atas.</p>
                <p>* Harga beli produk otomatis diperbarui ke harga terbaru dari transaksi ini.</p>
            </div>
        </div>
    </div>
</x-app-layout>
