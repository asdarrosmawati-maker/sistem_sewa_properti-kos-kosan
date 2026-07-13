<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">

        <form action="{{ route('maintenance.store') }}" method="post" class="form">
            @csrf

            <div class="row g-3 mb-3">
                <div class="col-md-12">
                    
                    <div class="mb-3">
                        <label for="booking_id" class="form-label required">Pemesanan (Aktif/Pending)</label>
                        <select class="form-select select2-default @error('booking_id') is-invalid @enderror" id="booking_id" name="booking_id" required>
                            <option value="">Pilih Pemesanan</option>
                            @foreach($bookings as $booking)
                                <option value="{{ $booking->id }}" @selected(old('booking_id') == $booking->id)>
                                    {{ $booking->user->name ?? '-' }} - Kamar {{ $booking->room->room_number ?? '-' }} ({{ \Carbon\Carbon::parse($booking->start_date)->format('M Y') }})
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
                        <label for="issue_description" class="form-label required">Deskripsi Keluhan</label>
                        <textarea class="form-control @error('issue_description') is-invalid @enderror" id="issue_description"
                            name="issue_description" rows="4" required placeholder="Jelaskan detail kerusakan atau keluhan Anda di sini...">{{ old('issue_description') }}</textarea>
                        @error('issue_description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="text-end">
                <a href="{{ route('maintenance.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Kirim Laporan</button>
            </div>

        </form>

    </div>

</x-app>
