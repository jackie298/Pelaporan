var ctxRitase = document.getElementById("chart-ritase");
    if (ctxRitase) {
        new Chart(ctxRitase.getContext("2d"), {
            type: "bar",
            data: {
                labels: {!! json_encode($ritaseLabels) !!},
                datasets: [
                    @foreach ($kodealat as $id => $kode)
                    {
                        label: "{{ $kode }}",
                        data: {!! json_encode($chartData[$kode] ?? []) !!},
                        backgroundColor: 
                            @php
                                $colors = ['#11cdef', '#2dce89', '#f5365c', '#9c27b0', '#ffd600', '#8e24aa'];
                                echo "'" . $colors[$loop->index % count($colors)] . "'";
                            @endphp,
                        borderRadius: 6,
                        maxBarThickness: 40
                    },
                    @endforeach
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, title: { display: true, text: "Jam" } },
                    x: { ticks: { color: "#fff" } }
                }
            }
        });
    }