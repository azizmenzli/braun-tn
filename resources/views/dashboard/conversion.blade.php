<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Braun - Taux de Conversion</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/logo/favicon.png') }}" type="image/x-icon">
    @include('dashboard.components.style')
</head>

<body>
    <div class="tp-main-wrapper bg-slate-100 min-h-screen" x-data="{ sideMenu: false }">
        @include('dashboard.components.sideleft')
        <div class="fixed top-0 left-0 w-full h-full z-40 bg-black/70 transition-all duration-300"
             :class="sideMenu ? 'visible opacity-1' : 'invisible opacity-0'"
             x-on:click="sideMenu = !sideMenu"></div>
        <div class="tp-main-content lg:ml-[250px] xl:ml-[300px] w-full xl:w-[calc(100%-300px)]" x-data="{ searchOverlay: false }">
            @include('dashboard.components.header')
            <div class="body-content px-4 py-8 bg-slate-100">
                {{-- Filtres --}}
                <form method="GET" class="mb-8 flex flex-wrap gap-4 items-end bg-white rounded-lg shadow p-4">
                    <div class="flex flex-col">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Jour</label>
                        <input type="date" name="day" value="{{ request('day') }}" class="border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200 focus:border-blue-400 text-sm">
                    </div>
                    <div class="flex flex-col">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Mois</label>
                        <select name="month" class="border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200 focus:border-blue-400 text-sm">
                            <option value="">Mois</option>
                            @for($m=1;$m<=12;$m++)
                                <option value="{{ $m }}" @if(request('month') == $m) selected @endif>
                                    {{ ucfirst(\Carbon\Carbon::create()->month($m)->locale('fr_FR')->isoFormat('MMMM')) }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="flex flex-col">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Année</label>
                        <select name="year" class="border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200 focus:border-blue-400 text-sm">
                            <option value="">Année</option>
                            @for($y = now()->year; $y >= now()->year - 5; $y--)
                                <option value="{{ $y }}" @if(request('year') == $y) selected @endif>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="flex flex-col">
                        <button type="submit" class="mt-5 px-4 py-2 text-xs font-semibold text-white bg-blue-600 rounded hover:bg-blue-700 transition">
                            Filtrer
                        </button>
                    </div>
                    @if(request()->has('day') || request()->has('month') || request()->has('year'))
                        <div class="flex flex-col">
                            <a href="{{ route('dashboard.conversion') }}" class="mt-5 px-4 py-2 text-xs font-semibold text-blue-600 border border-blue-600 rounded hover:bg-blue-600 hover:text-white transition text-center">
                                Réinitialiser
                            </a>
                        </div>
                    @endif
                </form>
                {{-- Fin filtres --}}
                <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold mb-2">Taux de Conversion</h1>
                        <p class="text-gray-500">Suivi des performances de conversion sur les 30 derniers jours.</p>
                    </div>
                    <button class="text-white bg-[#1da1f2] hover:bg-[#1da1f2]/90 focus:ring-4 focus:outline-none focus:ring-[#1da1f2]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#1da1f2]/55 me-2 mb-2" onclick="exportTableToCSV('conversion.csv')" class="bg-primary text-white px-4 py-2 rounded shadow hover:bg-primary-dark transition">
                        Exporter CSV
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
                    <div class="rounded shadow p-4 flex flex-col items-center bg-white">
                        <span class="text-gray-500 text-sm mb-1">Taux de Conversion Global</span>
                        <span class="text-2xl font-bold text-blue-700">{{ number_format($globalConversionRate, 2) }}%</span>
                    </div>
                    <div class="rounded shadow p-4 flex flex-col items-center bg-white">
                        <span class="text-gray-500 text-sm mb-1">Total Commandes</span>
                        <span class="text-2xl font-bold text-green-700">{{ $totalOrders }}</span>
                    </div>
                    <div class="rounded shadow p-4 flex flex-col items-center bg-white">
                        <span class="text-gray-500 text-sm mb-1">Total Visiteurs</span>
                        <span class="text-2xl font-bold text-cyan-700">{{ $totalVisitors }}</span>
                    </div>
                    <div class="rounded shadow p-4 flex flex-col items-center bg-white">
                        <span class="text-gray-500 text-sm mb-1">Valeur Moyenne Commande</span>
                        <span class="text-2xl font-bold text-yellow-700">{{ number_format($averageOrderValue, 3) }} DT</span>
                    </div>
                </div>
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-8">
                    <div class="xl:col-span-2 bg-white rounded-lg shadow p-6">
                        <h2 class="text-lg font-semibold mb-4 flex items-center">
                            <i class="fas fa-chart-line mr-2"></i> Taux de Conversion sur 30 jours
                        </h2>
                        <canvas id="conversionChart" height="80"></canvas>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-lg font-semibold mb-4 flex items-center">
                            <i class="fas fa-chart-pie mr-2"></i> Conversion par Source
                        </h2>
                        <canvas id="sourceChart" height="80"></canvas>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="fas fa-table mr-2"></i> Détails des Conversions
                    </h2>
                    <div class="overflow-x-auto">
                        <table id="conversionTable" class="min-w-full table-auto border border-gray-200 rounded">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-700">Date</th>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-700">Visiteurs</th>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-700">Commandes</th>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-700">Taux de Conversion</th>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-700">Valeur Moyenne</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dailyStats as $stat)
                                <tr class="border-t hover:bg-gray-100">
                                    <td class="px-4 py-2">
                                        {{ $stat->date }}
                                    </td>
                                    <td class="px-4 py-2">{{ $stat->visitors }}</td>
                                    <td class="px-4 py-2">{{ $stat->orders }}</td>
                                    <td class="px-4 py-2">{{ number_format($stat->conversion_rate, 2) }}%</td>
                                    <td class="px-4 py-2">{{ number_format($stat->average_value, 3) }} DT</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- Pagination --}}
                        <div class="mt-4">
                            @if(method_exists($dailyStats, 'links'))
                                {{ $dailyStats->links('pagination::tailwind') }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('dashboard.components.js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    // Graphique de conversion sur 30 jours
    const conversionCtx = document.getElementById('conversionChart').getContext('2d');
    new Chart(conversionCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartData['labels']) !!},
            datasets: [{
                label: 'Taux de Conversion (%)',
                data: {!! json_encode($chartData['conversionRates']) !!},
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.1)',
                tension: 0.1,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Taux de Conversion (%)'
                    }
                }
            }
        }
    });

    // Graphique des sources
    const sourceCtx = document.getElementById('sourceChart').getContext('2d');
    new Chart(sourceCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($chartData['sources']) !!},
            datasets: [{
                data: {!! json_encode($chartData['sourceValues']) !!},
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Export CSV
    function exportTableToCSV(filename) {
        const rows = document.querySelectorAll("#conversionTable tr");
        let csv = [];
        rows.forEach(row => {
            let cols = Array.from(row.querySelectorAll("td, th"))
                            .map(col => `"${col.innerText.replace(/"/g, '""')}"`);
            csv.push(cols.join(","));
        });
        const blob = new Blob([csv.join("\n")], { type: "text/csv;charset=utf-8;" });
        const link = document.createElement("a");
        if (navigator.msSaveBlob) {
            navigator.msSaveBlob(blob, filename);
        } else {
            link.href = URL.createObjectURL(blob);
            link.setAttribute("download", filename);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }
    </script>
</body>
</html>




