<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TAcessa - Churn Predictor System</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen font-sans">

    {{-- ═══════════════ NAVBAR ═══════════════ --}}
    <nav class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-gradient-to-br from-red-700 to-pink-500 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-brain text-white text-sm"></i>
                </div>
                <span class="text-xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-red-700 to-pink-500 tracking-wider">TACESSA</span>
            </div>

            {{-- Menu Desktop --}}
            <div class="hidden md:flex items-center gap-1">
                <a href="#" onclick="showSection('dashboard')" id="nav-dashboard"
                   class="nav-link px-4 py-2 rounded-lg text-sm font-semibold transition-all bg-red-50 text-red-700">
                    <i class="fa-solid fa-gauge-high mr-1.5"></i> Dashboard
                </a>
                <a href="#" onclick="showSection('single')" id="nav-single"
                   class="nav-link px-4 py-2 rounded-lg text-sm font-semibold transition-all text-gray-500 hover:bg-gray-100 hover:text-red-700">
                    <i class="fa-solid fa-user mr-1.5"></i> Single Prediction
                </a>
                <a href="#" onclick="showSection('bulk')" id="nav-bulk"
                   class="nav-link px-4 py-2 rounded-lg text-sm font-semibold transition-all text-gray-500 hover:bg-gray-100 hover:text-red-700">
                    <i class="fa-solid fa-file-excel mr-1.5"></i> Bulk Prediction
                </a>
                <a href="{{ route('churn.history') }}" id="nav-history"
                   class="nav-link px-4 py-2 rounded-lg text-sm font-semibold transition-all text-gray-500 hover:bg-gray-100 hover:text-red-700">
                    <i class="fa-solid fa-clock-rotate-left mr-1.5"></i> Riwayat
                </a>
                <a href="#" onclick="showSection('about')" id="nav-about"
                   class="nav-link px-4 py-2 rounded-lg text-sm font-semibold transition-all text-gray-500 hover:bg-gray-100 hover:text-red-700">
                    <i class="fa-solid fa-circle-info mr-1.5"></i> About
                </a>

                {{-- Komponen Identitas dan Tombol Logout (Sudah Dirapikan Sejajar) --}}
                <div class="flex items-center gap-4 ml-4 pl-4 border-l border-gray-200">
                    <div class="text-xs text-gray-600 font-medium">
                        Halo, <span class="text-red-600 font-bold">{{ Auth::user()->name }}</span> ✨
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="m-0 flex items-center">
                        @csrf
                        <button type="submit" class="px-3 py-1.5 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white text-xs font-bold rounded-lg shadow-sm transition duration-200 cursor-pointer">
                            <i class="fa-solid fa-right-from-bracket mr-1"></i> Log Out
                        </button>
                    </form>
                </div>
            </div>

            {{-- Hamburger Mobile --}}
            <button onclick="toggleMobileMenu()" class="md:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100">
                <i class="fa-solid fa-bars text-lg"></i>
            </button>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100 px-4 py-3 space-y-1 bg-white shadow-inner">
            <a href="#" onclick="showSection('dashboard'); toggleMobileMenu()" class="block px-4 py-2 rounded-lg text-sm font-semibold text-gray-600 hover:bg-red-50 hover:text-red-700"><i class="fa-solid fa-gauge-high mr-2"></i>Dashboard</a>
            <a href="#" onclick="showSection('single'); toggleMobileMenu()"    class="block px-4 py-2 rounded-lg text-sm font-semibold text-gray-600 hover:bg-red-50 hover:text-red-700"><i class="fa-solid fa-user mr-2"></i>Single Prediction</a>
            <a href="#" onclick="showSection('bulk'); toggleMobileMenu()"      class="block px-4 py-2 rounded-lg text-sm font-semibold text-gray-600 hover:bg-red-50 hover:text-red-700"><i class="fa-solid fa-file-excel mr-2"></i>Bulk Prediction</a>
            <a href="{{ route('churn.history') }}"                             class="block px-4 py-2 rounded-lg text-sm font-semibold text-gray-600 hover:bg-red-50 hover:text-red-700"><i class="fa-solid fa-clock-rotate-left mr-2"></i>Riwayat</a>
            <a href="#" onclick="showSection('about'); toggleMobileMenu()"     class="block px-4 py-2 rounded-lg text-sm font-semibold text-gray-600 hover:bg-red-50 hover:text-red-700"><i class="fa-solid fa-circle-info mr-2"></i>About</a>
            
            {{-- Logout Jalur Mobile Menu --}}
            <div class="pt-2 border-t border-gray-100 mt-2 px-4 flex items-center justify-between">
                <span class="text-xs font-bold text-gray-600">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="text-xs font-bold text-red-600 hover:text-red-800"><i class="fa-solid fa-right-from-bracket mr-1"></i>Log Out</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-4 py-8">

        {{-- ═══════════════ SECTION: DASHBOARD ═══════════════ --}}
        <div id="section-dashboard" class="section-content">
            <header class="text-center mb-8">
                <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-red-700 via-pink-500 to-red-900 tracking-wider">TACESSA</h1>
                <p class="text-gray-500 mt-2 text-sm font-medium">Customer Churn Prediction System — XGBoost Champion Model</p>
            </header>

            {{-- 4 Kartu Metrik --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-2xl p-5 text-center border border-orange-100 shadow-sm hover:shadow-md transition">
                    <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <i class="fa-solid fa-bullseye text-orange-500"></i>
                    </div>
                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Accuracy</p>
                    <p class="text-3xl font-extrabold text-red-700 mt-1">80.06%</p>
                    <p class="text-xs text-orange-400 mt-1 font-medium">XGBoost Champion</p>
                </div>
                <div class="bg-white rounded-2xl p-5 text-center border border-pink-100 shadow-sm hover:shadow-md transition">
                    <div class="w-10 h-10 bg-pink-50 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <i class="fa-solid fa-crosshairs text-pink-500"></i>
                    </div>
                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Precision</p>
                    <p class="text-3xl font-extrabold text-red-700 mt-1">78.84%</p>
                    <p class="text-xs text-pink-400 mt-1 font-medium">XGBoost Champion</p>
                </div>
                <div class="bg-white rounded-2xl p-5 text-center border border-red-100 shadow-sm hover:shadow-md transition">
                    <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <i class="fa-solid fa-magnifying-glass text-red-500"></i>
                    </div>
                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Recall</p>
                    <p class="text-3xl font-extrabold text-red-700 mt-1">80.06%</p>
                    <p class="text-xs text-red-400 mt-1 font-medium">XGBoost Champion</p>
                </div>
                <div class="bg-gradient-to-br from-red-700 to-pink-600 rounded-2xl p-5 text-center shadow-sm hover:shadow-md transition">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <i class="fa-solid fa-trophy text-yellow-300"></i>
                    </div>
                    <p class="text-xs text-white/70 font-semibold uppercase tracking-wider">F1-Score 🏆</p>
                    <p class="text-3xl font-extrabold text-white mt-1">78.74%</p>
                    <p class="text-xs text-white/60 mt-1 font-medium">Champion Metric</p>
                </div>
            </div>

            {{-- Chart + Progress Bar --}}
            <div class="bg-white rounded-3xl p-6 border border-gray-200 shadow-xl mb-6">
                <div class="border-b border-gray-100 pb-4 mb-6">
                    <h2 class="text-lg font-bold text-gray-800 flex items-center">
                        <span class="w-3 h-6 bg-gradient-to-b from-red-700 to-pink-500 rounded-full mr-3"></span>
                        Komparasi Performa Model
                    </h2>
                    <p class="text-xs text-gray-400 mt-1 ml-6">Evaluasi pada 1.409 data uji — IBM Telco Customer Churn Dataset (7.043 records)</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-5">
                        @foreach([['Accuracy','80.06','77.71'],['Precision','78.84','76.32'],['Recall','80.06','77.71'],['F1-Score','78.74','76.63']] as $m)
                        <div>
                            <div class="flex justify-between items-center mb-1.5">
                                <span class="text-xs font-bold text-gray-600 uppercase tracking-wider">{{ $m[0] }}</span>
                                <div class="flex gap-3">
                                    <span class="text-xs font-bold text-red-600">XGB: {{ $m[1] }}%</span>
                                    <span class="text-xs font-semibold text-blue-400">RF: {{ $m[2] }}%</span>
                                </div>
                            </div>
                            <div class="relative h-3.5 bg-gray-100 rounded-full overflow-hidden">
                                <div class="absolute h-3.5 bg-blue-200 rounded-full" style="width: {{ $m[2] }}%"></div>
                                <div class="absolute h-3.5 bg-gradient-to-r from-red-600 to-pink-500 rounded-full" style="width: {{ $m[1] }}%"></div>
                            </div>
                        </div>
                        @endforeach
                        <div class="flex gap-4 pt-1">
                            <div class="flex items-center gap-2"><div class="w-4 h-3 rounded-full bg-gradient-to-r from-red-600 to-pink-500"></div><span class="text-xs text-gray-500 font-semibold">XGBoost (Champion)</span></div>
                            <div class="flex items-center gap-2"><div class="w-4 h-3 rounded-full bg-blue-200"></div><span class="text-xs text-gray-500 font-semibold">Random Forest</span></div>
                        </div>
                    </div>
                    <div class="flex items-center justify-center">
                        <div class="w-64 h-64"><canvas id="radarChart"></canvas></div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <button onclick="showSection('single')" class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm hover:shadow-lg hover:border-red-200 transition-all text-left group cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-red-50 group-hover:bg-red-100 rounded-xl flex items-center justify-center transition">
                            <i class="fa-solid fa-user text-red-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800 group-hover:text-red-700 transition">Single Prediction</p>
                            <p class="text-xs text-gray-400 mt-0.5">Input satu pelanggan manual</p>
                        </div>
                        <i class="fa-solid fa-arrow-right ml-auto text-gray-300 group-hover:text-red-500 transition"></i>
                    </div>
                </button>
                <button onclick="showSection('bulk')" class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm hover:shadow-lg hover:border-pink-200 transition-all text-left group cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-pink-50 group-hover:bg-pink-100 rounded-xl flex items-center justify-center transition">
                            <i class="fa-solid fa-file-excel text-pink-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800 group-hover:text-pink-700 transition">Bulk Prediction</p>
                            <p class="text-xs text-gray-400 mt-0.5">Upload CSV/Excel massal</p>
                        </div>
                        <i class="fa-solid fa-arrow-right ml-auto text-gray-300 group-hover:text-pink-500 transition"></i>
                    </div>
                </button>
                <a href="{{ route('churn.history') }}" class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm hover:shadow-lg hover:border-purple-200 transition-all text-left group block">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-purple-50 group-hover:bg-purple-100 rounded-xl flex items-center justify-center transition">
                            <i class="fa-solid fa-clock-rotate-left text-purple-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800 group-hover:text-purple-700 transition">Riwayat Prediksi</p>
                            <p class="text-xs text-gray-400 mt-0.5">Lihat semua log prediksi</p>
                        </div>
                        <i class="fa-solid fa-arrow-right ml-auto text-gray-300 group-hover:text-purple-500 transition"></i>
                    </div>
                </a>
            </div>
        </div>

        {{-- ═══════════════ SECTION: SINGLE PREDICTION ═══════════════ --}}
        <div id="section-single" class="section-content hidden">
            <header class="mb-8">
                <h2 class="text-2xl font-extrabold text-gray-800">Single Prediction</h2>
                <p class="text-gray-400 text-sm mt-1">Input data satu pelanggan untuk mendapatkan hasil prediksi churn secara real-time</p>
            </header>

            @if(session('prediction'))
                <div class="mb-6 p-6 rounded-2xl border {{ session('prediction') == 'Potential Churn' ? 'border-red-300 bg-red-50' : 'border-green-300 bg-green-50' }} flex items-center justify-between shadow-sm">
                    <div>
                        <h3 class="text-sm font-bold text-gray-600">Hasil Analisis:</h3>
                        <p class="text-2xl font-black mt-1 {{ session('prediction') == 'Potential Churn' ? 'text-red-600' : 'text-green-600' }}">
                            <i class="fa-solid {{ session('prediction') == 'Potential Churn' ? 'fa-triangle-exclamation' : 'fa-circle-check' }} mr-2"></i>
                            {{ session('prediction') }}
                        </p>
                    </div>
                    <div class="text-right">
                        <h3 class="text-sm font-medium text-gray-500">Probabilitas Risiko Churn:</h3>
                        <p class="text-3xl font-extrabold text-red-700 mt-1">{{ session('probability') }}</p>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-3xl p-8 border border-gray-200 shadow-xl">
                <form action="{{ route('churn.predict') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Gender</label>
                            <select name="gender" class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-red-700 focus:ring-2 focus:ring-red-100 transition shadow-sm">
                                <option value="1">Male</option>
                                <option value="0">Female</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Age (Usia)</label>
                            <input type="number" name="age" value="30" required class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-red-700 focus:ring-2 focus:ring-red-100 transition shadow-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Status Pernikahan</label>
                            <select name="married" class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-red-700 focus:ring-2 focus:ring-red-100 transition shadow-sm">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tanggungan (Dependents)</label>
                            <select name="dependents" class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-red-700 focus:ring-2 focus:ring-red-100 transition shadow-sm">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tenure (Bulan Berlangganan)</label>
                            <input type="number" name="tenure" value="12" required class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-red-700 focus:ring-2 focus:ring-red-100 transition shadow-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Phone Service</label>
                            <select name="phone_service" class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-red-700 focus:ring-2 focus:ring-red-100 transition shadow-sm">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Internet Service</label>
                            <select name="internet_service" class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-red-700 focus:ring-2 focus:ring-red-100 transition shadow-sm">
                                <option value="1">Fiber Optic</option>
                                <option value="0">DSL</option>
                                <option value="2">No Internet Service</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Monthly Charge (Rp)</label>
                            <input type="number" step="1" name="monthly_charge" value="1057500" required class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-red-700 focus:ring-2 focus:ring-red-100 transition shadow-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Total Charges (Rp)</label>
                            <input type="number" step="1" name="total_charges" value="12690000" required class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-red-700 focus:ring-2 focus:ring-red-100 transition shadow-sm">
                        </div>
                    </div>
                    <div class="flex justify-end pt-2">
                        <button type="submit" class="px-8 py-3.5 bg-gradient-to-r from-red-700 to-red-950 text-white font-bold rounded-xl shadow-md hover:from-red-600 hover:to-red-800 transition-all uppercase tracking-wider text-sm cursor-pointer">
                            <i class="fa-solid fa-brain mr-2 text-pink-300"></i> Analyze Customer Churn
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ═══════════════ SECTION: BULK PREDICTION ═══════════════ --}}
        <div id="section-bulk" class="section-content hidden">
            <header class="mb-8">
                <h2 class="text-2xl font-extrabold text-gray-800">Bulk Prediction</h2>
                <p class="text-gray-400 text-sm mt-1">Upload file CSV atau Excel untuk prediksi banyak pelanggan sekaligus</p>
            </header>

            @if(session('bulk_results'))
                @php $bulk = session('bulk_results'); @endphp
                <div class="mb-6 p-6 rounded-2xl border border-blue-200 bg-blue-50 shadow-sm">
                    <h3 class="text-lg font-bold text-blue-800 mb-4"><i class="fa-solid fa-chart-bar mr-2"></i>Hasil Bulk Prediction</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div class="bg-white rounded-xl p-4 text-center shadow-sm"><p class="text-xs text-gray-500 font-semibold uppercase">Total</p><p class="text-3xl font-extrabold text-gray-800 mt-1">{{ $bulk['total'] }}</p></div>
                        <div class="bg-white rounded-xl p-4 text-center shadow-sm border border-red-100"><p class="text-xs text-red-500 font-semibold uppercase">Churn</p><p class="text-3xl font-extrabold text-red-600 mt-1">{{ $bulk['churn_count'] }}</p></div>
                        <div class="bg-white rounded-xl p-4 text-center shadow-sm border border-green-100"><p class="text-xs text-green-500 font-semibold uppercase">Non-Churn</p><p class="text-3xl font-extrabold text-green-600 mt-1">{{ $bulk['nonchurn_count'] }}</p></div>
                        <div class="bg-white rounded-xl p-4 text-center shadow-sm border border-orange-100"><p class="text-xs text-orange-500 font-semibold uppercase">Churn Rate</p><p class="text-3xl font-extrabold text-orange-600 mt-1">{{ $bulk['churn_rate'] }}</p></div>
                    </div>
                    <div class="overflow-x-auto rounded-xl border border-gray-200">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                                <tr>
                                    <th class="px-4 py-3">No</th>
                                    @if(isset($bulk['results'][0]['customer_id']))<th class="px-4 py-3">Customer ID</th>@endif
                                    <th class="px-4 py-3">Prediksi</th>
                                    <th class="px-4 py-3">Probabilitas</th>
                                    <th class="px-4 py-3">Risk Level</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($bulk['results'] as $r)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-gray-500">{{ $r['row'] }}</td>
                                    @if(isset($r['customer_id']))<td class="px-4 py-3 font-medium">{{ $r['customer_id'] }}</td>@endif
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 rounded-full text-xs font-bold {{ $r['prediction'] == 'Potential Churn' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                            <i class="fa-solid {{ $r['prediction'] == 'Potential Churn' ? 'fa-triangle-exclamation' : 'fa-circle-check' }} mr-1"></i>{{ $r['prediction'] }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 font-semibold {{ $r['prediction'] == 'Potential Churn' ? 'text-red-600' : 'text-green-600' }}">{{ $r['probability'] }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 rounded-full text-xs font-bold {{ $r['risk_level'] == 'High' ? 'bg-red-100 text-red-700' : ($r['risk_level'] == 'Medium' ? 'bg-orange-100 text-orange-700' : 'bg-green-100 text-green-700') }}">{{ $r['risk_level'] }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-300 text-red-700 rounded-xl flex items-center">
                    <i class="fa-solid fa-circle-xmark mr-3 text-red-500"></i>{{ session('error') }}
                </div>
            @endif

            <div class="bg-white rounded-3xl p-8 border border-gray-200 shadow-xl">
                <form action="{{ route('churn.bulk') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div id="drop-zone"
                        class="border-2 border-dashed border-gray-300 hover:border-red-700 rounded-2xl p-12 text-center bg-gray-50 cursor-pointer transition-all group flex flex-col items-center"
                        onclick="document.getElementById('file-input').click()"
                        ondragover="event.preventDefault(); this.classList.add('border-red-700')"
                        ondragleave="this.classList.remove('border-red-700')"
                        ondrop="handleDrop(event)">
                        <div class="w-16 h-16 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-400 group-hover:text-red-700 shadow-sm mb-4 transition">
                            <i class="fa-solid fa-cloud-arrow-up text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-700 group-hover:text-red-900">Drag & drop file di sini</h3>
                        <p class="text-gray-400 text-xs mt-1">Format: .csv atau .xlsx</p>
                        <p id="file-name" class="mt-3 text-sm font-semibold text-red-700 hidden"></p>
                        <span class="mt-5 px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg text-xs font-semibold group-hover:bg-red-700 group-hover:text-white transition shadow-sm">Pilih File Manual</span>
                    </div>
                    <input type="file" id="file-input" name="file" accept=".csv,.xlsx,.xls" class="hidden" onchange="showFileName(this)">
                    <div class="mt-4 p-4 bg-pink-50 border border-pink-100 rounded-xl text-xs text-gray-600">
                        <strong>Format header:</strong>
                        <code class="bg-white px-2 py-0.5 rounded text-red-700 ml-1">gender, age, married, dependents, tenure, phone_service, internet_service, monthly_charge, total_charges</code>
                    </div>
                    <div class="flex justify-end mt-5">
                        <button type="submit" id="upload-btn" disabled class="px-8 py-3.5 bg-gradient-to-r from-pink-600 to-red-700 text-white font-bold rounded-xl shadow-md uppercase tracking-wider text-sm disabled:opacity-40 disabled:cursor-not-allowed transition">
                            <i class="fa-solid fa-upload mr-2"></i> Upload & Prediksi
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ═══════════════ SECTION: ABOUT ═══════════════ --}}
        <div id="section-about" class="section-content hidden">
            <header class="mb-8">
                <h2 class="text-2xl font-extrabold text-gray-800">Tentang Sistem</h2>
                <p class="text-gray-400 text-sm mt-1">Informasi mengenai penelitian dan sistem prediksi customer churn ini</p>
            </header>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-3xl p-6 border border-gray-200 shadow-xl">
                    <h3 class="font-bold text-gray-800 text-lg mb-4 flex items-center gap-2">
                        <div class="w-8 h-8 bg-red-50 rounded-lg flex items-center justify-center"><i class="fa-solid fa-book text-red-600 text-sm"></i></div>
                        Informasi Penelitian
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex gap-3"><span class="text-gray-400 w-32 shrink-0">Judul</span><span class="font-medium text-gray-700">Analisis Komparasi Algoritma Random Forest dan XGBoost untuk Klasifikasi Customer Churn pada Layanan Seluler Prabayar Berbasis Website</span></div>
                        <div class="flex gap-3"><span class="text-gray-400 w-32 shrink-0">Penulis</span><span class="font-medium text-gray-700">Lady Cessa Nadinda</span></div>
                        <div class="flex gap-3"><span class="text-gray-400 w-32 shrink-0">NIM</span><span class="font-medium text-gray-700">434221056</span></div>
                        <div class="flex gap-3"><span class="text-gray-400 w-32 shrink-0">Program Studi</span><span class="font-medium text-gray-700">D-IV Teknik Informatika</span></div>
                        <div class="flex gap-3"><span class="text-gray-400 w-32 shrink-0">Fakultas</span><span class="font-medium text-gray-700">Vokasi — Universitas Airlangga</span></div>
                        <div class="flex gap-3"><span class="text-gray-400 w-32 shrink-0">Tahun</span><span class="font-medium text-gray-700">2026</span></div>
                        <div class="flex gap-3"><span class="text-gray-400 w-32 shrink-0">Pembimbing</span><span class="font-medium text-gray-700">Rachman Sinatriya Marjianto, B.Eng., M.Sc.</span></div>
                    </div>
                </div>
                <div class="bg-white rounded-3xl p-6 border border-gray-200 shadow-xl">
                    <h3 class="font-bold text-gray-800 text-lg mb-4 flex items-center gap-2">
                        <div class="w-8 h-8 bg-orange-50 rounded-lg flex items-center justify-center"><i class="fa-solid fa-table text-orange-600 text-sm"></i></div>
                        Dataset & Split
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex gap-3"><span class="text-gray-400 w-32 shrink-0">Sumber</span><span class="font-medium text-gray-700">IBM Telco Customer Churn</span></div>
                        <div class="flex gap-3"><span class="text-gray-400 w-32 shrink-0">Total Data</span><span class="font-medium text-gray-700">7.043 baris</span></div>
                        <div class="flex gap-3"><span class="text-gray-400 w-32 shrink-0">Atribut Awal</span><span class="font-medium text-gray-700">50 atribut</span></div>
                        <div class="flex gap-3"><span class="text-gray-400 w-32 shrink-0">Fitur Model</span><span class="font-medium text-gray-700">9 prediktor + 1 target</span></div>
                        <div class="flex gap-3"><span class="text-gray-400 w-32 shrink-0">Split Data</span><span class="font-medium text-gray-700">80% Train / 20% Test</span></div>
                        <div class="flex gap-3"><span class="text-gray-400 w-32 shrink-0">Non-Churn</span><span class="font-medium text-gray-700">5.174 (73,5%)</span></div>
                        <div class="flex gap-3"><span class="text-gray-400 w-32 shrink-0">Churn</span><span class="font-medium text-gray-700">1.869 (26,5%)</span></div>
                    </div>
                </div>
                <div class="bg-white rounded-3xl p-6 border border-gray-200 shadow-xl">
                    <h3 class="font-bold text-gray-800 text-lg mb-4 flex items-center gap-2">
                        <div class="w-8 h-8 bg-yellow-50 rounded-lg flex items-center justify-center"><i class="fa-solid fa-trophy text-yellow-500 text-sm"></i></div>
                        Hasil Komparasi Model
                    </h3>
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="text-left py-2 text-gray-400 font-semibold text-xs uppercase">Metrik</th>
                                <th class="text-center py-2 text-orange-500 font-bold text-xs uppercase">XGBoost 🏆</th>
                                <th class="text-center py-2 text-blue-400 font-semibold text-xs uppercase">Random Forest</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach([['Accuracy','80.06%','77.71%'],['Precision','78.84%','76.32%'],['Recall','80.06%','77.71%'],['F1-Score','78.74%','76.63%']] as $row)
                            <tr>
                                <td class="py-2.5 font-medium text-gray-700">{{ $row[0] }}</td>
                                <td class="py-2.5 text-center font-bold text-red-700">{{ $row[1] }}</td>
                                <td class="py-2.5 text-center text-blue-500">{{ $row[2] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4 p-3 bg-gradient-to-r from-red-50 to-pink-50 rounded-xl border border-red-100 text-xs text-red-700 font-medium">
                        <i class="fa-solid fa-trophy text-yellow-500 mr-2"></i>
                        XGBoost ditetapkan sebagai Champion Model berdasarkan F1-Score tertinggi (78.74%).
                    </div>
                </div>
                <div class="bg-white rounded-3xl p-6 border border-gray-200 shadow-xl">
                    <h3 class="font-bold text-gray-800 text-lg mb-4 flex items-center gap-2">
                        <div class="w-8 h-8 bg-pink-50 rounded-lg flex items-center justify-center"><i class="fa-solid fa-microchip text-pink-600 text-sm"></i></div>
                        Teknologi yang Digunakan
                    </h3>
                    <div class="space-y-3">
                        @foreach([
                            ['fa-solid fa-code','Python 3.9+','Machine Learning & API Backend','bg-blue-50 text-blue-600'],
                            ['fa-solid fa-flask-vial','Flask','REST API Framework (Backend)','bg-green-50 text-green-600'],
                            ['fa-solid fa-globe','Laravel','PHP Web Framework (Frontend)','bg-red-50 text-red-600'],
                            ['fa-solid fa-database','MySQL','Database Management System','bg-orange-50 text-orange-600'],
                            ['fa-solid fa-brain','XGBoost','Champion Model — Gradient Boosting','bg-purple-50 text-purple-600'],
                            ['fa-solid fa-tree','Random Forest','Comparison Model — Bagging Ensemble','bg-teal-50 text-teal-600'],
                        ] as $tech)
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 {{ $tech[3] }} rounded-lg flex items-center justify-center shrink-0">
                                <i class="{{ $tech[0] }} text-sm"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">{{ $tech[1] }}</p>
                                <p class="text-xs text-gray-400">{{ $tech[2] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        function showSection(name) {
            document.querySelectorAll('.section-content').forEach(s => s.classList.add('hidden'));
            document.getElementById('section-' + name).classList.remove('hidden');
            document.querySelectorAll('.nav-link').forEach(l => {
                l.classList.remove('bg-red-50','text-red-700');
                l.classList.add('text-gray-500','hover:bg-gray-100','hover:text-red-700');
            });
            const active = document.getElementById('nav-' + name);
            if (active) {
                active.classList.remove('text-gray-500','hover:bg-gray-100','hover:text-red-700');
                active.classList.add('bg-red-50','text-red-700');
            }
            document.getElementById('mobile-menu').classList.add('hidden');
        }

        function toggleMobileMenu() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        }

        function showFileName(input) {
            if (input.files && input.files[0]) {
                document.getElementById('file-name').textContent = '✅ ' + input.files[0].name;
                document.getElementById('file-name').classList.remove('hidden');
                document.getElementById('upload-btn').disabled = false;
            }
        }

        function handleDrop(e) {
            e.preventDefault();
            const fi = document.getElementById('file-input');
            fi.files = e.dataTransfer.files;
            showFileName(fi);
        }

        @if(session('prediction')) showSection('single'); @endif
        @if(session('bulk_results')) showSection('bulk'); @endif
        @if(session('error')) showSection('bulk'); @endif

        new Chart(document.getElementById('radarChart').getContext('2d'), {
            type: 'radar',
            data: {
                labels: ['Accuracy','Precision','Recall','F1-Score'],
                datasets: [
                    { label: 'XGBoost', data: [80.06,78.84,80.06,78.74], backgroundColor: 'rgba(239,68,68,0.15)', borderColor: 'rgba(239,68,68,0.9)', borderWidth: 2, pointBackgroundColor: 'rgba(239,68,68,1)', pointRadius: 4 },
                    { label: 'Random Forest', data: [77.71,76.32,77.71,76.63], backgroundColor: 'rgba(96,165,250,0.15)', borderColor: 'rgba(96,165,250,0.8)', borderWidth: 2, pointBackgroundColor: 'rgba(96,165,250,1)', pointRadius: 4 }
                ]
            },
            options: {
                responsive: true,
                scales: { r: { min: 70, max: 85, ticks: { stepSize: 5, font: { size: 9 } }, pointLabels: { font: { size: 10, weight: 'bold' } }, grid: { color: 'rgba(0,0,0,0.06)' } } },
                plugins: { legend: { position: 'bottom', labels: { font: { size: 10 }, boxWidth: 12 } } }
            }
        });
    </script>
</body>
</html>