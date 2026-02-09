var ctxRencana = document.getElementById("chart-revegetasi-rencana");
if (ctxRencana) {
    var ctx = ctxRencana.getContext("2d");
    
    // ✅ Gradient untuk Realisasi Aktual (Hijau/Teal)
    var gradientRealisasi = ctx.createLinearGradient(0, 0, 0, 250);
    gradientRealisasi.addColorStop(0, 'rgba(0, 200, 150, 0.7)'); // Hijau pekat di atas
    gradientRealisasi.addColorStop(1, 'rgba(0, 200, 150, 0)');   // Transparan di bawah

    // ✅ Gradient untuk Target Rencana (Biru/Abu-abu)
    var gradientTarget = ctx.createLinearGradient(0, 0, 0, 250);
    gradientTarget.addColorStop(0, 'rgba(108, 117, 125, 0.6)'); // Abu-abu pekat di atas
    gradientTarget.addColorStop(1, 'rgba(108, 117, 125, 0)');   // Transparan di bawah

    new Chart(ctx, {
        type: "line",
        data: {
            labels: {!! json_encode($monthsFull) !!},
            datasets: [
                {
                    label: "Realisasi Aktual",
                    data: {!! json_encode($dataChartRealisasi) !!},
                    borderColor: "#00C896", // Hijau teal
                    backgroundColor: gradientRealisasi,
                    borderWidth: 3,
                    pointRadius: 5,
                    pointBackgroundColor: "#ffffff",
                    pointBorderWidth: 2,
                    pointHoverRadius: 7,
                    fill: true,
                    tension: 0.4,
                    order: 1 // Menampilkan di atas target
                },
                {
                    label: "Target Rencana",
                    data: {!! json_encode($dataChartRencana) !!},
                    borderColor: "#6c757d", // Abu-abu
                    backgroundColor: gradientTarget,
                    borderDash: [5, 5],
                    borderWidth: 2,
                    pointRadius: 0,
                    fill: true,
                    tension: 0.4,
                    order: 2 // Menampilkan di bawah realisasi
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            plugins: { 
                legend: { 
                    display: true,
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        padding: 20,
                        font: {
                            size: 13
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleFont: {
                        size: 14
                    },
                    bodyFont: {
                        size: 13
                    },
                    padding: 12,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y.toLocaleString('id-ID') + ' bibit';
                        }
                    }
                }
            },
            scales: {
                y: { 
                    title: { 
                        display: true, 
                        text: "Jumlah Bibit",
                        font: {
                            size: 13,
                            weight: 'bold'
                        }
                    },
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('id-ID');
                        }
                    }
                },
                x: { 
                    ticks: { 
                        color: "#6c757d",
                        font: {
                            weight: 'bold',
                            size: 12
                        }
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}