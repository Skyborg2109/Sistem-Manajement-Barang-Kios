<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Piutang Pelanggan</h2>
        <p class="text-sm text-slate-500 mt-1">Kelola data pelanggan yang berhutang</p>
    </x-slot>

    @if (session('success'))
        <div class="mb-6 px-6 py-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center shadow-sm">
            <svg class="w-6 h-6 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="mb-6 px-6 py-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl flex items-center shadow-sm">
            <svg class="w-6 h-6 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100/80 overflow-hidden animate-in fade-in slide-in-from-bottom-6 duration-700">
        <div class="p-0 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Invoice / Transaksi</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Pelanggan</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Sisa Hutang</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                    @forelse ($debts as $debt)
                    <tr class="hover:bg-slate-50/80 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $debt->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('transactions.show', $debt->transaction_id) }}" class="font-bold text-emerald-600 hover:text-emerald-700 hover:underline flex items-center gap-1">
                                {{ $debt->transaction->invoice_code ?? '-' }}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-800">
                            {{ $debt->customer->name ?? '-' }}
                            @if($debt->customer)
                                <div class="text-xs font-normal text-slate-500">{{ $debt->customer->phone }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-red-600 text-right">Rp {{ number_format($debt->amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                            @if($debt->status === 'paid')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-emerald-100/80 text-emerald-700">Lunas</span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100/80 text-red-700">Belum Lunas</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center" x-data="{ 
                            modalOpen: false, 
                            amount: {{ $debt->amount }},
                            note: ''
                        }">
                            @if($debt->status === 'unpaid')
                                <div class="flex items-center justify-center gap-2">
                                    <button @click="modalOpen = true" class="px-3 py-1.5 bg-emerald-600 text-white text-[10px] font-black uppercase tracking-wider rounded-xl hover:bg-emerald-700 transition-all shadow-sm">
                                        Bayar Cicilan
                                    </button>
                                    
                                    <form action="{{ route('debts.update', $debt->id) }}" method="POST" onsubmit="return confirm('Tandai hutang ini sebagai lunas?');" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="px-3 py-1.5 bg-slate-800 text-white text-[10px] font-black uppercase tracking-wider rounded-xl hover:bg-slate-700 transition-all shadow-sm">
                                            Lunasi
                                        </button>
                                    </form>

                                    <a href="{{ route('debts.payments', $debt->id) }}" class="px-3 py-1.5 bg-slate-100 text-slate-600 text-[10px] font-black uppercase tracking-wider rounded-xl hover:bg-slate-200 transition-all">
                                        Riwayat
                                    </a>
                                </div>

                                <!-- Payment Modal -->
                                <template x-teleport="body">
                                    <div x-show="modalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
                                        <div @click.away="modalOpen = false" class="bg-white rounded-[2rem] shadow-2xl w-full max-w-md overflow-hidden animate-in zoom-in duration-200" x-show="modalOpen">
                                            <div class="px-8 py-6 border-b border-slate-50 bg-slate-50/50">
                                                <h3 class="text-xl font-extrabold text-slate-800">Bayar Cicilan</h3>
                                                <p class="text-xs text-slate-500 mt-1">Pembayaran hutang untuk invoice <span class="font-bold text-emerald-600">{{ $debt->transaction->invoice_code }}</span></p>
                                            </div>
                                            
                                            <form :action="'{{ route('debts.pay', $debt->id) }}'" method="POST" class="p-8 space-y-6">
                                                @csrf
                                                <div>
                                                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Jumlah Bayar (Rp)</label>
                                                    <div class="relative">
                                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">Rp</span>
                                                        <input type="number" name="amount" x-model.number="amount" class="w-full pl-12 pr-4 py-4 border border-slate-200 rounded-2xl bg-slate-50 focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all text-lg font-bold" :max="{{ $debt->amount }}" min="1" required>
                                                    </div>
                                                    <p class="text-[10px] text-slate-400 mt-2 italic">Maksimal: <span class="font-bold text-red-500">Rp {{ number_format($debt->amount, 0, ',', '.') }}</span></p>
                                                </div>

                                                <div>
                                                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Catatan (Opsional)</label>
                                                    <textarea name="note" x-model="note" class="w-full px-4 py-3 border border-slate-200 rounded-2xl bg-slate-50 focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all text-sm font-medium" rows="2" placeholder="Contoh: Titipan awal, Transfer Bank, dll."></textarea>
                                                </div>

                                                <div class="flex gap-3 pt-2">
                                                    <button type="button" @click="modalOpen = false" class="flex-1 py-4 bg-slate-100 text-slate-600 font-extrabold rounded-2xl hover:bg-slate-200 transition-all">
                                                        Batal
                                                    </button>
                                                    <button type="submit" class="flex-1 py-4 bg-emerald-600 text-white font-extrabold rounded-2xl hover:bg-emerald-700 hover:shadow-xl shadow-emerald-500/20 shadow-lg transition-all active:scale-95">
                                                        Bayar Sekarang
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </template>
                            @else
                                <div class="flex items-center justify-center gap-2">
                                    <span class="text-emerald-500 font-black text-[10px] uppercase tracking-widest bg-emerald-50 px-3 py-1 rounded-lg">Lunas</span>
                                    <a href="{{ route('debts.payments', $debt->id) }}" class="px-3 py-1.5 bg-slate-100 text-slate-600 text-[10px] font-black uppercase tracking-wider rounded-xl hover:bg-slate-200 transition-all">
                                        Riwayat
                                    </a>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center space-y-3">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-400">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                </div>
                                <p class="text-sm font-semibold text-slate-500">Belum ada data piutang / hutang</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($debts->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $debts->links() }}
        </div>
        @endif
    </div>
</x-app-layout>
