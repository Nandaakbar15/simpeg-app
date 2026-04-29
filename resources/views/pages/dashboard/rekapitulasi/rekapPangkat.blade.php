<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">
                Rekapitulasi Data Pangkat
            </h1>
        </div>

        <div class="grid grid-cols-12 gap-6">

            <div
                class="col-span-full xl:col-span-5 bg-white dark:bg-gray-800 shadow-lg rounded-sm border border-gray-200 dark:border-gray-700">
                <header class="px-5 py-4 border-b border-gray-100 dark:border-gray-700">
                    <h2 class="font-semibold text-gray-800 dark:text-gray-100">Daftar Pangkat</h2>
                </header>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead
                            class="text-xs font-semibold uppercase text-gray-500 bg-gray-50 dark:bg-gray-700 dark:bg-opacity-50">
                            <tr>
                                <th class="px-4 py-3 text-left">No</th>
                                <th class="px-4 py-3 text-left">Pangkat</th>
                                <th class="px-4 py-3 text-center">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach ($pangkat as $index => $data)
                                <tr>
                                    <td class="px-4 py-3">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-800 dark:text-gray-100">
                                        {{ $data->nama_pangkat }}</td>
                                    <td class="px-4 py-3 text-center">{{ $data->pegawai_count }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50 dark:bg-gray-700">
                            <tr class="font-bold text-gray-800 dark:text-gray-100">
                                <td colspan="2" class="px-4 py-3 text-right">TOTAL</td>
                                <td class="px-4 py-3 text-center">{{ $pangkat->sum('pegawai_count') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div
                class="col-span-full xl:col-span-7 bg-white dark:bg-gray-800 shadow-lg rounded-sm border border-gray-200 dark:border-gray-700">
                <header class="px-5 py-4 border-b border-gray-100 dark:border-gray-700">
                    <h2 class="font-semibold text-gray-800 dark:text-gray-100">Statistik Pangkat</h2>
                </header>
                <div class="p-3">
                    <canvas id="pangkatChart" height="300"></canvas>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const canvasElement = document.getElementById('pangkatChart');

                // Debugging: Cek apakah element & data ada di console browser (F12)
                const labels = @json($chartCategories);
                const dataValues = @json($chartData);
                console.log("Labels:", labels);
                console.log("Data:", dataValues);

                if (canvasElement) {
                    const ctx = canvasElement.getContext('2d');

                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Jumlah Pegawai',
                                data: dataValues,
                                backgroundColor: [
                                    'rgba(54, 162, 235, 0.6)',
                                    'rgba(255, 99, 132, 0.6)',
                                    'rgba(75, 192, 192, 0.6)',
                                    'rgba(255, 206, 86, 0.6)',
                                    'rgba(153, 102, 255, 0.6)'
                                ],
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1,
                                        color: '#6B7280' // Warna abu-abu Tailwind
                                    },
                                    grid: {
                                        display: true,
                                        drawBorder: false
                                    }
                                },
                                x: {
                                    ticks: {
                                        color: '#6B7280'
                                    },
                                    grid: {
                                        display: false
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                }
                            }
                        }
                    });
                } else {
                    console.error("Element canvas 'unitKerjaChart' tidak ditemukan!");
                }
            });
        </script>
    @endpush
</x-app-layout>
