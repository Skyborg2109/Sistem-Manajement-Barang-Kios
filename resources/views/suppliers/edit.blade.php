<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('suppliers.index', ['page' => $page ?? 1]) }}" class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ isset($supplier) ? 'Edit Supplier' : 'Tambah Supplier' }}</h2>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100/80 p-8 animate-in fade-in slide-in-from-bottom-6 duration-700">
        <form action="{{ isset($supplier) ? route('suppliers.update', $supplier->id) : route('suppliers.store') }}" method="POST" class="space-y-6">
            @csrf
            @if(isset($supplier))
                @method('PUT')
                <input type="hidden" name="page" value="{{ $page ?? 1 }}">
            @endif
            
            <div>
                <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Nama Supplier <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50/50 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors @error('name') border-red-500 @enderror" value="{{ old('name', $supplier->name ?? '') }}" required>
                @error('name') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="phone" class="block text-sm font-bold text-slate-700 mb-2">No. Telepon</label>
                <input type="text" name="phone" id="phone" class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50/50 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors @error('phone') border-red-500 @enderror" value="{{ old('phone', $supplier->phone ?? '') }}">
                @error('phone') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="address" class="block text-sm font-bold text-slate-700 mb-2">Alamat</label>
                <textarea name="address" id="address" rows="3" class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50/50 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors @error('address') border-red-500 @enderror">{{ old('address', $supplier->address ?? '') }}</textarea>
                @error('address') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 text-right mt-8">
                <a href="{{ route('suppliers.index', ['page' => $page ?? 1]) }}" class="px-5 py-2.5 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">Batal</a>
                <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 shadow-lg shadow-emerald-500/20 rounded-xl transition-all">
                    Simpan Supplier
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
