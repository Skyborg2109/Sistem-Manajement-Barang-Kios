<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Data Pelanggan</h2>
                <p class="text-sm text-slate-500 mt-1">Kelola data pelanggan kios Anda</p>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('customers.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold rounded-xl text-white bg-emerald-600 hover:bg-emerald-700 shadow-lg shadow-emerald-500/20 transition-all">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    Tambah Pelanggan
                </a>
            </div>
        </div>
    </x-slot>

    @if (session('success'))
        <div class="mb-6 px-6 py-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center shadow-sm">
            <svg class="w-6 h-6 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100/80 overflow-hidden animate-in fade-in slide-in-from-bottom-6 duration-700">
        <div class="p-0 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider w-16">No</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">No. Telepon</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Alamat</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                    @forelse ($customers as $index => $customer)
                    <tr class="hover:bg-slate-50/80 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-400">#{{ $customers->firstItem() + $index }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-800">{{ $customer->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $customer->phone ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600 max-w-xs truncate">{{ $customer->address ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right flex justify-end gap-2">
                            <a href="{{ route('customers.edit', [$customer->id, 'page' => $customers->currentPage()]) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('customers.destroy', [$customer->id, 'page' => $customers->currentPage()]) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center space-y-3">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-400">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                </div>
                                <p class="text-sm font-semibold text-slate-500">Belum ada data pelanggan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($customers->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $customers->links() }}
        </div>
        @endif
    </div>
</x-app-layout>
