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
    {{-- <div class="col-xl-3 col-sm-6">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Sales</p>
                <h5 class="font-weight-bolder mb-0">
                  $103,430
                  <span class="text-success text-sm font-weight-bolder">+5%</span>
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> --}}
  </div>
  
  {{-- Dokumen Kontrak (Khusus Admin) --}}
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
          <h6>Grafik </h6>
          <p
            class="text-sm mb-0">
            <span class="me-3">
              <i class="fa-solid fa-circle text-info"></i>
              <span class="ms-1">Aktif: {{ $statuscount['aktif'] ?? 0 }}</span>
            </span>
            <span class="me-3">
              <i class="fa-solid fa-circle text-success"></i>
              <span class="ms-1">Selesai: {{ $statuscount['selesai'] ?? 0 }}</span>
            </span>
            <span class="me-3">
              <i class="fa-solid fa-circle text-danger"></i>
              <span class="ms-1">Batal: {{ $statuscount['batal'] ?? 0 }}</span>
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
  

  {{-- Report Harian --}}
  <!-- <div class="row mt-4"> -->
    <!-- <div class="col-lg-12 mb-lg-0 mb-4">
      <div class="card z-index-2">
        <div class="card-header pb-0">
          <h6></h6>
          <p class="text-sm mb-0">
            <span class="me-3">
              <i class="fa-solid fa-circle text-info"></i>
              <span class="ms-1"></span>
            </span>
            <span class="me-3">
              <i class="fa-solid fa-circle text-success"></i>
              <span class="ms-1"></span>
            </span>
            <span>
              <i class="fa-solid fa-circle text-danger"></i>
              <span class="ms-1"></span>
            </span>
          </p>
        </div>
        <div class="card-body p-3">
          <div class="bg-gradient-dark border-radius-lg py-3 pe-1 mb-3">
            <div class="chart">
              <canvas id="chart" class="chart-canvas" height="300"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div> -->
  {{-- Report Harian --}}
  <div class="row mt-4">
    <!-- <div class="col-lg-12 mb-lg-0 mb-4">
      <div class="card z-index-2">
        <div class="card-header pb-0">
          <h6>Grafik Harian</h6>
          <p class="text-sm mb-0">
            <span class="me-3">
              <i class="fa-solid fa-circle text-info"></i>
              <span class="ms-1">Bukaan Lahan</span>
            </span>
            <span class="me-3">
              <i class="fa-solid fa-circle text-success"></i>
              <span class="ms-1">Reklamasi</span>
            </span>
            <span>
              <i class="fa-solid fa-circle text-danger"></i>
              <span class="ms-1">Revegetasi</span>
            </span>
          </p>
        </div>
        <div class="card-body p-3">
          <div class="bg-gradient-dark border-radius-lg py-3 pe-1 mb-3">
            <div class="chart">
              <canvas id="chart-bars-harian" class="chart-canvas" height="300"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div> -->
    {{-- Report Mingguan --}}
    <div class="row mt-4">
    <!-- <div class="col-lg-12 mb-lg-0 mb-4">
      <div class="card z-index-2">
        <div class="card-header pb-0">
          <h6>Grafik Mingguan</h6>
          <p class="text-sm mb-0">
            <span class="me-3">
              <i class="fa-solid fa-circle text-info"></i>
              <span class="ms-1">Bukaan Lahan</span>
            </span>
            <span class="me-3">
              <i class="fa-solid fa-circle text-success"></i>
              <span class="ms-1">Reklamasi</span>
            </span>
            <span>
              <i class="fa-solid fa-circle text-danger"></i>
              <span class="ms-1">Revegetasi</span>
            </span>
          </p>
        </div>
        <div class="card-body p-3">
          <div class="bg-gradient-dark border-radius-lg py-3 pe-1 mb-3">
            <div class="chart">
              <canvas id="chart-bars-mingguan" class="chart-canvas" height="300"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div> -->
    {{-- Ritase dan Jam Kerja Alat --}}
    <div class="row mt-4">
    <div class="col-lg-12 mb-lg-0 mb-4">
      <div class="card z-index-2">
        <div class="card-header pb-0">
          <h6>Ritase dan Jam Kerja Alat</h6>          
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
    {{-- Report Ph air dan TSs --}}
    <div class="row mt-4">
    <div class="col-lg-6 mb-lg-0 mb-4">
      <div class="card z-index-2">
        <div class="card-header pb-0">
          <h6>Ph Air</h6>          
        </div>
        <div class="card-body p-3">
          <div class="border-radius-lg py-3 pe-1 mb-3">
            <div class="chart">
              <canvas id="chart-ph-air" class="chart-canvas" height="300"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card z-index-2">
        <div class="card-header pb-0">
          <h6>TSS</h6>
          <!-- <p class="text-sm mb-0">
            <span class="me-3">
              <i class="fa-solid fa-circle text-success"></i>
              <span class="ms-1">Rencana</span>
            </span>
            <span>
              <i class="fa-solid fa-circle text-danger"></i>
              <span class="ms-1">Realisasi</span>
            </span>
          </p> -->
        </div>
        <div class="card-body p-3">
          <div class="chart">
            <canvas id="chart-line-tss"  height="300"></canvas>
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>
  {{-- Bukaan Lahan --}}
  <div class="row mt-4">
      <div class="col-lg-12 mb-lg-0 mb-4">
          <div class="card z-index-2">
              <div class="card-header pb-0">
                  <div class="d-flex justify-content-between align-items-center">
                      <h6 class="mb-0">Bukaan Lahan</h6>
                  </div>                 
              </div>
              <div class="card-body p-3">
                  <div class="bg-gradient-dark border-radius-lg py-3 pe-1 mb-3">
                      <div class="chart">
                          {{-- ID disesuaikan menjadi chart-reklamasi sesuai script bawah --}}
                          <canvas id="chart-bukaan-lahan" class="chart-canvas" height="300"></canvas>
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

                  <!-- <div class="row mt-2 mb-3">
                      <div class="col-md-6">
                          <label class="text-sm">Filter Tahun</label>
                          <select id="filter-tahun" class="form-control">
                              <option value="">Semua Tahun</option>
                              @foreach(range(date('Y'), 2022) as $year)
                                  <option value="{{ $year }}">{{ $year }}</option>
                              @endforeach
                          </select>
                      </div>

                      <div class="col-md-6">
                          <label class="text-sm">Filter Lokasi</label>
                          <select id="filter-lokasi" class="form-control">
                              <option value="">Semua Lokasi</option>
                              <option value="Lokasi 1">Lokasi 1</option>
                              <option value="Lokasi 2">Lokasi 2</option>
                              <option value="Lokasi 3">Lokasi 3</option>
                              <option value="Lokasi 4">Lokasi 4</option>
                          </select>
                      </div>
                  </div> -->
              </div>
              <div class="card-body p-3">
                  <div class="bg-gradient-dark border-radius-lg py-3 pe-1 mb-3">
                      <div class="chart">
                          {{-- ID disesuaikan menjadi chart-reklamasi sesuai script bawah --}}
                          <canvas id="chart-reklamasi" class="chart-canvas" height="300"></canvas>
                      </div>
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
    let reklamasiChart;

    window.onload = function() {
        // --- 1. CHART STATUS KONTRAK (PIE) ---
        const ctxPie = document.getElementById("chart-pie");
        if (ctxPie) {
            new Chart(ctxPie.getContext("2d"), {
                type: "pie",
                data: {
                    labels: ["Aktif", "Selesai", "Batal"],
                    datasets: [{
                        backgroundColor: ["#11cdef", "#2dce89", "#f5365c"],
                        data: [
                            {{ $statuscount['aktif'] ?? 0 }}, 
                            {{ $statuscount['selesai'] ?? 0 }}, 
                            {{ $statuscount['batal'] ?? 0 }}
                        ],
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });
        }

        // --- 2. CHART RITASE & JAM KERJA ---
        const ctxRitase = document.getElementById("chart-ritase");
        if (ctxRitase) {
            new Chart(ctxRitase.getContext("2d"), {
                type: "bar",
                data: {
                    labels: {!! json_encode($labels ?? []) !!},
                    datasets: [
                        @foreach ($kodealat as $id => $kode)
                        {
                            label: "{{ $kode }}",
                            data: {!! json_encode($chartData[$kode] ?? []) !!},
                            backgroundColor: "{{ ['#11cdef', '#2dce89', '#f5365c', '#ffd600', '#9c27b0'][$loop->index % 5] }}",
                            borderRadius: 6,
                        },
                        @endforeach
                    ]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false,
                    scales: { y: { ticks: { color: "#fff" } }, x: { ticks: { color: "#fff" } } }
                }
            });
        }

        // --- 3. CHART DETAIL REKLAMASI (DENGAN AJAX) ---
        const ctxRek = document.getElementById("chart-reklamasi");
        if (ctxRek) {
            reklamasiChart = new Chart(ctxRek.getContext("2d"), {
                type: "bar",
                data: {
                    labels: {!! json_encode($labelsReklamasi ?? []) !!},
                    datasets: [{
                        label: "Luas Reklamasi (Ha)",
                        backgroundColor: "#2dce89",
                        data: {!! json_encode($luasReklamasi ?? []) !!},
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true, ticks: { color: "#fff" } },
                        x: { ticks: { color: "#fff" } }
                    }
                }
            });

            // Logika AJAX Filter
            const fTahun = document.getElementById('filter-tahun');
            const fLokasi = document.getElementById('filter-lokasi');

            const updateChart = () => {
                const params = new URLSearchParams({
                    tahun: fTahun ? fTahun.value : '',
                    lokasi: fLokasi ? fLokasi.value : ''
                });

                fetch(`/admin/get-reklamasi-chart?${params.toString()}`)
                    .then(res => res.json())
                    .then(data => {
                        reklamasiChart.data.labels = data.labels;
                        reklamasiChart.data.datasets[0].data = data.values;
                        reklamasiChart.update();
                    })
                    .catch(err => console.warn("Filter error: ", err));
            };

            if(fTahun) fTahun.addEventListener('change', updateChart);
            if(fLokasi) fLokasi.addEventListener('change', updateChart);
        }

        // --- 4. CHART LINE (TSS) ---
        const ctxTss = document.getElementById("chart-line-tss");

        if (ctxTss) {
            // Ambil data dari Controller
            const dataTss = {!! json_encode($dataTss ?? []) !!};
            const labelsTssRaw = {!! json_encode($labelstss ?? []) !!};
            const lokasiTss = {!! json_encode($lokasiTss ?? []) !!};
            
            // Gabungkan Tanggal dan Lokasi menjadi array [Tanggal, Lokasi] untuk multiline
            const formattedLabelsTss = labelsTssRaw.map((tgl, index) => [tgl, lokasiTss[index] || '']);

            new Chart(ctxTss.getContext("2d"), {
                type: "line",
                data: {
                    labels: formattedLabelsTss,
                    datasets: [{
                        label: "Kadar TSS (mg/L)",
                        data: dataTss.map(val => parseFloat(val)), // Konversi string ke angka agar garis muncul
                        borderColor: "#2dce89", // Warna Hijau
                        backgroundColor: "rgba(45, 206, 137, 0.1)",
                        fill: true,
                        tension: 0.4, // Style melengkung halus seperti TSS di gambar
                        pointRadius: 4,
                        pointBackgroundColor: "#2dce89",
                        borderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: "rgba(0, 0, 0, 0.05)", drawBorder: false },
                            ticks: { color: "#8898aa" }
                        },
                        x: {
                            grid: { display: false },
                            ticks: {
                                color: "#8898aa",
                                maxRotation: 0, // Tanggal dicetak normal/horizontal
                                autoSkip: true,
                                maxTicksLimit: 8,
                                font: { size: 10 },
                                padding: 10
                            }
                        }
                    }
                }
            });
        }
        // --- 4. CHART LINE (PH AIR) ---
        const ctxPh = document.getElementById("chart-ph-air");

        if (ctxPh) {
            const dataPh = {!! json_encode($dataPh ?? []) !!};
            const labelsPhRaw = {!! json_encode($labelsPh ?? []) !!};
            const lokasiPh = {!! json_encode($lokasiPh ?? []) !!};
            
            // Gabungkan Tanggal dan Lokasi menjadi array [baris1, baris2]
            const formattedLabels = labelsPhRaw.map((tgl, index) => [tgl, lokasiPh[index] || '']);

            new Chart(ctxPh.getContext("2d"), {
                type: "line",
                data: {
                    labels: formattedLabels,
                    datasets: [
                        {
                            label: "Nilai pH",
                            data: dataPh,
                            borderColor: "#5e72e4", // Warna biru (identik TSS)
                            backgroundColor: "rgba(94, 114, 228, 0.2)",
                            fill: true,
                            tension: 0.4, // Membuat garis melengkung (Smooth)
                            pointRadius: 4,
                            pointBackgroundColor: "#5e72e4",
                            borderWidth: 3,
                            z: 10
                        },
                        {
                            label: "Batas Atas",
                            data: Array(formattedLabels.length).fill(9),
                            borderColor: "rgba(245, 54, 92, 0.4)", // Merah transparan
                            borderDash: [5, 5],
                            pointRadius: 0,
                            fill: false
                        },
                        {
                            label: "Batas Bawah",
                            data: Array(formattedLabels.length).fill(3),
                            borderColor: "rgba(251, 99, 64, 0.4)", // Oranye transparan
                            borderDash: [5, 5],
                            pointRadius: 0,
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false } // Sembunyikan legend agar bersih seperti TSS
                    },
                    scales: {
                        y: {
                            min: 0,
                            max: 14,
                            grid: { color: "rgba(0, 0, 0, 0.05)", drawBorder: false },
                            ticks: { stepSize: 2, color: "#8898aa" }
                        },
                        x: {
                            grid: { display: false },
                            ticks: {
                                color: "#8898aa",
                                maxRotation: 0, // Paksa horizontal
                                minRotation: 0,
                                autoSkip: true, // Hindari teks bertumpuk jika data banyak
                                maxTicksLimit: 8, // Batasi jumlah label agar tidak sesak
                                font: {
                                    size: 10,
                                    family: 'Open Sans'
                                },
                                padding: 10
                            }
                        }
                    }
                }
            });
        }

        // --- 5. CHART BUKAAN LAHAN ---
        const ctxBukaan = document.getElementById("chart-bukaan-lahan");

        if (ctxBukaan) {
            new Chart(ctxBukaan.getContext("2d"), {
                type: "bar",
                data: {
                    // Mengambil labels dari controller: ['01 Jan', '02 Jan', ...]
                    labels: {!! json_encode($labelsbukaanlahan ?? []) !!},
                    datasets: [{
                        label: "Luas Bukaan Lahan (Ha)",
                        // Mengambil data luas dari controller
                        data: {!! json_encode($luasbukaanlahan ?? []) !!},
                        backgroundColor: "#11cdef", // Warna biru info
                        borderRadius: 6,
                        maxBarThickness: 35
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false // Sembunyikan legend agar lebih bersih
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ": " + context.raw + " Ha";
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false,
                                display: true,
                                color: "rgba(255, 255, 255, 0.1)", // Garis grid halus jika background gelap
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5]
                            },
                            ticks: {
                                color: "#fff", // Sesuaikan dengan tema chart-bars Anda
                                padding: 10,
                                font: {
                                    size: 13,
                                    family: "Open Sans"
                                }
                            },
                            title: {
                                display: true,
                                text: "Luas (Ha)",
                                color: "#fff",
                                font: {
                                    weight: "bold"
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: "#fff",
                                padding: 10,
                                font: {
                                    size: 12,
                                    family: "Open Sans"
                                }
                            }
                        }
                    }
                }
            });
        }
    }
</script>
@endpush


