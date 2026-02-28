<!-- Mobile overlay backdrop -->
<div x-show="sidebarOpen" 
     x-transition:enter="transition-opacity ease-linear duration-300" 
     x-transition:enter-start="opacity-0" 
     x-transition:enter-end="opacity-100" 
     x-transition:leave="transition-opacity ease-linear duration-300" 
     x-transition:leave-start="opacity-100" 
     x-transition:leave-end="opacity-0" 
     class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm z-40 md:hidden" 
     @click="sidebarOpen = false"
     style="display: none;"></div>

<aside class="fixed inset-y-0 left-0 z-50 w-[280px] bg-[#022c22] border-r border-[#064e3b] flex flex-col transition-transform duration-300 md:relative md:translate-x-0"
       :class="{'translate-x-0 shadow-2xl': sidebarOpen, '-translate-x-full': !sidebarOpen}">
    <!-- Subtle glow effect behind logo -->
    <div class="absolute top-0 left-0 right-0 h-40 bg-emerald-500/10 blur-3xl pointer-events-none"></div>

    <div class="flex items-center px-8 py-8 relative z-10">
        <div class="w-14 h-14 rounded-2xl bg-white flex items-center justify-center shadow-lg shadow-emerald-500/10 mr-4 overflow-hidden p-1">
            <img src="{{ asset('images/logo.png') }}" alt="M-KIOS" class="w-full h-full object-contain">
        </div>
        <div class="flex flex-col">
            <span class="text-xl font-black tracking-tight text-white leading-tight uppercase">{{ $site_settings['shop_name'] ?? 'M-KIOS' }}</span>
            <div class="flex flex-col mt-0.5">
                <span class="text-[10px] font-bold text-emerald-400 tracking-[0.15em] uppercase leading-tight">Management System</span>
                @if(isset($site_settings['shop_address']))
                    <div class="flex items-center gap-2 mt-2">
                        <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span class="text-xs font-extrabold text-white tracking-wide truncate max-w-[180px]" title="{{ $site_settings['shop_address'] }}">
                            {{ $site_settings['shop_address'] }}
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Mobile close button -->
    <div class="md:hidden absolute top-6 right-6 z-20">
        <button @click="sidebarOpen = false" class="text-emerald-200 hover:text-white bg-white/5 p-2 rounded-lg backdrop-blur-sm transition-colors">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto hide-scrollbar relative z-10">
        <p class="px-4 text-xs font-bold text-emerald-500/70 uppercase tracking-widest mb-3 mt-4">Menu Utama</p>
        
        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('dashboard') ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20' : 'text-emerald-100 hover:bg-emerald-800/50 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-emerald-400 group-hover:text-emerald-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            Dashboard
        </a>

        @if(auth()->user()->role === 'admin')
        <p class="px-4 text-xs font-bold text-emerald-500/70 uppercase tracking-widest mb-3 mt-8">Manajemen Produk</p>

        <a href="{{ route('products.index') }}" class="flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('products.*') ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20' : 'text-emerald-100 hover:bg-emerald-800/50 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('products.*') ? 'text-white' : 'text-emerald-400 group-hover:text-emerald-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            Data Barang
        </a>

        <a href="{{ route('categories.index') }}" class="flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('categories.*') ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20' : 'text-emerald-100 hover:bg-emerald-800/50 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('categories.*') ? 'text-white' : 'text-emerald-400 group-hover:text-emerald-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
            Kategori
        </a>

        @endif

        <p class="px-4 text-xs font-bold text-emerald-500/70 uppercase tracking-widest mb-3 mt-8">Operasional</p>

        <a href="{{ route('transactions.index') }}" class="flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('transactions.*') ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20' : 'text-emerald-100 hover:bg-emerald-800/50 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('transactions.*') ? 'text-white' : 'text-emerald-400 group-hover:text-emerald-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            Kasir / Transaksi
        </a>

        <a href="{{ route('customers.index') }}" class="flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('customers.*') ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20' : 'text-emerald-100 hover:bg-emerald-800/50 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('customers.*') ? 'text-white' : 'text-emerald-400 group-hover:text-emerald-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            Data Pelanggan
        </a>

        @if(auth()->user()->role === 'admin')
        <a href="{{ route('suppliers.index') }}" class="flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('suppliers.*') ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20' : 'text-emerald-100 hover:bg-emerald-800/50 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('suppliers.*') ? 'text-white' : 'text-emerald-400 group-hover:text-emerald-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            Data Supplier
        </a>
        @endif

        @if(auth()->user()->role === 'admin')
        <a href="{{ route('purchases.index') }}" class="flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('purchases.*') ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20' : 'text-emerald-100 hover:bg-emerald-800/50 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('purchases.*') ? 'text-white' : 'text-emerald-400 group-hover:text-emerald-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
            Gudang Masuk
        </a>
        @endif

        <a href="{{ route('debts.index') }}" class="flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('debts.*') ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20' : 'text-emerald-100 hover:bg-emerald-800/50 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('debts.*') ? 'text-white' : 'text-emerald-400 group-hover:text-emerald-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            Piutang Pelanggan
        </a>

        <p class="px-4 text-xs font-bold text-emerald-500/70 uppercase tracking-widest mb-3 mt-8">Lainnya</p>

        @if(auth()->user()->role === 'admin')
        <a href="{{ route('reports.index') }}" class="flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('reports.*') ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20' : 'text-emerald-100 hover:bg-emerald-800/50 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('reports.*') ? 'text-white' : 'text-emerald-400 group-hover:text-emerald-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Laporan
        </a>
        @endif

        <a href="{{ route('activities.index') }}" class="flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('activities.*') ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20' : 'text-emerald-100 hover:bg-emerald-800/50 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('activities.*') ? 'text-white' : 'text-emerald-400 group-hover:text-emerald-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Log Aktivitas
        </a>

        @if(auth()->user()->role === 'admin')
        <a href="{{ route('users.index') }}" class="flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('users.*') ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20' : 'text-emerald-100 hover:bg-emerald-800/50 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('users.*') ? 'text-white' : 'text-emerald-400 group-hover:text-emerald-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            Pengguna
        </a>

        <a href="{{ route('settings.index') }}" class="flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('settings.*') ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20' : 'text-emerald-100 hover:bg-emerald-800/50 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('settings.*') ? 'text-white' : 'text-emerald-400 group-hover:text-emerald-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            Pengaturan
        </a>
        @endif
    </nav>
    
    <div class="p-4 border-t border-[#064e3b]">
        <!-- Upgrade or Info card -->
        <div class="bg-[#064e3b]/50 rounded-2xl p-4 overflow-hidden relative group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-500/20 blur-xl rounded-full"></div>
            <p class="text-xs text-emerald-200 mb-1">Status Lisensi</p>
            <p class="text-sm font-bold text-white relative z-10 flex items-center">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 mr-2 shadow-[0_0_8px_rgb(52,211,153)]"></span> Aktif
            </p>
        </div>
    </div>
</aside>
