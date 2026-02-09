@extends('layouts.user_type.auth')

@section('content')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">
                            <i class="fas fa-calendar-alt me-2"></i>
                            Detail Rencana Revegetasi {{ $data->tahun }}
                        </h5>
                        <p class="text-sm mb-0 text-muted">Target Bulanan per Tahun</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('rencana-revegetasi.edit', $data->id) }}" class="btn bg-gradient-info btn-sm">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <a href="{{ route('rencana-revegetasi') }}" class="btn bg-gradient-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Informasi Umum -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="info-box p-3 bg-gradient-primary text-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0 opacity-8">Tahun Rencana</h6>
                                        <h3 class="mb-0">{{ $data->tahun }}</h3>
                                    </div>
                                    <div class="icon-box bg-white p-3 rounded-circle">
                                        <i class="fas fa-calendar-check fa-2x text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box p-3 bg-gradient-success text-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0 opacity-8">Total Target</h6>
                                        <h3 class="mb-0">{{ number_format($data->total_target) }} <small class="text-xs">pcs</small></h3>
                                    </div>
                                    <div class="icon-box bg-white p-3 rounded-circle">
                                        <i class="fas fa-seedling fa-2x text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lokasi -->
                    @if($data->lokasi)
                    <div class="card mb-4 border-left-success">
                        <div class="card-body">
                            <h6 class="text-uppercase text-secondary text-xs font-weight-bolder mb-2">
                                <i class="fas fa-map-marker-alt me-2"></i>Lokasi
                            </h6>
                            <p class="mb-0 text-dark font-weight-bold">{{ $data->lokasi }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Target Bulanan Detail -->
                    <div class="card mb-4">
                        <div class="card-header bg-gradient-info">
                            <h6 class="mb-0 text-white">
                                <i class="fas fa-chart-bar me-2"></i>Target Bulanan Detail
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-items-center">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Bulan</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Target Bibit</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Progress</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($daftarBulan as $key => $bulan)
                                            @php
                                                $target = $targetBulanan[$key] ?? 0;
                                                $persentase = $data->total_target > 0 ? round(($target / $data->total_target) * 100, 1) : 0;
                                            @endphp
                                            <tr>
                                                <td class="ps-2">
                                                    <div class="d-flex align-items-center">
                                                        <div class="icon icon-shape bg-gradient-{{ $persentase > 0 ? 'success' : 'secondary' }} shadow text-center me-3">
                                                            <i class="fas fa-calendar-alt text-white opacity-10"></i>
                                                        </div>
                                                        <div class="d-flex flex-column">
                                                            <h6 class="mb-0 text-sm font-weight-bold">{{ $bulan }}</h6>
                                                            @if($target > 0)
                                                                <small class="text-success font-weight-bold">
                                                                    <i class="fas fa-check-circle me-1"></i>Aktif
                                                                </small>
                                                            @else
                                                                <small class="text-muted">
                                                                    <i class="fas fa-minus-circle me-1"></i>Belum ada target
                                                                </small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-gradient-{{ $target > 0 ? 'success' : 'secondary' }} font-weight-bold">
                                                        {{ $target > 0 ? number_format($target) : '-' }} pcs
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    @if($target > 0)
                                                        <div class="progress" style="height: 8px;">
                                                            <div class="progress-bar bg-gradient-success" role="progressbar" style="width: {{ $persentase }}%;" aria-valuenow="{{ $persentase }}" aria-valuemin="0" aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                        <small class="text-xs text-muted mt-1">{{ $persentase }}% dari total</small>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Ringkasan -->
                    <div class="card">
                        <div class="card-header bg-gradient-warning">
                            <h6 class="mb-0 text-white">
                                <i class="fas fa-info-circle me-2"></i>Ringkasan
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="border p-3 rounded">
                                        <h6 class="text-uppercase text-secondary text-xs font-weight-bolder mb-2">
                                            <i class="fas fa-calculator text-info me-1"></i>Rata-rata/Bulan
                                        </h6>
                                        <h4 class="mb-0 text-dark font-weight-bold">
                                            {{ number_format($data->rata_rata_bulanan) }} pcs
                                        </h4>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="border p-3 rounded">
                                        <h6 class="text-uppercase text-secondary text-xs font-weight-bolder mb-2">
                                            <i class="fas fa-chart-line text-success me-1"></i>Bulan Tertinggi
                                        </h6>
                                        @php
                                            $bulanTertinggi = collect($targetBulanan)->sortDesc()->first();
                                            $namaBulanTertinggi = array_search($bulanTertinggi, $targetBulanan);
                                        @endphp
                                        <h4 class="mb-0 text-dark font-weight-bold">
                                            {{ number_format($bulanTertinggi) }} pcs
                                        </h4>
                                        <small class="text-muted">{{ $daftarBulan[$namaBulanTertinggi] ?? '-' }}</small>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="border p-3 rounded">
                                        <h6 class="text-uppercase text-secondary text-xs font-weight-bolder mb-2">
                                            <i class="fas fa-clock text-secondary me-1"></i>Dibuat
                                        </h6>
                                        <h6 class="mb-0 text-dark">
                                            {{ $data->created_at->format('d M Y H:i') }}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection