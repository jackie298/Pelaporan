var ctxRencana = document.getElementById("chart-revegetasi-rencana");
    if (ctxRencana) {
        var gradient = ctxRencana.getContext("2d").createLinearGradient(0, 230, 0, 50);
        gradient.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
        gradient.addColorStop(0, 'rgba(94, 114, 228, 0)');

        new Chart(ctxRencana.getContext("2d"), {
            type: "line",
            data: {
                labels: {!! json_encode($monthsFull) !!},
                datasets: [
                    {
                        label: "Realisasi Aktual",
                        data: {!! json_encode($dataChartRealisasi) !!},
                        borderColor: "#5e72e4",
                        backgroundColor: gradient,
                        borderWidth: 3,
                        pointRadius: 4,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: "Target Rencana",
                        data: {!! json_encode($dataChartRencana) !!},
                        borderColor: "#adb5bd",
                        borderDash: [5, 5],
                        borderWidth: 2,
                        pointRadius: 0,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: true } },
                scales: {
                    y: { title: { display: true, text: "Jumlah Bibit" } },
                    x: { ticks: { color: "#b2b9bf" } }
                }
            }
        });
    }