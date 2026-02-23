@extends('layouts.user_type.auth')

@section('content')

{{-- SECTION 1: DOKUMEN KONTRAK & STATUS --}}
<div class="row mt-4">
    <div class="col-lg-7 mb-lg-0 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-header pb-0">
                <h6><i class="fas fa-file-contract text-primary me-2"></i>Rekap Anggaran (Terbaru)</h6>
            </div>
            <div class="card-body p-3">
                <div class="table-responsive p-0" style="max-height: 300px;">
                    <table class="table align-items-center mb-0">
                        <thead class="sticky-top bg-white z-index-1">
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kontrak File</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rekap_anggaran ?? [] as $index => $item)
                                <tr>
                                    <td><p class="text-xs font-weight-bold mb-0 ps-2">{{ $index + 1 }}</p></td>
                                    <td><p class="text-xs font-weight-bold mb-0 text-wrap">{{ $item->nama }}</p></td>
                                    <td class="align-middle text-center">
                                        @if($item->file_kontrak)
                                            <a href="{{ asset('storage/' . $item->file_kontrak) }}" target="_blank" class="btn btn-link text-info px-3 mb-0">
                                                <i class="fa fa-file-pdf text-lg"></i>
                                            </a>
                                        @else
                                            <span class="text-xs text-muted">Tidak ada</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-xs py-4">Data belum tersedia</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card z-index-2 h-100">
            <div class="card-header pb-0">
                <h6><i class="fas fa-chart-pie text-info me-2"></i>Grafik Status Dokumen</h6>
            </div>
            <div class="card-body p-3">
                <div class="chart-container" style="position: relative; height:200px;">
                    <canvas id="chart-status-dokumen"></canvas> {{-- ID diperbaiki --}}
                </div>
                <div class="d-flex flex-wrap justify-content-center mt-3">
                    @foreach(['open' => 'bg-info', 'close' => 'bg-success', 'pending' => 'bg-warning', 'proses finance' => 'bg-primary', 'hold' => 'bg-danger'] as $key => $color)
                        <span class="badge badge-dot me-3 text-start">
                            <i class="{{ $color }}" style="width: 10px; height: 10px; border-radius: 50%; display: inline-block; vertical-align: middle;"></i>
                            <span class="text-dark text-xs text-capitalize ms-1" style="vertical-align: middle;">
                                {{ $key }}: {{ $statuscount[$key] ?? 0 }}
                            </span>
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SECTION 2: COMPLIANCE --}}
<div class="row mt-4">
    <div class="col-lg-12 mb-4">
        <div class="card z-index-2">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6>Compliance Overview</h6>
                <a href="{{ route('compliance') }}" class="btn btn-outline-primary btn-sm mb-0">Lihat Semua</a>
            </div>
            <div class="card-body p-3">
                <div class="table-responsive p-0" style="max-height: 300px;">
                    <table class="table align-items-center mb-0">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pelapor / Dept</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Lokasi</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Severity</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Visual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($compliances as $index => $item)
                            <tr>
                                <td class="align-middle px-3">
                                    <span class="text-secondary text-xs font-weight-bold">{{ $index + 1 }}</span>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $item->Nama_pelapor }}</h6>
                                            <p class="text-xs text-secondary mb-0">{{ $item->Departemen }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-bold mb-0 text-wrap" style="max-width: 150px;">{{ $item->Lokasi }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    @php
                                        $statusColors = [
                                            'open' => 'info',
                                            'pending' => 'warning',
                                            'resolved' => 'success',
                                            'escalated' => 'danger'
                                        ];
                                        $currentStatus = strtolower($item->Status);
                                        $color = $statusColors[$currentStatus] ?? 'secondary';
                                    @endphp
                                    <span class="badge badge-sm bg-gradient border border-{{ $color }} text-{{ $color }}">
                                        {{ $item->Status }}
                                    </span>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    @php
                                        $severityColors = [
                                            'critical' => 'danger',
                                            'high' => 'warning',
                                            'medium' => 'info',
                                            'low' => 'secondary'
                                        ];
                                        $currentSeverity = strtolower($item->Tingkat_keparahan);
                                        $sevColor = $severityColors[$currentSeverity] ?? 'secondary';
                                    @endphp
                                    <span class="badge badge-sm bg-gradient-{{ $sevColor }}">
                                        {{ $item->Tingkat_keparahan }}
                                    </span>
                                </td>
                                <td class="align-middle text-center">
                                    @if($item->file_dokumentasi && count((array)$item->file_dokumentasi) > 0)
                                        <button class="btn btn-link text-info text-gradient px-3 mb-0 detail-visual-btn" 
                                                data-fotos='@json($item->file_dokumentasi)'>
                                            <i class="fas fa-camera me-1"></i> Lihat
                                        </button>
                                    @else
                                        <span class="text-xxs text-muted font-italic">Tidak ada foto</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-folder-open text-secondary mb-2" style="font-size: 2rem;"></i>
                                        <p class="text-sm text-secondary">Belum ada data kepatuhan yang tercatat.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Grafik Compliance dipindah ke baris baru agar tidak terlalu sempit --}}
    <div class="col-lg-6 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-header pb-0">
                <h6><i class="fas fa-tasks text-primary me-2"></i>Status Compliance</h6>
            </div>
            <div class="card-body p-3">
                <div class="chart-container" style="position: relative; height:300px;">
                    <canvas id="chart-status-compliance"></canvas>
                </div>
                <div class="d-flex flex-wrap justify-content-center mt-3">
                    @foreach(['open' => '#11cdef', 'pending' => '#ffd400', 'resolved' => '#2dce89', 'escalated' => '#f5365c'] as $key => $hex)
                        <span class="badge badge-dot me-3">
                            <i style="background-color: {{ $hex }}; width: 10px; height: 10px; border-radius: 50%; display: inline-block;"></i>
                            <span class="text-dark text-xs text-capitalize ms-1">{{ $key }}: {{ $complianceCounts[$key] ?? 0 }}</span>
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-header pb-0">
                <h6><i class="fas fa-exclamation-triangle text-danger me-2"></i>Tingkat Keparahan</h6>
            </div>
            <div class="card-body p-3 text-center">
                <div class="chart-container" style="position: relative; height:300px; width:100%; padding-top: 20px;">
                    <canvas id="chart-severity-compliance" height="250"></canvas>
                </div>
                <div class="d-flex flex-wrap justify-content-center mt-3">
                    @foreach(['critical' => '#f5365c', 'high' => '#fb6340', 'medium' => '#11cdef', 'low' => '#adb5bd'] as $key => $hex)
                        <span class="badge badge-dot me-3">
                            <i style="background-color: {{ $hex }}; width: 10px; height: 10px; border-radius: 50%; display: inline-block;"></i>
                            <span class="text-dark text-xs text-capitalize ms-1">{{ $key }}: {{ $severityStats[$key] ?? 0 }}</span>
                        </span>
                    @endforeach
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
                <h6>Rencana dan Realisasi Tahun {{ date('Y') }}</h6>
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
@php
    $palette = [
        "#00d2ff", // Electric Blue
        "#33ff00", // Neon Green
        "#ff9d00", // Bright Orange
        "#f06292", // Hot Pink
        "#00e5ff", // Bright Cyan
        "#ffff00", // Vivid Yellow
        "#a389f4", // Light Purple
        "#ffffff"  // White
    ];
@endphp
<div class="col-lg-12 mb-4">
    <div class="card z-index-2">
        <div class="card-header pb-0">
            <h6>Ritase dan Jam Kerja Alat</h6>
            <h6 class="text-primary">Kategori: EXCAVATOR (Main Equipment)</h6>
            <p class="text-sm mb-0">
                @foreach ($grupExca as $item)
                    <span class="me-3">
                        <i class="fa-solid fa-circle" style="color: {{ $palette[$loop->index % count($palette)] }}"></i>
                        <span class="ms-1">{{ $item->kode }}</span>
                    </span>
                @endforeach
            </p>
        </div>
        <div class="card-body p-3">
            <div class="bg-gradient-dark border-radius-lg py-3 pe-1 mb-3">
                <div class="chart">
                    <canvas id="chart-exca-murni" class="chart-canvas" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-12 mb-4">
    <div class="card z-index-2">
        <div class="card-header pb-0">
            <h6>Ritase dan Jam Kerja Alat</h6>
            <h6 class="text-info">Kategori: EXCA LA, BREAKER & BULDOZER</h6>
            <p class="text-sm mb-0">
                @foreach ($grupPendukung as $item)
                    <span class="me-3">
                        <i class="fa-solid fa-circle" style="color: {{ $palette[$loop->index % count($palette)] }}"></i>
                        <span class="ms-1">{{ $item->kode }}</span>
                    </span>
                @endforeach
            </p>
        </div>
        <div class="card-body p-3">
            <div class="bg-gradient-dark border-radius-lg py-3 pe-1 mb-3">
                <div class="chart">
                    <canvas id="chart-pendukung" class="chart-canvas" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-12 mb-4">
    <div class="card z-index-2">
        <div class="card-header pb-0">
            <h6>Ritase dan Jam Kerja Alat</h6>
            <h6 class="text-warning">Kategori: DUMP TRUCK</h6>
            <p class="text-sm mb-0">
                @foreach ($grupDT as $item)
                    <span class="me-3">
                        <i class="fa-solid fa-circle" style="color: {{ $palette[$loop->index % count($palette)] }}"></i>
                        <span class="ms-1">{{ $item->kode }}</span>
                    </span>
                @endforeach
            </p>
        </div>
        <div class="card-body p-3">
            <div class="bg-gradient-dark border-radius-lg py-3 pe-1 mb-3">
                <div class="chart">
                    <canvas id="chart-dt" class="chart-canvas" height="300"></canvas>
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

    // CHART MENU COMPLIANCE
    @include('chart.compliace')

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