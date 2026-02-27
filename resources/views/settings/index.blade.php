<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight text-center sm:text-left">Pengaturan Sistem</h2>
        <p class="text-sm text-slate-500 mt-1 text-center sm:text-left">Sesuaikan identitas kios dan preferensi aplikasi</p>
    </x-slot>

    @if (session('success'))
        <div class="mb-6 px-6 py-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center shadow-sm animate-in fade-in duration-300">
            <svg class="w-6 h-6 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-bold">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 px-6 py-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl flex items-center shadow-sm animate-in fade-in duration-300">
            <svg class="w-6 h-6 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-bold">{{ session('error') }}</span>
        </div>
    @endif

    <div class="max-w-4xl">
        @if($settings->count() > 0)
            <form action="{{ route('settings.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    @foreach($settings as $group => $items)
                        <div class="bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100/80 overflow-hidden">
                            <div class="px-8 py-6 border-b border-slate-50 bg-slate-50/30">
                                <h3 class="text-lg font-extrabold text-slate-800 uppercase tracking-tight">{{ ucfirst($group) }}</h3>
                            </div>
                            
                            <div class="p-8 space-y-6">
                                @foreach($items as $setting)
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2">{{ $setting->label }}</label>
                                        @if($setting->type === 'text')
                                            <input type="text" name="settings[{{ $setting->key }}]" value="{{ $setting->value }}" class="w-full px-5 py-3 border border-slate-200 rounded-2xl bg-slate-50/50 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all font-medium">
                                        @elseif($setting->type === 'textarea')
                                            <textarea name="settings[{{ $setting->key }}]" rows="3" class="w-full px-5 py-3 border border-slate-200 rounded-2xl bg-slate-50/50 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all font-medium">{{ $setting->value }}</textarea>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    
                    <div class="flex justify-end pt-2">
                        <button type="submit" class="px-8 py-3 bg-emerald-600 text-white text-sm font-bold uppercase tracking-wider rounded-2xl hover:bg-emerald-700 hover:shadow-lg hover:shadow-emerald-500/20 transition-all active:scale-95 shadow-md shadow-emerald-500/10 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        @else
            <div class="bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100/80 p-16 text-center">
                <div class="w-24 h-24 bg-slate-50 rounded-[2.5rem] flex items-center justify-center text-slate-300 mx-auto mb-6 border-4 border-white shadow-inner">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.543-.426-1.543-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <h3 class="text-xl font-black text-slate-800 mb-2">Data Pengaturan Kosong</h3>
                <p class="text-slate-500 max-w-sm mx-auto mb-8 font-medium">Sepertinya data pengaturan dasar belum dibuat di database Railway Anda.</p>
                
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <form action="{{ route('settings.initialize') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-8 py-3 bg-emerald-600 text-white font-bold rounded-2xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">
                            Inisialisasi Data Dasar
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
