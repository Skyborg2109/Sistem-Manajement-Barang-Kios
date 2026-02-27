<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('users.index') }}" class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna' }}</h2>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100/80 p-8 animate-in fade-in slide-in-from-bottom-6 duration-700">
        <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" method="POST" class="space-y-6">
            @csrf
            @if(isset($user))
                @method('PUT')
            @endif
            
            <div>
                <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50/50 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors @error('name') border-red-500 @enderror" value="{{ old('name', $user->name ?? '') }}" required>
                @error('name') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-bold text-slate-700 mb-2">Alamat Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" id="email" class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50/50 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors @error('email') border-red-500 @enderror" value="{{ old('email', $user->email ?? '') }}" required>
                @error('email') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="role" class="block text-sm font-bold text-slate-700 mb-2">Peran (Role) <span class="text-red-500">*</span></label>
                <select name="role" id="role" class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50/50 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors @error('role') border-red-500 @enderror" required>
                    <option value="kasir" {{ old('role', $user->role ?? '') === 'kasir' ? 'selected' : '' }}>Kasir</option>
                    <option value="admin" {{ old('role', $user->role ?? '') === 'admin' ? 'selected' : '' }}>Administrator</option>
                </select>
                @error('role') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
                <div>
                    <label for="password" class="block text-sm font-bold text-slate-700 mb-2">Password {{ isset($user) ? '(Biarkan kosong jika tidak diubah)' : '*' }}</label>
                    <input type="password" name="password" id="password" class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50/50 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors @error('password') border-red-500 @enderror" {{ isset($user) ? '' : 'required' }}>
                    @error('password') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-slate-700 mb-2">Ulangi Password {{ isset($user) ? '' : '*' }}</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50/50 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors" {{ isset($user) ? '' : 'required' }}>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t border-slate-100 text-right mt-8">
                <a href="{{ route('users.index') }}" class="px-5 py-2.5 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">Batal</a>
                <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 shadow-lg shadow-emerald-500/20 rounded-xl transition-all">
                    Simpan Pengguna
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
