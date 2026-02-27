<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('transactions.index') }}" class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Detail Transaksi</h2>
                <p class="text-sm text-slate-500 mt-1">Invoice: {{ $transaction->invoice_code }}</p>
            </div>
        </div>
    </x-slot>

    @if (session('success'))
        <div class="mb-6 px-6 py-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center shadow-sm">
            <svg class="w-6 h-6 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100/80 p-10 animate-in fade-in slide-in-from-bottom-6 duration-700" id="receipt">
            <!-- Print-only Shop Header -->
            <div class="hidden print:block text-center mb-8">
                <h2 class="text-2xl font-black tracking-tighter uppercase mb-1">{{ $site_settings['shop_name'] ?? 'M-KIOS' }}</h2>
                <p class="text-[10px] font-bold text-slate-600 uppercase tracking-widest">{{ $site_settings['shop_address'] ?? 'Alamat Belum Diatur' }}</p>
                <p class="text-[10px] font-bold text-slate-600 uppercase tracking-widest">Telp: {{ $site_settings['shop_phone'] ?? '-' }}</p>
                <div class="border-b border-dashed border-slate-300 my-6"></div>
            </div>
            
            <!-- Header Invoice -->
            <div class="flex flex-col sm:flex-row justify-between border-b border-slate-100 pb-8 mb-8 gap-6">
                <div>
                    <h1 class="text-3xl font-black text-slate-800 tracking-tighter uppercase">{{ $site_settings['shop_name'] ?? 'M-KIOS' }}</h1>
                    <p class="text-slate-400 font-bold text-xs uppercase tracking-widest mt-1">{{ $site_settings['shop_address'] ?? 'Solusi Kasir Modern' }}</p>
                    <p class="text-emerald-600 font-bold mt-4 text-lg">INV #{{ $transaction->invoice_code }}</p>
                </div>
                <div class="sm:text-right">
                    <p class="text-slate-500 font-medium text-sm mb-1">Tanggal & Waktu</p>
                    <p class="text-slate-800 font-bold inline-flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ $transaction->created_at->format('d M Y - H:i') }}
                    </p>
                </div>
            </div>

            <!-- Info Kasir & Pelanggan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="bg-slate-50/80 rounded-2xl p-5 border border-slate-100">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Informasi Pelanggan</p>
                    <p class="font-bold text-slate-800">{{ $transaction->customer->name ?? 'Pelanggan Umum' }}</p>
                    @if($transaction->customer)
                        <p class="text-slate-500 text-sm mt-1">{{ $transaction->customer->phone }}</p>
                    @endif
                </div>
                <div class="bg-slate-50/80 rounded-2xl p-5 border border-slate-100">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Informasi Kasir</p>
                    <p class="font-bold text-slate-800">{{ $transaction->user->name }}</p>
                </div>
            </div>

            <!-- Table Items -->
            <div class="overflow-x-auto mb-8">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b-2 border-slate-100/80 text-xs font-bold text-slate-500 uppercase tracking-wider">
                            <th class="py-3 px-2">Barang</th>
                            <th class="py-3 px-2 text-center">Harga</th>
                            <th class="py-3 px-2 text-center">Qty</th>
                            <th class="py-3 px-2 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaction->details as $detail)
                        <tr class="border-b border-slate-50">
                            <td class="py-4 px-2 font-semibold text-slate-800 bg-white group-hover:bg-slate-50">{{ $detail->product->name }}</td>
                            <td class="py-4 px-2 text-center text-slate-600">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                            <td class="py-4 px-2 text-center font-bold text-slate-800">{{ $detail->quantity }}</td>
                            <td class="py-4 px-2 text-right font-bold text-emerald-600">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Summary -->
            <div class="flex flex-col items-end w-full space-y-3 pt-6 border-t-2 border-slate-100/80">
                <div class="w-full max-w-xs flex justify-between">
                    <span class="text-slate-500 font-bold">Total Belanja</span>
                    <span class="text-slate-800 font-black text-xl tracking-tight">Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
                </div>
                <div class="w-full max-w-xs flex justify-between">
                    <span class="text-slate-500 font-medium">Bayar / Tunai</span>
                    <span class="text-slate-700 font-bold">Rp {{ number_format($transaction->payment, 0, ',', '.') }}</span>
                </div>
                @if($transaction->status === 'paid')
                <div class="w-full max-w-xs flex justify-between py-2 border-t border-slate-100 mt-2">
                    <span class="text-emerald-500 font-bold">Kembali</span>
                    <span class="text-emerald-600 font-black text-xl">Rp {{ number_format($transaction->change, 0, ',', '.') }}</span>
                </div>
                @else
                <div class="w-full max-w-xs flex justify-between py-2 border-t border-slate-100 mt-2">
                    <span class="text-red-500 font-bold block bg-red-50 px-3 py-1 rounded-lg">Status: Hutang (Sisa Rp {{ number_format($transaction->total - $transaction->payment, 0, ',', '.') }})</span>
                </div>
                @endif
            </div>

            <div class="mt-12 text-center text-sm text-slate-400 font-medium pb-4 border-b-8 border-emerald-500 rounded-b-3xl">
                -- Terima kasih atas kunjungan Anda --
            </div>
        </div>

        <div class="mt-6 flex justify-center gap-4 hidden-print">
            <button onclick="window.print()" class="px-6 py-3 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-colors shadow-sm flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak Struk
            </button>
            <a href="{{ route('transactions.create') }}" class="px-6 py-3 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 shadow-lg shadow-emerald-500/20 transition-all">
                Transaksi Baru
            </a>
        </div>
    </div>

    @push('styles')
    <style>
        @media print {
            /* Reset body and hide other elements */
            body { 
                background: white !important; 
                margin: 0 !important; 
                padding: 0 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            nav, aside, header, .hidden-print, #topbar { 
                display: none !important; 
            }
            
            main { 
                padding: 0 !important; 
                margin: 0 !important;
                display: block !important;
            }

            .max-w-7xl, .max-w-3xl {
                max-width: none !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            /* Receipt container for print */
            #receipt { 
                box-shadow: none !important; 
                border: none !important; 
                padding: 10mm !important; 
                margin: 0 auto !important;
                width: 100% !important;
                max-width: 80mm !important; /* Standard receipt width */
                font-family: 'Courier New', Courier, monospace;
                color: black !important;
            }

            #receipt * {
                color: black !important;
            }

            #receipt .border-b, #receipt .border-t, #receipt .border-t-2 {
                border-color: black !important;
                border-style: dashed !important;
                border-width: 1px 0 0 0 !important;
            }

            .bg-slate-50\/80 {
                background: transparent !important;
                border: 1px dashed black !important;
                padding: 10px !important;
            }

            table th, table td {
                padding: 4px 2px !important;
                font-size: 11px !important;
            }

            .text-2xl, .text-3xl {
                font-size: 18px !important;
            }

            .hidden-print {
                display: none !important;
            }
            
            /* Center the receipt on the printed page */
            body {
                display: flex !important;
                justify-content: center !important;
            }

            main, .max-w-7xl, .max-w-3xl {
                width: 100% !important;
            }
        }
    </style>
    @endpush
</x-app-layout>
