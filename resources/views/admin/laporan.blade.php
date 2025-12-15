<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan PPDB - SD Negeri Larangan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .report-card {
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .report-card:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .table-row:hover {
            background-color: #f8fafc;
        }

        .status-waiting {
            background-color: #fef3c7;
            color: #b45309;
        }

        .status-accepted {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-rejected {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .btn-action {
            transition: all 0.2s ease;
        }

        .btn-action:hover {
            transform: translateY(-1px);
        }

        .chart-container {
            position: relative;
            height: 300px;
        }

        .stats-card {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        }

        .stats-card-green {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        }

        .stats-card-orange {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        .tips-box {
            background: #eef2ff;
            border-left: 4px solid #6366f1;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    @include('layouts.admin.header')

    <div class="flex pt-[80px]">

        @include('layouts.admin.sidebar')

        <main class="flex-1 ml-64 p-6">
            <div class="grid lg:grid-cols-4 gap-8">
                <!-- Content -->
                <div class="lg:col-span-3 space-y-8">
                    <!-- Statistik -->
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="stats-card text-white rounded-2xl p-6">
                            <p class="text-blue-100 text-sm">Total Pendaftar</p>
                            <p class="text-3xl font-bold mt-2">{{ $totalPendaftar }}</p>
                            <p class="text-blue-100 text-xs">
                                {{ $perubahanMinggu >= 0 ? '+' : '' }}{{ $perubahanMinggu }} dari minggu lalu</p>
                        </div>
                        <div class="stats-card-green text-white rounded-2xl p-6">
                            <p class="text-green-100 text-sm">Diterima</p>
                            <p class="text-3xl font-bold mt-2">{{ $diterima }}</p>
                            <p class="text-green-100 text-xs">
                                {{ $totalPendaftar > 0 ? round(($diterima / $totalPendaftar) * 100) : 0 }}% dari total
                            </p>
                        </div>
                        <div class="stats-card-orange text-white rounded-2xl p-6">
                            <p class="text-yellow-100 text-sm">Menunggu</p>
                            <p class="text-3xl font-bold mt-2">{{ $menunggu }}</p>
                            <p class="text-yellow-100 text-xs">
                                {{ $totalPendaftar > 0 ? round(($menunggu / $totalPendaftar) * 100) : 0 }}% dari total
                            </p>
                        </div>
                    </div>

                    <!-- Filter -->
                    <form action="{{ route('admin.reports') }}" method="GET" class="grid md:grid-cols-6 gap-4">

                        <!-- Periode -->
                        <select name="periode"
                            class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Data</option>
                            <option value="Harian" {{ request('periode') == 'Harian' ? 'selected' : '' }}>Harian
                            </option>
                            <option value="Mingguan" {{ request('periode') == 'Mingguan' ? 'selected' : '' }}>Mingguan
                            </option>
                            <option value="Bulanan" {{ request('periode') == 'Bulanan' ? 'selected' : '' }}>Bulanan
                            </option>
                        </select>

                        <!-- Status -->
                        <select name="status"
                            class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Status</option>
                            <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu
                            </option>
                            <option value="Diterima" {{ request('status') == 'Diterima' ? 'selected' : '' }}>Diterima
                            </option>
                            <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak
                            </option>
                        </select>

                        <!-- Start Date -->
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                            class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">

                        <!-- End Date -->
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                            class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">

                        <!-- Tampilkan -->
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium">
                            Tampilkan
                        </button>

                        <!-- RESET -->
                        <a href="{{ route('admin.reports') }}"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-3 rounded-lg font-medium text-center">
                            Reset
                        </a>

                    </form>


                    <!-- Tabel -->
                    <div class="report-card bg-white rounded-2xl border border-blue-100 overflow-hidden">
                        <div class="p-6 border-b flex justify-between items-center">
                            <h3 class="font-semibold text-gray-800">Data Laporan Pendaftar</h3>
                            <div class="flex space-x-3">
                                <a href="{{ route('admin.reports.pdf') }}?{{ http_build_query(request()->all()) }}"
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium">Unduh
                                    PDF</a>
                                <a href="{{ route('admin.reports.excel') }}?{{ http_build_query(request()->all()) }}"
                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">Unduh
                                    Excel</a>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left">No</th>
                                        <th class="px-6 py-3 text-left">Nama Lengkap</th>
                                        <th class="px-6 py-3 text-left">NIK</th>
                                        <th class="px-6 py-3 text-left">Asal TK</th>
                                        <th class="px-6 py-3 text-left">Status</th>
                                        <th class="px-6 py-3 text-left">Tanggal Daftar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($registrations as $index => $registration)
                                        <tr class="table-row border-b">
                                            <td class="px-6 py-3">{{ $index + 1 }}</td>
                                            <td class="px-6 py-3">{{ $registration->nama }}</td>
                                            <td class="px-6 py-3">{{ $registration->nik }}</td>
                                            <td class="px-6 py-3">{{ $registration->nama_tk ?? '-' }}</td>
                                            <td class="px-6 py-3">
                                                @if ($registration->status == 'diterima')
                                                    <span class="status-diterima">Diterima</span>
                                                @elseif($registration->status == 'tidak diterima')
                                                    <span class="status-ditolak">Ditolak</span>
                                                @else
                                                    <span class="status-menunggu">Menunggu</span>
                                                @endif

                                            </td>
                                            <td class="px-6 py-3">{{ $registration->created_at->format('d M Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                                Tidak ada data pendaftar yang sesuai dengan filter
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="report-card bg-white rounded-2xl p-6">
                        <h3 class="font-semibold text-gray-800 mb-4">Statistik Status</h3>
                        <canvas id="statusChart"></canvas>
                    </div>
                    <div class="report-card bg-white rounded-2xl p-6">
                        <h3 class="font-semibold text-gray-800 mb-4">Pendaftar per Bulan</h3>
                        <canvas id="monthlyChart"></canvas>
                    </div>
                    <div class="tips-box rounded-xl p-4">
                        <h4 class="font-semibold text-purple-800 mb-3">Tips Laporan:</h4>
                        <ul class="space-y-2 text-sm text-purple-700">
                            <li>✓ Gunakan filter untuk data spesifik</li>
                            <li>✓ Export ke Excel untuk analisis lanjut</li>
                            <li>✓ Cetak laporan untuk arsip</li>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Status Chart
        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: ['Diterima', 'Menunggu', 'Ditolak'],
                datasets: [{
                    data: [{{ $diterima }}, {{ $menunggu }}, {{ $ditolak }}],
                    backgroundColor: ['#22c55e', '#f59e0b', '#ef4444']
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                }
            }
        });

        // Monthly Chart
        new Chart(document.getElementById('monthlyChart'), {
            type: 'bar',
            data: {
                labels: ['Okt', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar'],
                datasets: [{
                    data: {!! json_encode(array_values($chartData)) !!},
                    backgroundColor: '#3b82f6'
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>
