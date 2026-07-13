<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row g-4">
        <!-- Announcement 1 -->
        <div class="col-md-12">
            <div class="card shadow-sm border-0 border-start border-primary border-5">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-primary m-0">
                            <i class='bx bx-info-circle me-2'></i>
                            Tata Tertib Kos
                        </h5>
                        <span class="badge bg-primary rounded-pill">Penting</span>
                    </div>
                    <p class="text-muted mb-3">
                        Diberitahukan kepada seluruh tenant, mohon untuk selalu mematuhi tata tertib kos demi kenyamanan bersama. Jam malam berlaku mulai pukul 23:00 WIB. Dilarang membawa tamu menginap tanpa izin dari pemilik kos.
                    </p>
                    <div class="text-end">
                        <small class="text-muted">
                            <i class='bx bx-time me-1'></i>
                            Dipublikasikan: 1 Januari 2026
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Announcement 2 -->
        <div class="col-md-12">
            <div class="card shadow-sm border-0 border-start border-warning border-5">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-warning m-0">
                            <i class='bx bx-bulb me-2'></i>
                            Jadwal Kebersihan Area Umum
                        </h5>
                        <span class="badge bg-warning text-dark rounded-pill">Info</span>
                    </div>
                    <p class="text-muted mb-3">
                        Kegiatan bersih-bersih area umum (ruang tamu, dapur, lorong) akan dilakukan setiap hari Minggu pagi oleh petugas kebersihan. Mohon kerjasamanya untuk tidak meletakkan barang pribadi di area umum agar proses pembersihan berjalan lancar.
                    </p>
                    <div class="text-end">
                        <small class="text-muted">
                            <i class='bx bx-time me-1'></i>
                            Dipublikasikan: 15 Februari 2026
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Announcement 3 -->
        <div class="col-md-12">
            <div class="card shadow-sm border-0 border-start border-success border-5">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-success m-0">
                            <i class='bx bx-money me-2'></i>
                            Pembayaran Tagihan Bulanan
                        </h5>
                        <span class="badge bg-success rounded-pill">Pengingat</span>
                    </div>
                    <p class="text-muted mb-3">
                        Mohon perhatikan tenggat waktu pembayaran sewa dan tagihan listrik setiap bulannya agar terhindar dari denda atau pemutusan fasilitas. Semua pembayaran harap diunggah melalui menu <strong>Tagihan</strong> pada sistem ini.
                    </p>
                    <div class="text-end">
                        <small class="text-muted">
                            <i class='bx bx-time me-1'></i>
                            Dipublikasikan: 1 Maret 2026
                        </small>
                    </div>
                </div>
            </div>
        </div>

    </div>

</x-app>
