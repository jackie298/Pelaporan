// === CHART PIE (Status Dokumen) ===
    var ctxPie = document.getElementById("chart-pie");
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
                    backgroundColor: ["#11cdef", "#2dce89", "#fb6340", "#5e72e4", "#f5365c"]
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
        });
    }