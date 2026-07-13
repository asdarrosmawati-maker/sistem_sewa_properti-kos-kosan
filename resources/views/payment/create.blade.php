<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">

        <form action="{{ route('payment.store') }}" method="post" class="form" enctype="multipart/form-data">
            @csrf

            <div class="row g-3 mb-3">
                <div class="col-md-12">
                    
                    <div class="mb-3">
                        <label for="booking_id" class="form-label required">Booking</label>
                        <select class="form-select select2-default @error('booking_id') is-invalid @enderror" id="booking_id" name="booking_id" required>
                            <option value="">Pilih Pesanan</option>
                            @foreach($bookings as $booking)
                                <option value="{{ $booking->id }}" @selected(old('booking_id') == $booking->id)>
                                    {{ $booking->user->name ?? '-' }} - Kamar {{ $booking->room->room_number ?? '-' }} (Rp {{ number_format($booking->total_price, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                        @error('booking_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="amount" class="form-label required">Jumlah Bayar</label>
                        <input class="form-control @error('amount') is-invalid @enderror" type="number" id="amount"
                            name="amount" required min="0" value="{{ old('amount') }}">
                        @error('amount')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="payment_date" class="form-label required">Tanggal Bayar</label>
                        <input class="form-control @error('payment_date') is-invalid @enderror" type="date" id="payment_date"
                            name="payment_date" required value="{{ old('payment_date') }}">
                        @error('payment_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="upload" class="form-label required">Bukti Pembayaran</label>
                        <input class="form-control @error('proof_of_payment') is-invalid @enderror" type="file" id="upload"
                            name="proof_of_payment" accept="image/*" required>
                        <img src="{{ asset('niceadmin/img/noprofil.png') }}" class="mt-2" id="preview" width="200" alt="">
                        @error('proof_of_payment')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label required">Status</label>
                        <select class="form-select select2-default @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="">Pilih Status</option>
                            <option value="Pending" @selected(old('status') == 'Pending')>Pending</option>
                            <option value="Verified" @selected(old('status') == 'Verified')>Verified</option>
                            <option value="Rejected" @selected(old('status') == 'Rejected')>Rejected</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="text-end">
                <a href="{{ route('payment.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>

        </form>

    </div>

</x-app>
