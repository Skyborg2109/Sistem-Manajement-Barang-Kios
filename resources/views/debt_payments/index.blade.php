<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('debts.index') }}" class="p-2 bg-white rounded-xl shadow-sm border border-slate-100 text-slate-400 hover:text-emerald-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Riwayat Cicilan</h2>
                <p class="text-sm text-slate-500 mt-1">Invoice: <span class="font-bold text-emerald-600">{{ $debt->transaction->invoice_code }}</span> • Pelanggan: <span class="font-bold">{{ $debt->customer->name }}</span></p>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Summary Card -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-[2rem] p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100/80">
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-6">Ringkasan Piutang</h3>
                
                <div class="space-y-6">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Tagihan</p>
                        <p class="text-2xl font-black text-slate-800">Rp {{ number_format($debt->transaction->total, 0, ',', '.') }}</p>
                    </div>
                    
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Sudah Dibayar</p>
                        <p class="text-2xl font-black text-emerald-600">Rp {{ number_format($debt->transaction->payment, 0, ',', '.') }}</p>
                    </div>

                    <div class="pt-6 border-t border-slate-50">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Sisa Hutang</p>
                        <p class="text-3xl font-black text-red-600">Rp {{ number_format($debt->amount, 0, ',', '.') }}</p>
                    </div>

                    @if($debt->status === 'paid')
                        <div class="mt-4 px-4 py-3 bg-emerald-50 rounded-2xl flex items-center gap-3 text-emerald-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-sm font-bold uppercase tracking-wider">Status: Lunas</span>
                        </div>
                    @else
                        <div class="mt-4 px-4 py-3 bg-red-50 rounded-2xl flex items-center gap-3 text-red-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-sm font-bold uppercase tracking-wider">Status: Belum Lunas</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- History Table -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100/80 overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-50 bg-slate-50/50 flex justify-between items-center">
                    <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Daftar Pembayaran</h3>
                    <span class="text-xs font-bold text-slate-500">{{ $payments->count() }} Kali Pembayaran</span>
                </div>
                
                <div class="p-0">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead class="bg-slate-50/30">
                            <tr>
                                <th class="px-8 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Waktu</th>
                                <th class="px-8 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Jumlah</th>
                                <th class="px-8 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Catatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($payments as $payment)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <p class="text-sm font-bold text-slate-700">{{ $payment->created_at->format('d/m/Y H:i') }}</p>
                                        <p class="text-[10px] text-slate-400 italic">{{ $payment->created_at->diffForHumans() }}</p>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap text-sm font-black text-emerald-600">
                                        Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-8 py-5 text-sm text-slate-500 font-medium">
                                        {{ $payment->note ?: '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-8 py-20 text-center">
                                        <div class="flex flex-col items-center justify-center space-y-4">
                                            <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-300">
                                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Belum ada cicilan yang dibayar</p>
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
