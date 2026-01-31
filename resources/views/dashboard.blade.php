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

    // CHART STATUS DOKUMEN
    @include('chart.status-dokumen')

    // CHART BUKAAN LAHAN DAN REKLAMASI
    @include('chart.bukaanlahan-reklamasi')

    // === CHART REVEGETASI (Jumlah Pohon per Lokasi) ===
    @include('chart.revegetasi')

    // === CHART: RATA-RATA PERTUMBUHAN PER TRIWULAN (MODEL GAMBAR KE-2) ===
    @include('chart.performa-vegetasi')

    // === CHART RENCANA vs REALISASI ===
    @include('chart.rencana-realisasi')

    // === CHART NURSERY ===
    @include('chart.nursery')

    // === CHART RITASE ===
    @include('chart.work-hours')

    // === WASTE WATER MANAGEMENT ===
    @include('chart.waste-water')
});
</script>
@endpush