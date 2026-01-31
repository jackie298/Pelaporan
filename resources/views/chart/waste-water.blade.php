// === CHART PH AIR ===
    var ctxPh = document.getElementById("chart-air");
    if (ctxPh) {
        new Chart(ctxPh.getContext("2d"), {
            type: "line",
            data: {
                labels: {!! json_encode($phLabels) !!},
                datasets: [
                    {
                        label: "PH Air",
                        data: {!! json_encode($phValues) !!},
                        borderColor: "#11cdef",
                        backgroundColor: "rgba(17, 205, 223, 0.2)",
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: "BM Atas ({{ $bmAtas }})",
                        data: Array({{ count($phLabels) }}).fill({{ $bmAtas }}),
                        borderColor: "#f5365c",
                        borderDash: [5, 5],
                        borderWidth: 2,
                        pointRadius: 0,
                        fill: false
                    },
                    {
                        label: "BM Bawah ({{ $bmBawah }})",
                        data: Array({{ count($phLabels) }}).fill({{ $bmBawah }}),
                        borderColor: "#ffd600",
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
                    y: { min: 0, max: 14, ticks: { color: "#fff" } },
                    x: { ticks: { color: "#fff" } }
                }
            }
        });
    }

    // === CHART TSS ===
    var ctxTss = document.getElementById("chart-tss");
    if (ctxTss) {
        new Chart(ctxTss.getContext("2d"), {
            type: "line",
            data: {
                labels: {!! json_encode($tssLabels) !!},
                datasets: [
                    {
                        label: "TSS (mg/L)",
                        data: {!! json_encode($tssValues) !!},
                        borderColor: "#2dce89",
                        backgroundColor: "rgba(45, 206, 137, 0.2)",
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: "Baku Mutu ({{ $bmTss }} mg/L)",
                        data: Array({{ count($tssLabels) }}).fill({{ $bmTss }}),
                        borderColor: "#f5365c",
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
                    y: { beginAtZero: true, ticks: { color: "#fff" } },
                    x: { ticks: { color: "#fff" } }
                }
            }
        });
    }