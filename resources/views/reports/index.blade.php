<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Laporan Keuangan</h2>
        <p class="text-sm text-slate-500 mt-1">Ringkasan performa penjualan dan pembelian kios</p>
    </x-slot>

    <!-- Filter Form -->
    <div class="bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100/80 p-6 mb-8 animate-in fade-in slide-in-from-bottom-6 duration-700 delay-100">
        <form action="{{ route('reports.index') }}" method="GET" class="flex flex-col md:flex-row items-end gap-6">
            <div class="flex-1 w-full m-0 p-0 border-none bg-transparent">
                <label for="start_date" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal Mulai</label>
                <input type="date" name="start_date" id="start_date" class="w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors" value="{{ request('start_date', $start_date) }}">
            </div>
            
            <div class="flex-1 w-full m-0 p-0 border-none bg-transparent">
                <label for="end_date" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal Berakhir</label>
                <input type="date" name="end_date" id="end_date" class="w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors" value="{{ request('end_date', $end_date) }}">
            </div>
            
            <button type="submit" class="w-full md:w-auto px-8 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-lg shadow-emerald-500/20 transition-all flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Terapkan Filter
            </button>
            <button type="button" onclick="window.print()" class="w-full md:w-auto px-6 py-3 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-colors shadow-sm flex items-center justify-center hidden-print">
                <svg class="w-5 h-5 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak
            </button>
        </form>
    </div>

    <div class="print-container">
        <!-- Print Header -->
        <div class="hidden print-header mb-8 pb-4 border-b-2 border-slate-800">
            <h1 class="text-3xl font-black text-slate-800 tracking-tighter">LAPORAN KEUANGAN KIOS</h1>
            <p class="text-slate-500 mt-1">Periode: {{ \Carbon\Carbon::parse($start_date)->format('d F Y') }} - {{ \Carbon\Carbon::parse($end_date)->format('d F Y') }}</p>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 animate-in fade-in slide-in-from-bottom-8 duration-700 delay-200">
            
            <div class="bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-3xl p-6 shadow-xl shadow-emerald-500/20 text-white relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:scale-110 transition-transform duration-500"></div>
                <p class="text-emerald-100 font-bold text-xs uppercase tracking-wider mb-2">Penjualan (Lunas)</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-sm font-bold text-emerald-200">Rp</span>
                    <span class="text-3xl font-black tracking-tight">{{ number_format($totalSales, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100/80 relative overflow-hidden group">
                <p class="text-slate-400 font-bold text-xs uppercase tracking-wider mb-2">Estimasi Keuntungan</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-sm font-bold text-slate-400">Rp</span>
                    <span class="text-3xl font-black tracking-tight text-slate-800">{{ number_format($totalProfit, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100/80 relative overflow-hidden group">
                <p class="text-slate-400 font-bold text-xs uppercase tracking-wider mb-2">Barang Masuk (Modal)</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-sm font-bold text-slate-400">Rp</span>
                    <span class="text-3xl font-black tracking-tight text-slate-800">{{ number_format($totalPurchases, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100/80 relative overflow-hidden group">
                <p class="text-red-400 font-bold text-xs uppercase tracking-wider mb-2">Piutang / Hutang Pelanggan</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-sm font-bold text-red-400">Rp</span>
                    <span class="text-3xl font-black tracking-tight text-red-600">{{ number_format($totalDebt, 0, ',', '.') }}</span>
                </div>
            </div>

        </div>

    </div>

    @push('styles')
    <style>
        .print-header { display: none; }
        @media print {
            body { background: white; -webkit-print-color-adjust: exact; }
            .hidden-print, header, aside, .hidden-print * { display: none !important; }
            main, .print-container { padding: 0 !important; margin: 0 !important; width: 100%; }
            .print-header { display: block; }
            .bg-white { box-shadow: none !important; border: 1px solid #e2e8f0 !important; }
        }
    </style>
    @endpush
</x-app-layout>
