    var ctxPie = document.getElementById("chart-status-dokumen");
    if (ctxPie) {
        new Chart(ctxPie.getContext("2d"), {
            type: "pie",
            data: {
                labels: ["Open", "Close", "Pending", "Proses Finance", "Hold"],
                datasets: [{
                    data: [
                        {{ $statuscount['open'] ?? 0 }},
                        {{ $statuscount['close'] ?? 0 }},
                        {{ $statuscount['pending'] ?? 0 }},
                        {{ $statuscount['proses finance'] ?? 0 }},
                        {{ $statuscount['hold'] ?? 0 }}
                    ],
                    // Warna disesuaikan dengan icon status
                    backgroundColor: ["#11cdef", "#2dce89", "#fb6340", "#5e72e4", "#f5365c"],
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Legend dimatikan karena sudah ada di header card
                    }
                },
                layout: {
                    padding: 20
                }
            }
        });
    }