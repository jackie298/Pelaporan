var ctxNursery = document.getElementById("chart-nursery");
    if (ctxNursery) {
        new Chart(ctxNursery.getContext("2d"), {
            type: "bar",
            data: {
                labels: {!! json_encode($nurseryLabels ?? []) !!},
                datasets: [{
                    label: "Jumlah Bibit",
                    backgroundColor: "#2dce89",
                    data: {!! json_encode($nurseryValues ?? []) !!},
                    borderRadius: 4,
                    maxBarThickness: 50
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { title: { display: true, text: "Jumlah (Batang)" }, ticks: { color: "#fff" } },
                    x: { title: { display: true, text: "Jenis Tanaman" }, ticks: { color: "#f8f9fa" } }
                }
            }
        });
    }