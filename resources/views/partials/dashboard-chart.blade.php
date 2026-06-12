<div class="card shadow border-0 mt-4">

    <div class="card-header bg-primary text-white">
        Grafik Dashboard
    </div>

    <div class="card-body">

        <canvas id="stockChart" height="100"></canvas>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const ctx = document.getElementById('stockChart');

    if (!ctx) return;

    new Chart(ctx, {

        type: 'bar',

        data: {

            labels: [
                'Total Barang',
                'Total Stok',
                'Stok Minimum',
                'Transaksi Hari Ini'
            ],

            datasets: [{

                label: 'Dashboard Stok',

                data: [
                    {{ $totalBarang }},
                    {{ $totalStok }},
                    {{ $stokMinimumCount }},
                    {{ $stokMasukHariIni + $stokKeluarHariIni }}
                ],

                borderWidth: 1

            }]

        },

        options: {

            responsive: true,

            plugins: {

                legend: {
                    display: true
                }

            },

            scales: {

                y: {
                    beginAtZero: true
                }

            }

        }

    });

});

</script>