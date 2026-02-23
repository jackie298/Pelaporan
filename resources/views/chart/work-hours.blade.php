// Palette warna yang sama dengan PHP
    const colorPalette = @json($palette);

    // Helper untuk generate dataset
    function generateDatasetsBar(chartData, colors) {
        let datasets = [];
        let i = 0;
        for (const [kode, data] of Object.entries(chartData)) {
            datasets.push({
                label: kode,
                data: data,
                backgroundColor: colors[i % colors.length],
                borderRadius: 4,
                maxBarThickness: 12
            });
            i++;
        }
        return datasets;
    }

    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: {
                grid: { drawBorder: false, display: true, drawOnChartArea: true, borderDash: [5, 5], color: 'rgba(255, 255, 255, .2)' },
                ticks: { color: '#f8f9fa', padding: 10 }
            },
            x: {
                grid: { display: false },
                ticks: { color: '#f8f9fa', padding: 10 }
            }
        }
    };

    // Render 3 Chart
    new Chart(document.getElementById("chart-exca-murni"), {
        type: "bar",
        data: { labels: @json($ritaseLabels), datasets: generateDatasetsBar(@json($chartDataExca), colorPalette) },
        options: chartOptions
    });

    new Chart(document.getElementById("chart-pendukung"), {
        type: "bar",
        data: { labels: @json($ritaseLabels), datasets: generateDatasetsBar(@json($chartDataPendukung), colorPalette) },
        options: chartOptions
    });

    new Chart(document.getElementById("chart-dt"), {
        type: "bar",
        data: { labels: @json($ritaseLabels), datasets: generateDatasetsBar(@json($chartDataDT), colorPalette) },
        options: chartOptions
    });