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

        <!-- Quick Actions for Tenant -->
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
                        <a href="{{ route('payment.create') }}" class="text-decoration-none">
                            <div class="card border border-primary border-opacity-25 h-100 hover-shadow">
                                <div class="card-body text-center mt-4">
                                    <i class='bx bx-wallet fs-1 text-primary mb-2'></i>
                                    <h6 class="mb-0">Bayar Tagihan</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ $booking ? route('booking.show', $booking) : '#' }}" class="text-decoration-none">
                            <div class="card border border-success border-opacity-25 h-100 hover-shadow">
                                <div class="card-body text-center mt-4">
                                    <i class='bx bx-file fs-1 text-success mb-2'></i>
                                    <h6 class=" mb-0">Kontrak Sewa</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('maintenance.create') }}" class="text-decoration-none">
                            <div class="card border border-info border-opacity-25 h-100 hover-shadow">
                                <div class="card-body text-center mt-4">
                                    <i class='bx bx-wrench fs-1 text-info mb-2'></i>
                                    <h6 class=" mb-0">Komplain/Perbaikan</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('payment.index') }}" class="text-decoration-none">
                            <div class="card border border-warning border-opacity-25 h-100 hover-shadow">
                                <div class="card-body text-center mt-4">
                                    <i class='bx bx-history fs-1 text-warning mb-2'></i>
                                    <h6 class=" mb-0">Riwayat Pembayaran</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Total Users</p>
                                <h2 class="fw-bold mb-0">{{ $totalUsers }}</h2>
                            </div>
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class='bx bx-user fs-2 text-primary'></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-primary bg-opacity-10 border-0 py-2">
                        <small class="text-primary fw-semibold">
                            <i class='bx bx-trending-up me-1'></i>
                            All registered users
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Superadmin</p>
                                <h2 class="fw-bold mb-0">{{ $superadminCount }}</h2>
                            </div>
                            <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                <i class='bx bx-shield fs-2 text-success'></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-success bg-opacity-10 border-0 py-2">
                        <small class="text-success fw-semibold">
                            <i class='bx bx-check-circle me-1'></i>
                            Full access users
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Admin</p>
                                <h2 class="fw-bold mb-0">{{ $adminCount }}</h2>
                            </div>
                            <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                <i class='bx bx-user-check fs-2 text-info'></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-info bg-opacity-10 border-0 py-2">
                        <small class="text-info fw-semibold">
                            <i class='bx bx-user-circle me-1'></i>
                            Standard access users
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0 fw-bold">
                    <i class='bx bx-rocket me-2 text-primary'></i>
                    Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3 mt-2">
                    <div class="col-md-3">
                        <a href="{{ route('user.index') }}" class="text-decoration-none">
                            <div class="card border border-primary border-opacity-25 h-100 hover-shadow">
                                <div class="card-body text-center mt-4">
                                    <i class='bx bx-user-plus fs-1 text-primary mb-2'></i>
                                    <h6 class="mb-0">Manage Users</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('setting.index') }}" class="text-decoration-none">
                            <div class="card border border-success border-opacity-25 h-100 hover-shadow">
                                <div class="card-body text-center mt-4">
                                    <i class='bx bx-cog fs-1 text-success mb-2'></i>
                                    <h6 class=" mb-0">Settings</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('dashboard.show') }}" class="text-decoration-none">
                            <div class="card border border-info border-opacity-25 h-100 hover-shadow">
                                <div class="card-body text-center mt-4">
                                    <i class='bx bx-user-circle fs-1 text-info mb-2'></i>
                                    <h6 class=" mb-0">My Profile</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('dashboard.edit') }}" class="text-decoration-none">
                            <div class="card border border-warning border-opacity-25 h-100 hover-shadow">
                                <div class="card-body text-center mt-4">
                                    <i class='bx bx-edit fs-1 text-warning mb-2'></i>
                                    <h6 class=" mb-0">Edit Profile</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- System Information -->
    <div class="row g-3">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0 fw-bold">
                        <i class='bx bx-info-circle me-2 text-primary'></i>
                        System Information
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0 pt-4">
                        <li class="mb-2">
                            <i class='bx bx-check-circle text-success me-2'></i>
                            <strong>Laravel Version:</strong> {{ app()->version() }}
                        </li>
                        <li class="mb-2">
                            <i class='bx bx-check-circle text-success me-2'></i>
                            <strong>PHP Version:</strong> {{ PHP_VERSION }}
                        </li>
                        <li class="mb-2">
                            <i class='bx bx-check-circle text-success me-2'></i>
                            <strong>Environment:</strong> {{ config('app.env') }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-0 pt-4">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0 fw-bold">
                        <i class='bx bx-user me-2 text-primary'></i>
                        Your Account
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class='bx bx-envelope text-primary me-2'></i>
                            <strong>Email:</strong> {{ Auth::user()->email }}
                        </li>
                        <li class="mb-2">
                            <i class='bx bx-calendar text-primary me-2'></i>
                            <strong>Member Since:</strong> {{ Auth::user()->created_at->format('d M Y') }}
                        </li>
                        <li class="mb-2">
                            <i class='bx bx-time text-primary me-2'></i>
                            <strong>Last Updated:</strong> {{ Auth::user()->updated_at->diffForHumans() }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    @push('modals')
    @endpush

    @push('scripts')
    @endpush

</x-app>
