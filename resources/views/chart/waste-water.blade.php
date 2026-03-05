{{-- Loop melalui setiap lokasi --}}
    @foreach($wasteWaterGroups as $lokasi => $samplers)
        {{-- Loop melalui setiap sampler (Inlet/Outlet) --}}
        @foreach($samplers as $sampler => $data)
            @php 
                // Buat slug unik untuk ID canvas
                $safeId = Str::slug($lokasi . '-' . $sampler); 
                
                // Siapkan data spesifik untuk grup ini
                $labels = $data->map(fn($item) => \Carbon\Carbon::parse($item->tanggal_sampling)->format('d/m'))->toArray();
                $phValues = $data->pluck('ph')->toArray();
                $tssValues = $data->pluck('tss')->toArray();
                $count = count($labels);
            @endphp

            // === CHART PH AIR ({{ $lokasi }} - {{ $sampler }}) ===
            var ctxPh = document.getElementById("chart-ph-{{ $safeId }}");
            if (ctxPh) {
                new Chart(ctxPh.getContext("2d"), {
                    type: "line",
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
                                tension: 0.4
                            },
                            {
                                label: "BM Atas ({{ $bmAtas }})",
                                data: Array({{ $count }}).fill({{ $bmAtas }}),
                                borderColor: "#f5365c",
                                borderDash: [5, 5],
                                borderWidth: 2,
                                pointRadius: 0,
                                fill: false
                            },
                            {
                                label: "BM Bawah ({{ $bmBawah }})",
                                data: Array({{ $count }}).fill({{ $bmBawah }}),
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
                        plugins: { legend: { display: true, labels: { color: '#fff' } } },
                        scales: {
                            y: { min: 0, max: 14, ticks: { color: "#fff" } },
                            x: { ticks: { color: "#fff" } }
                        }
                    }
                });
            }

            // === CHART TSS ({{ $lokasi }} - {{ $sampler }}) ===
            var ctxTss = document.getElementById("chart-tss-{{ $safeId }}");
            if (ctxTss) {
                new Chart(ctxTss.getContext("2d"), {
                    type: "line",
                    data: {
                        labels: {!! json_encode($labels) !!},
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
                                data: Array({{ $count }}).fill({{ $bmTss }}),
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
                        plugins: { legend: { display: true, labels: { color: '#fff' } } },
                        scales: {
                            y: { beginAtZero: true, ticks: { color: "#fff" } },
                            x: { ticks: { color: "#fff" } }
                        }
                    }
                });
            }
        @endforeach
    @endforeach