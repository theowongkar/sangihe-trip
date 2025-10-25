<x-app-layout>

    {{-- Judul Halaman --}}
    <x-slot name="title">Dashboard</x-slot>

    {{-- Bagian Statistik User --}}
    <section>
        <h1 class="inline-block px-3 py-1 bg-[#115e6d] text-white font-semibold mb-5">Statistik
            Pengguna</h1>

        {{-- Card Statistik --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
            <x-cards.stats-card title="Total Pengguna" :value="$totalActiveUsers" description="Total pengguna aktif"
                color="bg-yellow-600" :icon="view('components.icons.people-fill')->render()" />
            <x-cards.stats-card title="Total Admin" :value="$totalActiveAdmins" description="Total admin aktif" color="bg-red-600"
                :icon="view('components.icons.person-fill-gear')->render()" />
            <x-cards.stats-card title="Total Pengunjung" :value="$totalActiveVisitors" description="Total pengunjung aktif"
                color="bg-blue-600" :icon="view('components.icons.person-fill-check')->render()" />
        </div>

        {{-- Chart Statistik --}}
        <div class="flex flex-col mt-5 p-5 bg-white rounded-lg shadow overflow-hidden">
            <h2 class="font-semibold mb-3">Perkembangan Pengguna Aktif & Tidak Aktif ({{ date('Y') }})</h2>
            <canvas id="userStatusChart" class="max-h-56"></canvas>
        </div>
    </section>

    {{-- Bagian Statistik Produk --}}
    <section class="mt-8">
        <h1 class="inline-block px-3 py-1 bg-[#115e6d] text-white font-semibold mb-5">Statistik Produk</h1>

        {{-- Card Statistik Produk --}}
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-3">
            <x-cards.stats-card title="Total Produk" :value="$totalProducts" description="Semua produk" color="bg-indigo-600"
                :icon="view('components.icons.bag-check-fill')->render()" />
            <x-cards.stats-card title="Draf" :value="$draftProducts" description="Produk dalam draf" color="bg-yellow-600"
                :icon="view('components.icons.bag-check-fill')->render()" />
            <x-cards.stats-card title="Terbit" :value="$publishedProducts" description="Produk yang dipublikasikan"
                color="bg-green-600" :icon="view('components.icons.bag-check-fill')->render()" />
            <x-cards.stats-card title="Arsip" :value="$archivedProducts" description="Produk terarsipkan" color="bg-gray-600"
                :icon="view('components.icons.bag-check-fill')->render()" />
        </div>

        {{-- Chart Statistik Produk --}}
        <div class="flex flex-col mt-5 p-5 bg-white rounded-lg shadow overflow-hidden">
            <h2 class="font-semibold mb-3">Perkembangan Produk per Status ({{ date('Y') }})</h2>
            <canvas id="productStatusChart" class="max-h-56"></canvas>
        </div>
    </section>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const months = @json($months);
        const activeUsers = @json($activeUsersByMonth);
        const inactiveUsers = @json($inactiveUsersByMonth);

        new Chart(document.getElementById('userStatusChart'), {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                        label: 'Aktif',
                        data: activeUsers,
                        borderColor: '#2e7d32',
                        backgroundColor: 'rgba(46, 125, 50, 0.2)',
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Tidak Aktif',
                        data: inactiveUsers,
                        borderColor: '#c62828',
                        backgroundColor: 'rgba(198, 40, 40, 0.2)',
                        tension: 0.3,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script>
        // Product status chart
        const productMonths = @json($productMonths ?? $months);
        const publishedProducts = @json($publishedByMonth ?? []);
        const draftProducts = @json($draftByMonth ?? []);
        const archivedProducts = @json($archivedByMonth ?? []);

        new Chart(document.getElementById('productStatusChart'), {
            type: 'line',
            data: {
                labels: productMonths,
                datasets: [{
                        label: 'Terbit',
                        data: publishedProducts,
                        borderColor: '#2e7d32',
                        backgroundColor: 'rgba(46, 125, 50, 0.2)',
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Draf',
                        data: draftProducts,
                        borderColor: '#f59e0b',
                        backgroundColor: 'rgba(245, 158, 11, 0.15)',
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Arsip',
                        data: archivedProducts,
                        borderColor: '#374151',
                        backgroundColor: 'rgba(55, 65, 81, 0.12)',
                        tension: 0.3,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</x-app-layout>
