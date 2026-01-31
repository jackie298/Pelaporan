var ctxRata2 = document.getElementById("chart-monitoring-rata2");
    if (ctxRata2) {
        new Chart(ctxRata2.getContext("2d"), {
            type: "line",
            data: {
                // Sumbu X: 0, 1, 2, 3, 4 (numerik)
                labels: [0, 1, 2, 3, 4],
                datasets: [{
                    label: "Rata-rata Tinggi Tanaman (cm)",
                    data: {!! json_encode($values) !!},
                    borderColor: "#11cdef",      // Biru Soft UI
                    backgroundColor: "rgba(17, 205, 223, 0.2)",
                    borderWidth: 3,
                    fill: false,
                    tension: 0.4,
                    pointRadius: 6,
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 2,
                    pointHoverRadius: 8,
                    // Tampilkan nilai di atas titik
                    datalabels: {
                        display: true,
                        color: "#fff",
                        font: {
                            weight: "bold",
                            size: 12
                        },
                        formatter: function(value) {
                            return value.toFixed(2);
                        },
                        anchor: 'top',
                        align: 'top'
                    }
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        enabled: true,
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ": " + context.parsed.y + " cm";
                            }
                        }
                    },
                    // Plugin datalabels — pastikan Anda sudah load plugin ini
                    datalabels: {
                        display: true,
                        color: "#fff",
                        font: {
                            weight: "bold",
                            size: 12
                        },
                        formatter: function(value) {
                            return value.toFixed(2);
                        },
                        anchor: 'top',
                        align: 'top'
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
                            font: { size: 12, family: "Open Sans" }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: "Triwulan",
                            color: "#fff",
                            font: { size: 14, family: "Open Sans", weight: "bold" }
                        },
                        grid: { display: false },
                        ticks: {
                            color: "#fff",
                            font: { size: 12, family: "Open" },
                            callback: function(value) {
                                const labels = ["Triwulan 1", "Triwulan 2", "Triwulan 3", "Triwulan 4", "Rata-rata Tahun"];
                                return labels[value] || value;
                            }
                        }
                    }
                }
            },
        });
    }