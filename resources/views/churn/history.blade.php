<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TAcessa - Riwayat Prediksi</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen font-sans">

    {{-- NAVBAR --}}
    <nav class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-gradient-to-br from-red-700 to-pink-500 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-brain text-white text-sm"></i>
                </div>
                <span class="text-xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-red-700 to-pink-500 tracking-wider">TACESSA</span>
            </div>
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('churn.index') }}" class="nav-link px-4 py-2 rounded-lg text-sm font-semibold text-gray-500 hover:bg-gray-100 hover:text-red-700 transition-all">
                    <i class="fa-solid fa-gauge-high mr-1.5"></i> Dashboard
                </a>
                <a href="{{ route('churn.index') }}" class="nav-link px-4 py-2 rounded-lg text-sm font-semibold text-gray-500 hover:bg-gray-100 hover:text-red-700 transition-all">
                    <i class="fa-solid fa-user mr-1.5"></i> Single Prediction
                </a>
                <a href="{{ route('churn.index') }}" class="nav-link px-4 py-2 rounded-lg text-sm font-semibold text-gray-500 hover:bg-gray-100 hover:text-red-700 transition-all">
                    <i class="fa-solid fa-file-excel mr-1.5"></i> Bulk Prediction
                </a>
                <a href="{{ route('churn.history') }}" class="nav-link px-4 py-2 rounded-lg text-sm font-semibold bg-red-50 text-red-700 transition-all">
                    <i class="fa-solid fa-clock-rotate-left mr-1.5"></i> Riwayat
                </a>
                <a href="{{ route('churn.index') }}" class="nav-link px-4 py-2 rounded-lg text-sm font-semibold text-gray-500 hover:bg-gray-100 hover:text-red-700 transition-all">
                    <i class="fa-solid fa-circle-info mr-1.5"></i> About
                </a>
            </div>
            <button onclick="toggleMobileMenu()" class="md:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100">
                <i class="fa-solid fa-bars text-lg"></i>
            </button>
        </div>
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100 px-4 py-3 space-y-1">
            <a href="{{ route('churn.index') }}"   class="block px-4 py-2 rounded-lg text-sm font-semibold text-gray-600 hover:bg-red-50 hover:text-red-700"><i class="fa-solid fa-gauge-high mr-2"></i>Dashboard</a>
            <a href="{{ route('churn.history') }}" class="block px-4 py-2 rounded-lg text-sm font-semibold bg-red-50 text-red-700"><i class="fa-solid fa-clock-rotate-left mr-2"></i>Riwayat</a>
            <a href="{{ route('churn.index') }}"   class="block px-4 py-2 rounded-lg text-sm font-semibold text-gray-600 hover:bg-red-50 hover:text-red-700"><i class="fa-solid fa-circle-info mr-2"></i>About</a>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-4 py-8">

        {{-- HEADER --}}
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-800">Riwayat Prediksi</h2>
                <p class="text-gray-400 text-sm mt-1">Seluruh riwayat prediksi single maupun bulk yang telah dilakukan</p>
            </div>
            <a href="{{ route('churn.index') }}" class="px-5 py-2.5 bg-gradient-to-r from-red-700 to-red-900 text-white text-sm font-bold rounded-xl shadow hover:shadow-md transition">
                <i class="fa-solid fa-plus mr-2"></i> Prediksi Baru
            </a>
        </div>

        {{-- STATISTIK RINGKASAN --}}
        @php
            $totalSingle = $histories->where('type', 'single')->count();
            $totalBulk   = $histories->where('type', 'bulk')->count();
            $totalChurn  = $histories->where('type', 'single')->where('prediction_result', 'Potential Churn')->count();
            $totalNon    = $histories->where('type', 'single')->where('prediction_result', 'Non-Churn')->count();
        @endphp
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-2xl p-4 text-center border border-gray-100 shadow-sm">
                <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Total Prediksi</p>
                <p class="text-3xl font-extrabold text-gray-800 mt-1">{{ $histories->total() }}</p>
            </div>
            <div class="bg-white rounded-2xl p-4 text-center border border-blue-100 shadow-sm">
                <p class="text-xs text-blue-400 font-semibold uppercase tracking-wider">Single</p>
                <p class="text-3xl font-extrabold text-blue-600 mt-1">{{ $totalSingle }}</p>
            </div>
            <div class="bg-white rounded-2xl p-4 text-center border border-pink-100 shadow-sm">
                <p class="text-xs text-pink-400 font-semibold uppercase tracking-wider">Bulk Upload</p>
                <p class="text-3xl font-extrabold text-pink-600 mt-1">{{ $totalBulk }}</p>
            </div>
            <div class="bg-white rounded-2xl p-4 text-center border border-red-100 shadow-sm">
                <p class="text-xs text-red-400 font-semibold uppercase tracking-wider">Potential Churn</p>
                <p class="text-3xl font-extrabold text-red-600 mt-1">{{ $totalChurn }}</p>
            </div>
        </div>

        {{-- TABEL RIWAYAT --}}
        <div class="bg-white rounded-3xl border border-gray-200 shadow-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-red-600"></i> Log Prediksi
                </h3>
                <span class="text-xs text-gray-400">Menampilkan {{ $histories->count() }} dari {{ $histories->total() }} data</span>
            </div>

            @if($histories->isEmpty())
                <div class="py-20 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-inbox text-gray-300 text-2xl"></i>
                    </div>
                    <p class="text-gray-400 font-medium">Belum ada riwayat prediksi</p>
                    <p class="text-gray-300 text-sm mt-1">Lakukan prediksi pertamamu!</p>
                    <a href="{{ route('churn.index') }}" class="mt-4 inline-block px-6 py-2.5 bg-gradient-to-r from-red-700 to-red-900 text-white text-sm font-bold rounded-xl">
                        Mulai Prediksi
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-500 uppercase text-xs border-b border-gray-100">
                            <tr>
                                <th class="px-5 py-3">No</th>
                                <th class="px-5 py-3">Tipe</th>
                                <th class="px-5 py-3">Detail</th>
                                <th class="px-5 py-3">Hasil</th>
                                <th class="px-5 py-3">Probabilitas / Churn Rate</th>
                                <th class="px-5 py-3">Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($histories as $i => $h)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-5 py-4 text-gray-400 font-medium">{{ $histories->firstItem() + $i }}</td>

                                {{-- TIPE --}}
                                <td class="px-5 py-4">
                                    @if($h->type == 'single')
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700">
                                            <i class="fa-solid fa-user mr-1"></i> Single
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-pink-100 text-pink-700">
                                            <i class="fa-solid fa-file-excel mr-1"></i> Bulk
                                        </span>
                                    @endif
                                </td>

                                {{-- DETAIL --}}
                                <td class="px-5 py-4">
                                    @if($h->type == 'single')
                                        <div class="text-xs text-gray-600 space-y-0.5">
                                            <div><span class="text-gray-400">Tenure:</span> {{ $h->tenure }} bulan</div>
                                            <div><span class="text-gray-400">Tagihan/bln:</span> Rp {{ number_format($h->monthly_charge, 0, ',', '.') }}</div>
                                            <div><span class="text-gray-400">Total:</span> Rp {{ number_format($h->total_charges, 0, ',', '.') }}</div>
                                        </div>
                                    @else
                                        <div class="text-xs text-gray-600 space-y-0.5">
                                            <div><span class="text-gray-400">File:</span> <span class="font-medium">{{ $h->filename }}</span></div>
                                            <div><span class="text-gray-400">Total data:</span> {{ $h->total_data }} pelanggan</div>
                                            <div><span class="text-gray-400">Churn:</span> {{ $h->churn_count }} | Non-Churn: {{ $h->nonchurn_count }}</div>
                                        </div>
                                    @endif
                                </td>

                                {{-- HASIL --}}
                                <td class="px-5 py-4">
                                    @if($h->type == 'single')
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $h->prediction_result == 'Potential Churn' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                            <i class="fa-solid {{ $h->prediction_result == 'Potential Churn' ? 'fa-triangle-exclamation' : 'fa-circle-check' }} mr-1"></i>
                                            {{ $h->prediction_result }}
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-700">
                                            <i class="fa-solid fa-chart-bar mr-1"></i> Bulk Result
                                        </span>
                                    @endif
                                </td>

                                {{-- PROBABILITAS --}}
                                <td class="px-5 py-4 font-bold {{ $h->type == 'single' && $h->prediction_result == 'Potential Churn' ? 'text-red-600' : 'text-gray-700' }}">
                                    {{ $h->probability }}
                                </td>

                                {{-- WAKTU --}}
                                <td class="px-5 py-4 text-xs text-gray-400">
                                    <div>{{ $h->created_at->format('d M Y') }}</div>
                                    <div class="font-medium text-gray-500">{{ $h->created_at->format('H:i:s') }}</div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                @if($histories->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                    <p class="text-xs text-gray-400">Halaman {{ $histories->currentPage() }} dari {{ $histories->lastPage() }}</p>
                    <div class="flex gap-2">
                        @if($histories->onFirstPage())
                            <span class="px-3 py-1.5 rounded-lg text-xs text-gray-300 border border-gray-100">← Prev</span>
                        @else
                            <a href="{{ $histories->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg text-xs text-gray-600 border border-gray-200 hover:bg-red-50 hover:text-red-700 transition">← Prev</a>
                        @endif
                        @if($histories->hasMorePages())
                            <a href="{{ $histories->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg text-xs text-gray-600 border border-gray-200 hover:bg-red-50 hover:text-red-700 transition">Next →</a>
                        @else
                            <span class="px-3 py-1.5 rounded-lg text-xs text-gray-300 border border-gray-100">Next →</span>
                        @endif
                    </div>
                </div>
                @endif
            @endif
        </div>

    </div>

    <script>
        function toggleMobileMenu() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        }
    </script>
</body>
</html>