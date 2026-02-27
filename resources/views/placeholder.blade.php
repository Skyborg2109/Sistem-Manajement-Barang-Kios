<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">
                    {{ $title ?? 'Halaman' }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Sistem Manajemen Kios & Penjualan</p>
            </div>
        </div>
    </x-slot>

    <div class="bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100/80 p-8 text-center animate-in fade-in slide-in-from-bottom-6 duration-700">
        <div class="flex flex-col items-center justify-center space-y-4 py-16">
            <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-500">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
            <h3 class="text-2xl font-bold text-slate-800">Upps! {{ $title ?? 'Halaman' }}</h3>
            <p class="text-slate-500 max-w-md">Modul {{ strtolower($title ?? 'ini') }} sedang dalam tahap pengembangan. Silakan kembali lagi nanti untuk melihat fitur lengkapnya!</p>
            <a href="{{ route('dashboard') }}" class="mt-4 px-6 py-3 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-700 transition-colors shadow-lg shadow-emerald-500/20">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</x-app-layout>
