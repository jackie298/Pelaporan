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
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Waste Managenet</p>
                <h5 class="font-weight-bolder mb-0">
                  0
                  {{-- <span class="text-success text-sm font-weight-bolder">+3%</span> --}}
                </h5>
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
                <h5 class="font-weight-bolder mb-0">
                  0
                  {{-- <span class="text-danger text-sm font-weight-bolder">-2%</span> --}}
                </h5>
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
  <div class="row mt-4">
    <div class="col-lg-6 mb-lg-0 mb-4">
      <div class="card z-index-2">
        <div class="card-header pb-0">
          <h6>Grafik Kumulatif</h6>
          <p class="text-sm mb-0">
            <span class="me-3">
              <i class="fa-solid fa-circle text-info"></i>
              <span class="ms-1">Bukaan Lahan</span>
            </span>
            <span>
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
              <canvas id="chart-bars" class="chart-canvas" height="300"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card z-index-2">
        <div class="card-header pb-0">
          <h6>Rencana dan Realisasi Revegetasi</h6>
          <p class="text-sm mb-0">
            <span class="me-3">
              <i class="fa-solid fa-circle text-success"></i>
              <span class="ms-1">Rencana</span>
            </span>
            <span>
              <i class="fa-solid fa-circle text-danger"></i>
              <span class="ms-1">Realisasi</span>
            </span>
          </p>
        </div>
        <div class="card-body p-3">
          <div class="chart">
            <canvas id="chart-line"  height="300"></canvas>
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row mt-4">
    <div class="col-lg-6 mb-lg-0 mb-4">
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
    <div class="col-lg-6">
      <div class="card-body p-3" >

  <div class="text-center mb-4">
    <span class="badge px-4 py-2 fs-6">Tanaman</span>
  </div>

  <div class="table-responsive">
    <table class="table table-borderless align-middle">
      <tbody>

        {{-- Lokasi 1 --}}
        <tr>
          <td colspan="3">
            <span class="badge text-dark px-3 py-2">Lokasi 1</span>
            <span class="badge text-dark ms-2">Luas (Ha)</span>
            <span class="badge text-dark ms-2">Nilai Keberhasilan Reklamasi (%)</span>
          </td>
        </tr>
        <tr>
          <td colspan="3">
            <div class="text-dark fw-bold text-center p-3 rounded">
              Sengon, Angsana, Nangka
            </div>
          </td>
        </tr>

        {{-- Lokasi 2 --}}
        <tr class="mt-3">
          <td colspan="3">
            <span class="badge text-dark px-3 py-2">Lokasi 2</span>
            <span class="badge text-dark ms-2">Luas (Ha)</span>
            <span class="badge text-dark ms-2">Nilai Keberhasilan Reklamasi (%)</span>
          </td>
        </tr>
        <tr>
          <td colspan="3">
            <div class="text-dark fw-bold text-center p-3 rounded">
              Sengon, Rambutan, Durian
            </div>
          </td>
        </tr>

        {{-- Lokasi 3 --}}
        <tr>
          <td colspan="3">
            <span class="badge text-dark px-3 py-2">Lokasi 3</span>
            <span class="badge text-dark ms-2">Luas (Ha)</span>
            <span class="badge text-dark ms-2">Nilai Keberhasilan Reklamasi (%)</span>
          </td>
        </tr>
        <tr>
          <td colspan="3">
            <div class="text-dark fw-bold text-center p-3 rounded" >
              Sengon, Kakao, Matoa
            </div>
          </td>
        </tr>

        {{-- Lokasi 4 --}}
        <tr>
          <td colspan="3">
            <span class="badge text-dark px-3 py-2">Lokasi 4</span>
            <span class="badge text-dark ms-2">Luas (Ha)</span>
            <span class="badge text-dark ms-2">Nilai Keberhasilan Reklamasi (%)</span>
          </td>
        </tr>
        <tr>
          <td colspan="3">
            <div class="text-dark fw-bold text-center p-3 rounded">
              Sengon, Jati, Mahoni
            </div>
          </td>
        </tr>

      </tbody>
    </table>
  </div>

</div>

    </div>
  </div>
  
@endsection
@push('dashboard')
  <script>
    window.onload = function() {
      var ctx = document.getElementById("chart-bars").getContext("2d");

      new Chart(ctx, {
        type: "bar",
        data: {
          labels: ["Bukaan Lahan", "Reklamasi", "Revegetasi"],
          datasets: [
            {
              label: "Grafik Kumulatif",
              data: [8, 12, 16],
              backgroundColor: [
                "#11cdef", // biru
                "#2dce89", // hijau
                "#f5365c"  // merah
              ],
              borderRadius: 6,
              maxBarThickness: 40
            }
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
                text: "Luas (Ha)",
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

      var ctx2 = document.getElementById("chart-line").getContext("2d");

      var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);
      gradientStroke1.addColorStop(1, 'rgba(45,206,137,0.2)');
      gradientStroke1.addColorStop(0.2, 'rgba(45,206,137,0.0)');
      gradientStroke1.addColorStop(0, 'rgba(45,206,137,0)');

      var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);
      gradientStroke2.addColorStop(1, 'rgba(245,54,92,0.2)');
      gradientStroke2.addColorStop(0.2, 'rgba(245,54,92,0.0)');
      gradientStroke2.addColorStop(0, 'rgba(245,54,92,0)');

      new Chart(ctx2, {
        type: "line",
        data: {
          labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          datasets: [
            {
              label: "Rencana",
              tension: 0.4,
              pointRadius: 0,
              borderColor: "#2dce89",
              borderWidth: 3,
              backgroundColor: gradientStroke1,
              fill: true,
              data: [50, 40, 300, 220, 500, 250, 400, 230, 500]
            },
            {
              label: "Realisasi",
              tension: 0.4,
              pointRadius: 0,
              borderColor: "#f5365c",
              borderWidth: 3,
              backgroundColor: gradientStroke2,
              fill: true,
              data: [30, 90, 40, 140, 290, 290, 340, 230, 400]
            }
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
          interaction: {
            intersect: false,
            mode: 'index'
          },
          scales: {
            y: {
              title: {
                display: true,
                text: "Luas (Ha)",
                color: "#000000",
                font: {
                  size: 13,
                  family: "Open Sans",
                  weight: "bold"
                },
                padding: {
                  bottom: 10
                }
              },
              grid: {
                drawBorder: false,
                display: true,
                drawOnChartArea: true,
                drawTicks: false,
                borderDash: [5, 5]
              },
              ticks: {
                padding: 10,
                color: '#000000',
                font: {
                  size: 11,
                  family: "Open Sans"
                }
              }
            },
            x: {
              grid: {
                drawBorder: false,
                display: false
              },
              ticks: {
                color: '#000000',
                padding: 20,
                font: {
                  size: 11,
                  family: "Open Sans"
                }
              }
            }
          }
        }
      });

      var ctx = document.getElementById("chart-bars2").getContext("2d");

      new Chart(ctx, {
        type: "bar",
        data: {
          labels: ["Lokasi 1", "Lokasi 2", "Lokasi 3", "Lokasi 4"],
          datasets: [
            {
              label: "Grafik Kumulatif",
              data: [8, 12, 16, 4],
              backgroundColor: [
                "#11cdef", // biru
                "#2dce89", // hijau
                "#f5365c",  // merah
                "#800080"  // 
              ],
              borderRadius: 6,
              maxBarThickness: 40
            }
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
                text: "Luas (Ha)",
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
    }
  </script>
@endpush

