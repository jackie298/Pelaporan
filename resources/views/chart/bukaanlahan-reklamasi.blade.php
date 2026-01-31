// === CHART BUKAAN LAHAN & REKLAMASI ===
    var ctxBR = document.getElementById("chart-bukaanlahan-reklamasi");
    if (ctxBR) {
        new Chart(ctxBR.getContext("2d"), {
            type: "bar",
            data: {
                labels: {!! json_encode($reklamasiLabels) !!},
                datasets: [
                    {
                        label: "Bukaan Lahan",
                        backgroundColor: '#11cdef',
                        data: {!! json_encode($finalBukaanValues) !!},
                        borderRadius: 4,
                        maxBarThickness: 35
                    },
                    {
                        label: "Reklamasi",
                        backgroundColor: '#2dce89',
                        data: {!! json_encode($finalReklamasiValues) !!},
                        borderRadius: 4,
                        maxBarThickness: 35
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        title: { display: true, text: "Luas (Ha)", color: "#fff", font: { size: 14 } },
                        grid: { drawBorder: false, color: 'rgba(255,255,255,0.2)' },
                        ticks: { color: '#f8f9fa', font: { size: 11 } }
                    },
                    x: { grid: { display: false }, ticks: { color: '#f8f9fa' } }
                }
            }
        });
    }