var ctxRev = document.getElementById("chart-revegetasi");
    if (ctxRev) {
        new Chart(ctxRev.getContext("2d"), {
            type: "bar",
            data: {
                labels: {!! json_encode($revegetasiLabels) !!},
                datasets: [{
                    label: "Jumlah Pohon",
                    backgroundColor: "rgba(255, 255, 255, .8)",
                    data: {!! json_encode($revegetasiValues) !!},
                    borderRadius: 4,
                    maxBarThickness: 50
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { title: { display: true, text: "Jumlah Pohon" }, ticks: { color: "#fff" } },
                    x: { title: { display: true, text: "Lokasi" }, ticks: { color: "#f8f9fa" } }
                }
            }
        });
    }