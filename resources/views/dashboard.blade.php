@extends('layouts.user_type.auth')

@section('content')

<div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Reklamasi</p>
                            <h5 class="font-weight-bolder mb-0">
                                80.000
                                <span class="text-dark text-sm font-weight-bolder">Ha</span>
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="fa-solid fa-land-mine-on text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Waste Management</p>
                            <h5 class="font-weight-bolder mb-0">0</h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="fa-solid fa-bars-progress text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Compliance</p>
                            <h5 class="font-weight-bolder mb-0">0</h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="fa-solid fa-clipboard-check text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Dokumen Kontrak & Grafik --}}
<div class="row mt-4">
    <div class="col-lg-6 mb-lg-0 mb-4">
        <div class="card z-index-2">
            <div class="card-header pb-0">
                <h6>Rekap Anggaran</h6>
            </div>
            <div class="card-body p-3">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kontrak File</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($documentContracts ?? [] as $index => $documentContract)
                            <tr>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $index + 1 }}</p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $documentContract->nama }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <a href="{{ asset('storage/contracts/' . $documentContract->file_kontrak) }}" target="_blank" class="btn btn-link text-secondary mb-0">
                                        <i class="fa fa-file-pdf-o text-lg me-2" aria-hidden="true"></i> Lihat File
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-lg-0 mb-4">
        <div class="card z-index-2">
            <div class="card-header pb-0">
                <h6>Grafik Status Dokumen</h6>
                <p class="text-sm mb-0">
                    <span class="me-3">
                        <i class="fa-solid fa-circle text-info"></i>
                        <span class="ms-1">Open: {{ $statuscount['open'] ?? 0 }}</span>
                    </span>
                    <span class="me-3">
                        <i class="fa-solid fa-circle text-success"></i>
                        <span class="ms-1">Close: {{ $statuscount['close'] ?? 0 }}</span>
                    </span>
                    <span class="me-3">
                        <i class="fa-solid fa-circle text-warning"></i>
                        <span class="ms-1">Pending: {{ $statuscount['pending'] ?? 0 }}</span>
                    </span>
                    <span class="me-3">
                        <i class="fa-solid fa-circle text-primary"></i>
                        <span class="ms-1">Proses Finance: {{ $statuscount['proses finance'] ?? 0 }}</span>
                    </span>
                    <span class="me-3">
                        <i class="fa-solid fa-circle text-danger"></i>
                        <span class="ms-1">Hold: {{ $statuscount['hold'] ?? 0 }}</span>
                    </span>
                </p>
            </div>
            <div class="card-body p-3">
                <div class="bg-gradient-dark border-radius-lg py-3 pe-1 mb-3">
                    <div class="chart">
                        <canvas id="chart-pie" class="chart-pie" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- BUKAAN LAHAN DAN REKLAMASI --}}
<div class="row mt-4">
    <div class="col-lg-12 mb-lg-0 mb-4">
        <div class="card z-index-2">
            <div class="card-header pb-0">
                <h6>Bukaan Lahan Dan Reklamasi</h6>
                <p class="text-sm mb-0">
                    <span class="me-3">
                        <i class="fa-solid fa-circle text-info"></i>
                        <span class="ms-1">Bukaan Lahan (ha)</span>
                    </span>
                    <span class="me-3">
                        <i class="fa-solid fa-circle text-success"></i>
                        <span class="ms-1">Reklamasi (ha)</span>
                    </span>
                </p>
            </div>
            <div class="card-body p-3">
                <div class="bg-gradient-dark border-radius-lg py-3 pe-1 mb-3">
                    <div class="chart">
                        <canvas id="chart-bukaanlahan-reklamasi" class="chart-canvas" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Revegetasi --}}
<div class="row mt-4">
    <div class="col-lg-12 mb-lg-0 mb-4">
        <div class="card z-index-2">
            <div class="card-header pb-0">
                <h6>Grafik Monitoring Revegetasi</h6>
                <p class="text-sm mb-0">
                    <i class="fa fa-arrow-up text-success"></i>
                    <span class="font-weight-bold">Total Pohon</span> per Lokasi
                </p>
            </div>
            <div class="card-body p-3">
                <div class="bg-gradient-dark border-radius-lg py-3 pe-1 mb-3">
                    <div class="chart">
                        <canvas id="chart-revegetasi" class="chart-canvas" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Grafik Rata-rata Pertumbuhan Per Triwulan + Rata-rata Tahunan --}}
<div class="row mt-4">
    <div class="col-lg-12 mb-lg-0 mb-4">
        <div class="card z-index-2">
            <div class="card-header pb-0">
                <h6>Pertumbuhan Rata² Tanaman Tahun {{ $currentYear }}</h6>
                <p class="text-sm mb-0">
                    <i class="fa fa-arrow-up text-success"></i>
                    <span class="font-weight-bold">Nilai dalam cm</span>
                </p>
            </div>
            <div class="card-body p-3">
                <div class="bg-gradient-dark border-radius-lg py-3 pe-1 mb-3">
                    <div class="chart">
                        <canvas id="chart-monitoring-rata2" class="chart-canvas" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Grafik Nursery --}}
<div class="row mt-4">
    <div class="col-lg-12 mb-lg-0 mb-4">
        <div class="card z-index-2">
            <div class="card-header pb-0">
                <h6>Status Pembibitan (Nursery)</h6>
                <p class="text-sm mb-0">
                    <i class="fa fa-leaf text-success"></i>
                    <span class="font-weight-bold">Total Bibit</span> Berdasarkan Jenis Tanaman
                </p>
            </div>
            <div class="card-body p-3">
                <div class="bg-gradient-dark border-radius-lg py-3 pe-1 mb-3">
                    <div class="chart">
                        <canvas id="chart-nursery" class="chart-canvas" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- RENCANA DAN REALISASI --}}
<div class="row mt-4">
    <div class="col-lg-12">
        <div class="card z-index-2">
            <div class="card-header pb-0">
                <h6>Performa Revegetasi Tahun {{ date('Y') }}</h6>
                <p class="text-sm">
                    <i class="fa fa-arrow-up text-success"></i>
                    <span class="font-weight-bold">Rencana dan Realisasi</span> Penanaman Bibit
                </p>
            </div>
            <div class="card-body p-3">
                <div class="chart">
                    <canvas id="chart-revegetasi-rencana" class="chart-canvas" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- RITASE DAN JAM KERJA ALAT --}}
<div class="row mt-4">
    <div class="col-lg-12 mb-lg-0 mb-4">
        <div class="card z-index-2">
            <div class="card-header pb-0">
                <h6>Ritase dan Jam Kerja Alat</h6>
                <p class="text-sm mb-0">
                    @foreach ($kodealat as $id => $kode)
                        <span class="me-3">
                            <i class="fa-solid fa-circle 
                                @php
                                    $colors = ['text-info', 'text-success', 'text-danger', 'text-primary', 'text-warning', 'text-secondary'];
                                    echo $colors[$loop->index % count($colors)];
                                @endphp
                            "></i>
                            <span class="ms-1">{{ $kode }}</span>
                        </span>
                    @endforeach
                </p>
            </div>
            <div class="card-body p-3">
                <div class="bg-gradient-dark border-radius-lg py-3 pe-1 mb-3">
                    <div class="chart">
                        <canvas id="chart-ritase" class="chart-canvas" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Report Ph air dan TSs --}}
<div class="row mt-4">
    <div class="col-lg-6 mb-lg-0 mb-4">
        <div class="card z-index-2">
            <div class="card-header pb-0">
                <h6>PH Air</h6>
            </div>
            <div class="card-body p-3">
                <div class="bg-gradient-dark border-radius-lg py-3 pe-1 mb-3">
                    <div class="chart">
                        <canvas id="chart-air" class="chart-canvas" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
      <div class="card z-index-2">
          <div class="card-header pb-0">
              <h6>Monitoring TSS Air</h6>
              <p class="text-sm mb-0">
                  <span>
                      <i class="fa fa-arrow-up text-danger"></i>
                      <span class="font-weight-bold">Baku Mutu: {{ $bmTss }} mg/L</span>
                  </span>
              </p>
          </div>
          <div class="card-body p-3">
              <div class="bg-gradient-dark border-radius-lg py-3 pe-1 mb-3">
                  <div class="chart">
                      <canvas id="chart-tss" class="chart-canvas" height="300"></canvas>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>

@endsection

@push('dashboard')
<script>
document.addEventListener('DOMContentLoaded', function () {
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

    // === CHART REVEGETASI (Jumlah Pohon per Lokasi) ===
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

    // === CHART: RATA-RATA PERTUMBUHAN PER TRIWULAN (MODEL GAMBAR KE-2) ===
    var ctxRata2 = document.getElementById("chart-monitoring-rata2");
    if (ctxRata2) {
        new Chart(ctxRata2.getContext("2d"), {
            type: "line",
            data: {
                // Sumbu X: 0, 1, 2, 3, 4 (numerik)
                labels: [0, 1, 2, 3, 4],
                datasets: [{
                    label: "Rata-rata Tinggi Tanaman (cm)",
                    data: {!! json_encode($values) !!},
                    borderColor: "#11cdef",      // Biru Soft UI
                    backgroundColor: "rgba(17, 205, 223, 0.2)",
                    borderWidth: 3,
                    fill: false,
                    tension: 0.4,
                    pointRadius: 6,
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 2,
                    pointHoverRadius: 8,
                    // Tampilkan nilai di atas titik
                    datalabels: {
                        display: true,
                        color: "#fff",
                        font: {
                            weight: "bold",
                            size: 12
                        },
                        formatter: function(value) {
                            return value.toFixed(2);
                        },
                        anchor: 'top',
                        align: 'top'
                    }
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        enabled: true,
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ": " + context.parsed.y + " cm";
                            }
                        }
                    },
                    // Plugin datalabels — pastikan Anda sudah load plugin ini
                    datalabels: {
                        display: true,
                        color: "#fff",
                        font: {
                            weight: "bold",
                            size: 12
                        },
                        formatter: function(value) {
                            return value.toFixed(2);
                        },
                        anchor: 'top',
                        align: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: "Tinggi (cm)",
                            color: "#fff",
                            font: { size: 14, family: "Open Sans", weight: "bold" }
                        },
                        grid: {
                            drawBorder: false,
                            color: "rgba(255,255,255,0.1)"
                        },
                        ticks: {
                            color: "#fff",
                            font: { size: 12, family: "Open Sans" }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: "Triwulan",
                            color: "#fff",
                            font: { size: 14, family: "Open Sans", weight: "bold" }
                        },
                        grid: { display: false },
                        ticks: {
                            color: "#fff",
                            font: { size: 12, family: "Open" },
                            callback: function(value) {
                                const labels = ["Triwulan 1", "Triwulan 2", "Triwulan 3", "Triwulan 4", "Rata-rata Tahun"];
                                return labels[value] || value;
                            }
                        }
                    }
                }
            },
        });
    }

    // === CHART RENCANA vs REALISASI ===
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

    // === CHART NURSERY ===
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

    // === CHART RITASE ===
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
});
</script>
@endpush