@foreach($wasteWaterGroups as $lokasi => $samplers)
    @foreach($samplers as $sampler => $data)
        @php 
            $safeId = Str::slug($lokasi . '-' . $sampler); 
            $labels = $data->map(fn($item) => \Carbon\Carbon::parse($item->tanggal_sampling)->format('d/m'))->toArray();
            $phValues = $data->pluck('ph')->toArray();
            $tssValues = $data->pluck('tss')->toArray();
            $count = count($labels); 
        @endphp

        // Inisialisasi Chart PH
        var ctxPh_{{ str_replace('-', '_', $safeId) }} = document.getElementById("chart-ph-{{ $safeId }}");
        if (ctxPh_{{ str_replace('-', '_', $safeId) }}) {
            new Chart(ctxPh_{{ str_replace('-', '_', $safeId) }}.getContext("2d"), {
                type: "line",
                plugins: [ChartDataLabels],
                data: {
                    labels: {!! json_encode($labels) !!},
                    datasets: [
                        {
                            label: "PH Air",
                            data: {!! json_encode($phValues) !!},
                            borderColor: "#11cdef",
                            backgroundColor: "rgba(17, 205, 223, 0.2)",
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            datalabels: {
                                display: true,
                                color: '#fff',
                                align: 'top',
                                font: { weight: 'bold' }
                            }
                        },
                        {
                            label: "BM Atas ({{ $bmAtas }})",
                            data: Array({{ $count }}).fill({{ $bmAtas }}),
                            borderColor: "#f5365c",
                            borderDash: [5, 5],
                            pointRadius: 0,
                            fill: false,
                            datalabels: { display: false }
                        },
                        {
                            label: "BM Bawah ({{ $bmBawah }})",
                            data: Array({{ $count }}).fill({{ $bmBawah }}),
                            borderColor: "#ffd600",
                            borderDash: [5, 5],
                            pointRadius: 0,
                            fill: false,
                            datalabels: { display: false }
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { min: 0, max: 14, ticks: { color: "#fff" } },
                        x: { ticks: { color: "#fff" } }
                    }
                }
            });
        }

        // Inisialisasi Chart TSS
        var ctxTss_{{ str_replace('-', '_', $safeId) }} = document.getElementById("chart-tss-{{ $safeId }}");
        if (ctxTss_{{ str_replace('-', '_', $safeId) }}) {
            new Chart(ctxTss_{{ str_replace('-', '_', $safeId) }}.getContext("2d"), {
                type: "line",
                plugins: [ChartDataLabels],
                data: {
                    labels: {!! json_encode($labels) !!},
                    datasets: [
                        {
                            label: "TSS",
                            data: {!! json_encode($tssValues) !!},
                            borderColor: "#2dce89",
                            backgroundColor: "rgba(45, 206, 137, 0.2)",
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            datalabels: {
                                display: true,
                                color: '#fff',
                                align: 'top',
                                font: { weight: 'bold' }
                            }
                        },
                        {
                            label: "Baku Mutu",
                            data: Array({{ $count }}).fill({{ $bmTss }}),
                            borderColor: "#f5365c",
                            borderDash: [5, 5],
                            pointRadius: 0,
                            fill: false,
                            datalabels: { display: false }
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { color: "#fff" } },
                        x: { ticks: { color: "#fff" } }
                    }
                }
            });
        }
    @endforeach
@endforeach