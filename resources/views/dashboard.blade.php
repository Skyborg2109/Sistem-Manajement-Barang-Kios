<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">
                    {{ __('Dashboard Overview') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Sistem Manajemen Kios & Penjualan</p>
            </div>
            
            <div class="flex items-center gap-3 bg-white/60 backdrop-blur-md px-4 py-2 rounded-2xl border border-slate-200/60 shadow-sm">
                <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                <span class="text-sm font-medium text-slate-600">{{ now()->translatedFormat('l, d F Y') }}</span>
            </div>
        </div>
    </x-slot>

    <!-- Wrap all in animated container -->
    <div class="space-y-8 animate-in fade-in slide-in-from-bottom-6 duration-700 fill-mode-both">
        
        <!-- Stats Row -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Card: Penjualan Hari Ini -->
            <div class="group relative overflow-hidden bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(16,185,129,0.12)] border border-slate-100/80 transition-all duration-300 transform hover:-translate-y-1">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                
                <div class="p-6 relative z-10 flex flex-col h-full justify-between gap-4">
                    <div class="flex items-start justify-between">
                        <div class="p-3.5 rounded-2xl bg-emerald-100/80 text-emerald-600 shadow-inner">
                            <svg class="w-6 h-6 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="flex items-center text-xs font-semibold px-2 py-1 bg-emerald-50 text-emerald-600 rounded-lg">
                            +12% <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 mb-1">Penjualan Hari Ini</p>
                        <h3 class="text-3xl font-extrabold text-slate-800 tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-slate-900 to-slate-700">Rp {{ number_format($salesToday ?? 0, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>

            <!-- Card: Keuntungan -->
            <div class="group relative overflow-hidden bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(59,130,246,0.12)] border border-slate-100/80 transition-all duration-300 transform hover:-translate-y-1">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                
                <div class="p-6 relative z-10 flex flex-col h-full justify-between gap-4">
                    <div class="flex items-start justify-between">
                        <div class="p-3.5 rounded-2xl bg-blue-100/80 text-blue-600 shadow-inner">
                            <svg class="w-6 h-6 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>
                        <span class="flex items-center text-xs font-semibold px-2 py-1 bg-blue-50 text-blue-600 rounded-lg">
                            +5% <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 mb-1">Keuntungan Hari Ini</p>
                        <h3 class="text-3xl font-extrabold tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-slate-900 to-slate-700">Rp {{ number_format($profitToday ?? 0, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>

            <!-- Card: Stok Menipis -->
            <div class="group relative overflow-hidden bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(239,68,68,0.12)] border border-slate-100/80 transition-all duration-300 transform hover:-translate-y-1">
                <div class="absolute inset-0 bg-gradient-to-br from-red-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-red-100 blur-2xl rounded-full opacity-50 group-hover:opacity-80 transition-opacity"></div>
                
                <div class="p-6 relative z-10 flex flex-col h-full justify-between gap-4">
                    <div class="flex items-start justify-between">
                        <div class="p-3.5 rounded-2xl bg-red-100/80 text-red-600 shadow-inner relative">
                            @if($lowStockProducts->count() > 0)
                                <span class="absolute -top-1 -right-1 flex h-3 w-3">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                                </span>
                            @endif
                            <svg class="w-6 h-6 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 mb-1">Stok Menipis</p>
                        <h3 class="text-3xl font-extrabold tracking-tight text-slate-800">{{ $lowStockProducts->count() }} <span class="text-lg font-semibold text-slate-400">Item</span></h3>
                    </div>
                </div>
            </div>
            
            <!-- Card: Top Item -->
            <div class="group relative overflow-hidden bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(168,85,247,0.12)] border border-slate-100/80 transition-all duration-300 transform hover:-translate-y-1">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                
                <div class="p-6 relative z-10 flex flex-col h-full justify-between gap-4">
                    <div class="flex items-start justify-between">
                        <div class="p-3.5 rounded-2xl bg-purple-100/80 text-purple-600 shadow-inner">
                            <svg class="w-6 h-6 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 mb-1">Top Item</p>
                        <h3 class="text-2xl font-extrabold tracking-tight text-slate-800 line-clamp-1" title="{{ $topProducts->first()->name ?? 'Belum ada' }}">{{ $topProducts->first()->name ?? '-' }}</h3>
                    </div>
                </div>
            </div>

        </div>

        <!-- Tables Row -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 mt-4">
            
            <!-- Stok Hampir Habis Table -->
            <div class="bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100/80 overflow-hidden flex flex-col">
                <div class="px-8 py-6 border-b border-slate-100/80 flex justify-between items-center bg-white/50 backdrop-blur-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-2.5 h-6 rounded-full bg-red-400"></div>
                        <h3 class="font-bold text-lg text-slate-800">Peringatan Stok Menipis</h3>
                    </div>
                    <a href="#" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">Lihat Semua</a>
                </div>
                
                <div class="p-0 overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead class="bg-slate-50/50">
                            <tr>
                                <th class="px-8 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Barang</th>
                                <th class="px-8 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Sisa Stok</th>
                                <th class="px-8 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Min Stok</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                            @forelse($lowStockProducts as $product)
                            <tr class="hover:bg-slate-50/80 transition-colors duration-200 group">
                                <td class="px-8 py-4 whitespace-nowrap text-sm font-semibold text-slate-800">{{ $product->name }}</td>
                                <td class="px-8 py-4 whitespace-nowrap text-sm">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100/80 text-red-700 group-hover:bg-red-200 transition-colors">
                                        {{ $product->stock }} {{ $product->unit }}
                                    </span>
                                </td>
                                <td class="px-8 py-4 whitespace-nowrap text-sm text-slate-500 font-medium">{{ $product->min_stock }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-8 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-3">
                                        <div class="w-16 h-16 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-500">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        <p class="text-sm font-semibold text-slate-600">Semua stok barang aman</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Barang Paling Laris Table -->
            <div class="bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100/80 overflow-hidden flex flex-col">
                <div class="px-8 py-6 border-b border-slate-100/80 flex justify-between items-center bg-white/50 backdrop-blur-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-2.5 h-6 rounded-full bg-purple-400"></div>
                        <h3 class="font-bold text-lg text-slate-800">Barang Paling Laris</h3>
                    </div>
                </div>
                
                <div class="p-0 overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead class="bg-slate-50/50">
                            <tr>
                                <th class="px-8 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider w-16">No</th>
                                <th class="px-8 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Barang</th>
                                <th class="px-8 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Terjual</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                            @forelse($topProducts as $index => $top)
                            <tr class="hover:bg-slate-50/80 transition-colors duration-200">
                                <td class="px-8 py-4 whitespace-nowrap text-sm font-bold text-slate-400">#{{ $index + 1 }}</td>
                                <td class="px-8 py-4 whitespace-nowrap text-sm font-semibold text-slate-800">{{ $top->name }}</td>
                                <td class="px-8 py-4 whitespace-nowrap text-sm text-slate-600">
                                    <div class="flex items-center font-bold text-emerald-600">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                        {{ $top->total_sold }}
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-8 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-3">
                                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-400">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                        </div>
                                        <p class="text-sm font-semibold text-slate-500">Belum ada data penjualan</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
