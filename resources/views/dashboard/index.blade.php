<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <!-- Welcome Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="fw-bold mb-3">
                        <i class='bx bx-smile text-primary me-2'></i>
                        Selamat Datang, {{ Auth::user()->name }}!
                    </h3>
                    <p class="text-muted mb-0">
                        Anda login sebagai <span class="badge bg-primary">{{ Auth::user()->role }}</span>
                    </p>
                    <p class="text-muted mt-2">
                        <i class='bx bx-time-five me-1'></i>
                        {{ now()->isoFormat('dddd, D MMMM YYYY - HH:mm') }}
                    </p>
                </div>
                <div class="col-md-4 text-center">
                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('niceadmin/img/noprofil.png') }}"
                        alt="Avatar" class="img-fluid rounded-circle border border-3 border-primary"
                        style="max-width: 150px;">
                </div>
            </div>
        </div>
    </div>

    @if (Auth::user()->role === 'Tenant')
        <!-- Statistics Cards for Tenant -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Status Kamar</p>
                                <h4 class="fw-bold mb-0">
                                    {{ $booking ? 'Kamar ' . ($booking->room->room_number ?? '-') : 'Belum Ada Kamar' }}
                                </h4>
                                @if($booking)
                                    <span class="badge bg-{{ $booking->status == 'Active' ? 'success' : ($booking->status == 'Pending' ? 'warning' : 'secondary') }} mt-2">
                                        {{ $booking->status }}
                                    </span>
                                @endif
                            </div>
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class='bx bx-bed fs-2 text-primary'></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-primary bg-opacity-10 border-0 py-2">
                        <small class="text-primary fw-semibold">
                            <i class='bx bx-building-house me-1'></i>
                            {{ $booking->room->property->name ?? 'Properti Kos' }}
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Tagihan Bulan Ini</p>
                                <h4 class="fw-bold mb-0">
                                    {{ $latestPayment ? 'Rp ' . number_format($latestPayment->amount, 0, ',', '.') : 'Belum Ada Tagihan' }}
                                </h4>
                                @if($latestPayment)
                                    <span class="badge bg-{{ $latestPayment->status == 'Verified' ? 'success' : ($latestPayment->status == 'Pending' ? 'warning' : 'danger') }} mt-2">
                                        {{ $latestPayment->status == 'Verified' ? 'Lunas' : ($latestPayment->status == 'Pending' ? 'Menunggu Verifikasi' : 'Belum Bayar') }}
                                    </span>
                                @endif
                            </div>
                            <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                <i class='bx bx-money fs-2 text-success'></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-success bg-opacity-10 border-0 py-2">
                        <small class="text-success fw-semibold">
                            <i class='bx bx-calendar me-1'></i>
                            Jatuh Tempo: {{ $latestPayment ? \Carbon\Carbon::parse($latestPayment->payment_date)->format('d M Y') : '-' }}
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Sisa Masa Sewa</p>
                                <h4 class="fw-bold mb-0">
                                    @if($booking && $booking->end_date)
                                        {{ \Carbon\Carbon::parse($booking->end_date)->diffInDays(now()) }} Hari
                                    @else
                                        -
                                    @endif
                                </h4>
                            </div>
                            <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                <i class='bx bx-time fs-2 text-info'></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-info bg-opacity-10 border-0 py-2">
                        <small class="text-info fw-semibold">
                            <i class='bx bx-calendar-event me-1'></i>
                            {{ $booking ? \Carbon\Carbon::parse($booking->start_date)->format('d M Y') . ' s/d ' . \Carbon\Carbon::parse($booking->end_date)->format('d M Y') : '-' }}
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-8">
                <!-- Payment History Chart for Tenant -->
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0 fw-bold">
                            <i class='bx bx-bar-chart-alt-2 me-2 text-primary'></i>
                            Riwayat Pembayaran (6 Bulan Terakhir)
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="tenantPaymentChart"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <!-- Quick Actions for Tenant -->
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0 fw-bold">
                            <i class='bx bx-rocket me-2 text-primary'></i>
                            Aksi Cepat
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mt-2">
                            <div class="col-12">
                                <a href="{{ route('payment.create') }}" class="text-decoration-none">
                                    <div class="card border border-primary border-opacity-25 hover-shadow">
                                        <div class="card-body d-flex align-items-center p-3">
                                            <i class='bx bx-wallet fs-2 text-primary me-3'></i>
                                            <h6 class="mb-0 text-dark">Bayar Tagihan</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-12">
                                <a href="{{ $booking ? route('booking.show', $booking) : '#' }}" class="text-decoration-none">
                                    <div class="card border border-success border-opacity-25 hover-shadow">
                                        <div class="card-body d-flex align-items-center p-3">
                                            <i class='bx bx-file fs-2 text-success me-3'></i>
                                            <h6 class=" mb-0 text-dark">Kontrak Sewa</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-12">
                                <a href="{{ route('maintenance.create') }}" class="text-decoration-none">
                                    <div class="card border border-info border-opacity-25 hover-shadow">
                                        <div class="card-body d-flex align-items-center p-3">
                                            <i class='bx bx-wrench fs-2 text-info me-3'></i>
                                            <h6 class=" mb-0 text-dark">Komplain/Perbaikan</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    @else
        <!-- Statistics Cards for Admin/Superadmin -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Total Properti</p>
                                <h2 class="fw-bold mb-0">{{ $totalProperties }}</h2>
                            </div>
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class='bx bx-building-house fs-2 text-primary'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Total Kamar</p>
                                <h2 class="fw-bold mb-0">{{ $totalRooms }}</h2>
                            </div>
                            <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                <i class='bx bx-bed fs-2 text-info'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Kamar Terisi</p>
                                <h2 class="fw-bold mb-0">{{ $occupiedRooms }}</h2>
                            </div>
                            <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                <i class='bx bx-key fs-2 text-success'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Total Pendapatan</p>
                                <h4 class="fw-bold mb-0">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h4>
                            </div>
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                <i class='bx bx-money fs-2 text-warning'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="row g-4 mb-4">
            <div class="col-md-8">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0 fw-bold">
                            <i class='bx bx-line-chart me-2 text-primary'></i>
                            Tren Pendapatan (6 Bulan Terakhir)
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="revenueChart"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0 fw-bold">
                            <i class='bx bx-pie-chart-alt-2 me-2 text-primary'></i>
                            Status Kamar
                        </h5>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <div id="roomStatusChart"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0 fw-bold">
                    <i class='bx bx-rocket me-2 text-primary'></i>
                    Aksi Cepat
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3 mt-2">
                    <div class="col-md-3">
                        <a href="{{ route('property.index') }}" class="text-decoration-none">
                            <div class="card border border-primary border-opacity-25 h-100 hover-shadow">
                                <div class="card-body text-center mt-4">
                                    <i class='bx bx-building-house fs-1 text-primary mb-2'></i>
                                    <h6 class="mb-0 text-dark">Kelola Properti</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('payment.index') }}" class="text-decoration-none">
                            <div class="card border border-success border-opacity-25 h-100 hover-shadow">
                                <div class="card-body text-center mt-4">
                                    <i class='bx bx-money fs-1 text-success mb-2'></i>
                                    <h6 class=" mb-0 text-dark">Verifikasi Pembayaran</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('booking.index') }}" class="text-decoration-none">
                            <div class="card border border-info border-opacity-25 h-100 hover-shadow">
                                <div class="card-body text-center mt-4">
                                    <i class='bx bx-book-content fs-1 text-info mb-2'></i>
                                    <h6 class=" mb-0 text-dark">Kelola Sewa</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('setting.index') }}" class="text-decoration-none">
                            <div class="card border border-warning border-opacity-25 h-100 hover-shadow">
                                <div class="card-body text-center mt-4">
                                    <i class='bx bx-cog fs-1 text-warning mb-2'></i>
                                    <h6 class=" mb-0 text-dark">Pengaturan Sistem</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            @if (Auth::user()->role === 'Tenant')
                @if(isset($chartLabels) && isset($chartData) && count($chartData) > 0)
                new ApexCharts(document.querySelector("#tenantPaymentChart"), {
                    series: [{
                        name: 'Pembayaran',
                        data: {!! json_encode($chartData) !!}
                    }],
                    chart: {
                        height: 300,
                        type: 'bar',
                        toolbar: {
                            show: false
                        }
                    },
                    colors: ['#4154f1'],
                    plotOptions: {
                        bar: {
                            borderRadius: 4,
                            horizontal: false,
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    xaxis: {
                        categories: {!! json_encode($chartLabels) !!},
                    },
                    yaxis: {
                        labels: {
                            formatter: function (value) {
                                return "Rp " + new Intl.NumberFormat('id-ID').format(value);
                            }
                        }
                    }
                }).render();
                @else
                document.querySelector("#tenantPaymentChart").innerHTML = "<p class='text-muted text-center mt-4'>Belum ada riwayat pembayaran</p>";
                @endif
            @else
                // Revenue Trend Chart
                new ApexCharts(document.querySelector("#revenueChart"), {
                    series: [{
                        name: 'Pendapatan',
                        data: {!! json_encode($revenueData ?? []) !!}
                    }],
                    chart: {
                        height: 300,
                        type: 'area',
                        toolbar: {
                            show: false
                        }
                    },
                    colors: ['#2eca6a'],
                    fill: {
                        type: "gradient",
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.3,
                            opacityTo: 0.4,
                            stops: [0, 90, 100]
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 2
                    },
                    xaxis: {
                        categories: {!! json_encode($revenueLabels ?? []) !!},
                    },
                    yaxis: {
                        labels: {
                            formatter: function (value) {
                                return "Rp " + new Intl.NumberFormat('id-ID').format(value);
                            }
                        }
                    }
                }).render();

                // Room Status Chart
                new ApexCharts(document.querySelector("#roomStatusChart"), {
                    series: [{{ $occupiedRooms ?? 0 }}, {{ $availableRooms ?? 0 }}],
                    chart: {
                        height: 300,
                        type: 'donut',
                    },
                    labels: ['Terisi', 'Tersedia'],
                    colors: ['#ff771d', '#4154f1'],
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '70%',
                                labels: {
                                    show: true,
                                    name: {
                                        show: true,
                                    },
                                    value: {
                                        show: true,
                                    },
                                    total: {
                                        show: true,
                                        showAlways: true,
                                        label: 'Total Kamar',
                                        formatter: function (w) {
                                            return {{ $totalRooms ?? 0 }}
                                        }
                                    }
                                }
                            }
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    legend: {
                        position: 'bottom'
                    }
                }).render();
            @endif
        });
    </script>
    @endpush

</x-app>
