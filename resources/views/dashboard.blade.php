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
        <div class "card z-index-2">
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
{{-- Report Ph air --}}
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
    {{-- Report TSs --}}
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

{{-- Detail Reklamasi --}}
<div class="row mt-4">
    <div class="col-lg-12 mb-lg-0 mb-4">
        <div class="card z-index-2">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Detail Reklamasi</h6>
                </div>

                <div class="row mt-2 mb-3">
                    <div class="col-md-6">
                        <label class="text-sm text-white">Tahun</label>
                        <select class="form-control">
                            <option value="">Pilih Tahun</option>
                            <option>2022</option>
                            <option>2023</option>
                            <option>2024</option>
                            <option>2025</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="text-sm text-white">Lokasi</label>
                        <select class="form-control">
                            <option value="">Pilih Lokasi</option>
                            <option>Lokasi 1</option>
                            <option>Lokasi 2</option>
                            <option>Lokasi 3</option>
                            <option>Lokasi 4</option>
                        </select>
                    </div>
                </div>
                <p class="text-sm mt-2 mb-0">
                    <span class="me-3">
                        <i class="fa-solid fa-circle text-info"></i>
                        <span class="ms-1">Lokasi 1</span>
                    </span>
                    <span>
                        <i class="fa-solid fa-circle text-success"></i>
                        <span class="ms-1">Lokasi 2</span>
                    </span>
                    <span>
                        <i class="fa-solid fa-circle text-danger"></i>
                        <span class="ms-1">Lokasi 3</span>
                    </span>
                    <span>
                        <i class="fa-solid fa-circle text-primary"></i>
                        <span class="ms-1">Lokasi 4</span>
                    </span>
                </p>
            </div>
            <div class="card-body p-3">
                <div class="bg-gradient-dark border-radius-lg py-3 pe-1 mb-3">
                    <div class="chart">
                        <canvas id="chart-bars2" class="chart-canvas" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('dashboard')
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Chart Bukaan lahan dan reklamasi
    var ctxBR = document.getElementById("chart-bukaanlahan-reklamasi").getContext("2d");
    new Chart(ctxBR, {
        type: "bar",
        data: {
            labels: {!! json_encode($reklamasiLabels) !!},
            datasets: [{
                    label: "Bukaan Lahan",
                    backgroundColor: '#11cdef', // text-info
                    data: {!! json_encode($finalBukaanValues) !!},
                    borderRadius: 4,
                    maxBarThickness: 35
                },
                {
                    label: "Reklamasi",
                    backgroundColor: '#2dce89', // text-success
                    data: {!! json_encode($finalReklamasiValues) !!},
                    borderRadius: 4,
                    maxBarThickness: 35
                }
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    title: {
                        display: true,
                        text: "Luas (Ha)",
                        color: "#fff",
                        font: { size: 14, family: "Open Sans", weight: "bold" },
                        padding: { bottom: 10 }
                    }, // <--- This was closing too late in your code
                    grid: {
                        drawBorder: false,
                        display: true,
                        drawOnChartArea: true,
                        drawTicks: false,
                        borderDash: [5, 5],
                        color: 'rgba(255, 255, 255, .2)'
                    },
                    ticks: {
                        display: true,
                        padding: 10,
                        color: '#f8f9fa',
                        font: { size: 11, family: "Open Sans", lineHeight: 2 },
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        display: true,
                        color: '#f8f9fa',
                        padding: 10,
                        font: { size: 11, family: "Open Sans", lineHeight: 2 },
                    }
                }
            }
        }
    });

    var ctx3 = document.getElementById("chart-pie").getContext("2d");
    // === CHART PIE (Status Dokumen) ===
    var ctx3 = document.getElementById("chart-pie");
    if (ctx3) {
        new Chart(ctx3.getContext("2d"), {
            type: "pie",
            data: {
                labels: ["Open", "Close", "Pending", "Proses Finance", "Hold"],
                datasets: [{
                    label: "Status Kontrak",
                    weight: 9,
                    cutout: 0,
                    tension: 0.9,
                    pointRadius: 2,
                    borderWidth: 2,
                    backgroundColor: ["#11cdef", "#2dce89", "#fb6340", "#5e72e4", "#f5365c"],
                    data: [
                        {{ $statuscount['open'] ?? 0 }},
                        {{ $statuscount['close'] ?? 0 }},
                        {{ $statuscount['pending'] ?? 0 }},
                        {{ $statuscount['proses finance'] ?? 0 }},
                        {{ $statuscount['hold'] ?? 0 }}
                    ],
                    fill: false
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                }
            }
        });
    }

    // CHART RITASE DAN JAM KERJA
    var ctx4 = document.getElementById("chart-ritase").getContext("2d");
    new Chart(ctx4, {
        type: "bar",
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [
                @foreach ($kodealat as $id => $kode)
                {
                    label: "{{ $kode }}",
                    data: {!! json_encode($chartData[$kode] ?? []) !!},
                    backgroundColor: 
                        @php
                            $colors = ['#11cdef', '#2dce89', '#f5365c', '#ffd600', '#9c27b0', '#8e24aa'];
                            echo "'" . $colors[$loop->index % count($colors)] . "'";
                        @endphp
                    ,
                    borderRadius: 6,
                    maxBarThickness: 40
                },
                @endforeach
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: "Jam",
                        color: "#fff",
                        font: {
                            size: 14,
                            family: "Open Sans",
                            weight: "bold"
                        },
                        padding: {
                            bottom: 10
                        }
                    },
                    grid: {
                        drawBorder: false,
                        display: false
                    },
                    ticks: {
                        color: "#fff",
                        padding: 10,
                        font: {
                            size: 13,
                            family: "Open Sans"
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: "#fff",
                        font: {
                            size: 12,
                            family: "Open Sans"
                        }
                    }
                }
            }
        }
    });

    // CHART - PH AIR
    var ctx5 = document.getElementById("chart-air").getContext("2d");
    // Mengambil data dari Laravel
    var phLabels = {!! json_encode($phLabels) !!};
    var phData = {!! json_encode($phValues) !!};
    var bmAtasValue = {{ $bmAtas }};
    var bmBawahValue = {{ $bmBawah }};

    new Chart(ctx5, {
        type: "line",
        data: {
            labels: phLabels,
            datasets: [
                {
                    label: "PH Air",
                    data: phData,
                    borderColor: "#11cdef",
                    backgroundColor: "rgba(17, 205, 223, 0.2)",
                    borderWidth: 3,
                    fill: true,
                    pointRadius: 4,
                    tension: 0.4,
                    zIndex: 3
                },
                {
                    label: "BM Atas (Max " + bmAtasValue + ")",
                    data: Array(phLabels.length).fill(bmAtasValue),
                    borderColor: "#f5365c", // Merah
                    borderWidth: 2,
                    borderDash: [5, 5],
                    fill: false,
                    pointRadius: 0
                },
                {
                    label: "BM Bawah (Min " + bmBawahValue + ")",
                    data: Array(phLabels.length).fill(bmBawahValue),
                    borderColor: "#ffd600", // Kuning
                    borderWidth: 2,
                    borderDash: [5, 5],
                    fill: false,
                    pointRadius: 0
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    labels: { color: "#fff" }
                }
            },
            scales: {
                y: {
                    min: 0,
                    max: 14, // pH scale 0-14
                    ticks: { color: "#fff" },
                    grid: { color: "rgba(255, 255, 255, 0.1)", drawBorder: false }
                },
                x: {
                    ticks: { color: "#fff" },
                    grid: { display: false }
                }
            }
        }
    });

    // Chart TSS
    var ctx6 = document.getElementById("chart-tss").getContext("2d");

    var tssLabels = {!! json_encode($tssLabels) !!};
    var tssData = {!! json_encode($tssValues) !!};
    var bmTssValue = {{ $bmTss }};

    new Chart(ctx6, {
        type: "line",
        data: {
            labels: tssLabels,
            datasets: [
                {
                    label: "Kadar TSS (mg/L)",
                    data: tssData,
                    borderColor: "#2dce89", // Hijau
                    backgroundColor: "rgba(45, 206, 137, 0.2)",
                    borderWidth: 3,
                    fill: true,
                    pointRadius: 4,
                    tension: 0.4,
                    zIndex: 3
                },
                {
                    label: "Baku Mutu (" + bmTssValue + " mg/L)",
                    data: Array(tssLabels.length).fill(bmTssValue),
                    borderColor: "#f5365c", // Merah sebagai peringatan batas
                    borderWidth: 2,
                    borderDash: [5, 5],
                    fill: false,
                    pointRadius: 0
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    labels: { color: "#fff" }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    // Kita beri space sedikit di atas garis baku mutu agar terlihat jelas
                    max: Math.max(...tssData, bmTssValue) + 50, 
                    ticks: { color: "#fff" },
                    grid: { color: "rgba(255, 255, 255, 0.1)", drawBorder: false }
                },
                x: {
                    ticks: { color: "#fff" },
                    grid: { display: false }
                }
            }
        }
    });
});
</script>
@endpush