var ctxRata2 = document.getElementById("chart-monitoring-rata2");
if (ctxRata2) {
    var chart = new Chart(ctxRata2.getContext("2d"), {
        type: "line",
        data: {
            labels: {!! json_encode($growthLabels) !!},
            datasets: [{
                label: "Rata-rata Tinggi Tanaman (cm)",
                data: {!! json_encode($values) !!},
                borderColor: "#11cdef",
                backgroundColor: "rgba(17, 205, 223, 0.2)",
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 8,
                pointBackgroundColor: "#fff",
                pointBorderColor: "#11cdef",
                pointBorderWidth: 3,
                pointHoverRadius: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { 
                    display: true,
                    position: 'top',
                    labels: {
                        color: "#fff",
                        font: {
                            family: "Open Sans",
                            size: 13
                        }
                    }
                },
                tooltip: {
                    enabled: true,
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    callbacks: {
                        label: function(context) {
                            // ✅ Tampilkan nilai dengan satuan di tooltip
                            return context.dataset.label + ": " + context.parsed.y.toFixed(2) + " cm";
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: "Tinggi (cm)",
                        color: "#fff",
                        font: { size: 14, family: "Open Sans", weight: "bold" }
                    },
                    grid: {
                        drawBorder: false,
                        color: "rgba(255,255,255,0.1)"
                    },
                    ticks: {
                        color: "#fff",
                        font: { size: 12, family: "Open Sans" },
                        callback: function(value) {
                            return value + ' cm';
                        }
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: "Periode",
                        color: "#fff",
                        font: { size: 14, family: "Open Sans", weight: "bold" }
                    },
                    grid: { 
                        display: false 
                    },
                    ticks: {
                        color: "#fff",
                        font: { size: 12, family: "Open Sans", weight: "bold" }
                    }
                }
            }
        }
    });
    
    // ✅ Tambahkan nilai di atas titik secara manual (tanpa plugin)
    chart.canvas.addEventListener('mousemove', function(evt) {
        var activePoints = chart.getElementsAtEventForMode(evt, 'nearest', { intersect: true }, true);
        if (activePoints.length) {
            // Hover effect sudah ditangani oleh tooltip
        }
    });
}