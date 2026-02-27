<header class="flex items-center justify-between px-8 py-5 bg-white/80 backdrop-blur-xl border-b border-slate-200/60 shadow-[0_4px_20px_rgb(0,0,0,0.02)] z-20 w-full relative">
    <div class="flex items-center">
        <button @click="sidebarOpen = !sidebarOpen" class="text-slate-500 hover:text-emerald-600 focus:outline-none md:hidden transition-colors mr-4 bg-slate-100/80 p-2 rounded-xl">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <div class="hidden md:flex relative group">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-slate-400 group-focus-within:text-emerald-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" class="block w-96 pl-10 pr-4 py-2.5 border border-slate-200 rounded-2xl leading-5 bg-slate-50/50 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:bg-white transition-all sm:text-sm" placeholder="Cari barang, transaksi, atau pelanggan...">
        </div>
    </div>

    <div class="flex items-center gap-6">
        @php
            $activities = \App\Models\Activity::getLatest(5);
            $unreadCount = \App\Models\Activity::unreadCount();
        @endphp
        <div class="relative" x-data="{ 
            notificationsOpen: false, 
            unread: {{ $unreadCount }},
            markAsRead() {
                if(this.unread > 0) {
                    fetch('{{ route('activities.markAsRead') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    }).then(() => {
                        this.unread = 0;
                    });
                }
            },
            toggleNotifications() {
                this.notificationsOpen = !this.notificationsOpen;
                if(this.notificationsOpen) this.markAsRead();
            }
        }">
            <button @click="toggleNotifications()" class="relative text-slate-400 hover:text-emerald-600 transition-colors bg-slate-100/30 p-2 rounded-xl">
                <template x-if="unread > 0">
                    <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 border-2 border-white rounded-full"></span>
                </template>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            </button>

            <!-- Notification Dropdown -->
            <div x-show="notificationsOpen" @click.away="notificationsOpen = false" 
                class="absolute right-0 w-96 mt-3 bg-white rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] border border-slate-100 z-50 transform origin-top-right transition-all overflow-hidden" 
                style="width: 380px;"
                x-transition:enter="transition ease-out duration-200" 
                x-transition:enter-start="opacity-0 scale-95" 
                x-transition:enter-end="opacity-100 scale-100" 
                x-transition:leave="transition ease-in duration-100" 
                x-transition:leave-start="opacity-100 scale-100" 
                x-transition:leave-end="opacity-0 scale-95">
                
                <div class="px-6 py-4 border-b border-slate-50 bg-slate-50/50 flex justify-between items-center">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Aktivitas Terkini</span>
                    <span x-show="unread > 0" class="bg-emerald-500 text-white text-[10px] font-black px-3 py-1 rounded-full whitespace-nowrap shadow-sm">
                        <span x-text="unread"></span> Baru
                    </span>
                    <span x-show="unread === 0" class="bg-slate-200 text-slate-500 text-[10px] font-black px-3 py-1 rounded-full whitespace-nowrap">
                        Terbaca
                    </span>
                </div>

                <div class="max-h-[400px] overflow-y-auto divide-y divide-slate-50">
                    @forelse($activities as $activity)
                        <div class="px-6 py-4 hover:bg-slate-50/80 transition-colors flex items-start gap-4 group">
                            <div class="flex-shrink-0">
                                @php
                                    $bgColor = 'bg-slate-100'; $textColor = 'text-slate-500';
                                    if($activity->type === 'transaction') { $bgColor = 'bg-emerald-100'; $textColor = 'text-emerald-600'; }
                                    elseif($activity->type === 'purchase') { $bgColor = 'bg-blue-100'; $textColor = 'text-blue-600'; }
                                    elseif($activity->type === 'debt') { $bgColor = 'bg-red-100'; $textColor = 'text-red-600'; }
                                    elseif($activity->type === 'inventory') { $bgColor = 'bg-amber-100'; $textColor = 'text-amber-600'; }
                                @endphp
                                <div class="w-10 h-10 rounded-xl {{ $bgColor }} {{ $textColor }} flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    @if($activity->type === 'transaction')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    @elseif($activity->type === 'purchase')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    @elseif($activity->type === 'debt')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                    @else
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[13px] font-bold text-slate-700 leading-relaxed mb-1">{{ $activity->description }}</p>
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] font-black text-emerald-600 uppercase">{{ $activity->user->name ?? 'System' }}</span>
                                    <span class="text-[10px] font-bold text-slate-300">•</span>
                                    <span class="text-[10px] font-medium text-slate-400">{{ $activity->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="py-16 text-center">
                            <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-300 mx-auto mb-4 border-4 border-white shadow-inner">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            </div>
                            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Belum ada aktivitas</p>
                        </div>
                    @endforelse
                </div>
                <a href="{{ route('activities.index') }}" class="block py-4 bg-slate-50/80 hover:bg-slate-100 text-center text-[11px] font-black text-slate-500 uppercase tracking-[0.2em] transition-colors border-t border-slate-100">
                    Lihat Semua Aktivitas
                </a>
            </div>
        </div>

        <div class="h-8 w-px bg-slate-200"></div>

        <div class="relative" x-data="{ dropdownOpen: false }">
            <button @click="dropdownOpen = !dropdownOpen" class="flex items-center gap-3 relative focus:outline-none group">
                <div class="flex flex-col items-end hidden sm:flex">
                    <span class="text-sm font-extrabold text-slate-800">{{ Auth::user()->name }}</span>
                    <span class="text-[11px] font-bold tracking-wide text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md uppercase">{{ ucfirst(Auth::user()->role) }}</span>
                </div>
                <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white font-bold shadow-md shadow-emerald-500/20 group-hover:shadow-emerald-500/40 transition-shadow">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>

            <div x-show="dropdownOpen" @click.away="dropdownOpen = false" class="absolute right-0 w-56 mt-3 overflow-hidden bg-white/95 backdrop-blur-xl rounded-2xl shadow-[0_10px_40px_rgb(0,0,0,0.08)] border border-slate-100 z-50 transform origin-top-right transition-all" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" style="display: none;">
                <div class="px-4 py-3 border-b border-slate-100 bg-slate-50/50">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">{{ $site_settings['shop_name'] ?? 'M-KIOS' }}</p>
                    <p class="text-sm font-bold text-slate-800 truncate">{{ Auth::user()->email }}</p>
                </div>
                <div class="p-2 pt-2 pb-2">
                    <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-emerald-50 rounded-xl hover:text-emerald-600 transition-colors">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Profil Saya
                    </a>
                    <a href="{{ route('settings.index') }}" class="flex items-center px-4 py-3.5 text-sm font-semibold text-slate-700 hover:bg-emerald-50 rounded-xl hover:text-emerald-600 transition-colors">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Pengaturan
                    </a>
                </div>
                <div class="p-2 border-t border-slate-100">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-center px-4 py-2.5 text-sm font-bold text-red-600 hover:bg-red-50 rounded-xl transition-colors">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Keluar Sign Out
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
