<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">

        <form action="{{ route('review.update', $review) }}" method="post" class="form">
            @csrf
            @method('put')

            <div class="row g-3 mb-3">
                <div class="col-md-12">
                    
                    <div class="mb-3">
                        <label for="booking_id" class="form-label required">Pemesanan (Selesai)</label>
                        <select class="form-select select2-default @error('booking_id') is-invalid @enderror" id="booking_id" name="booking_id" required>
                            <option value="">Pilih Pemesanan</option>
                            @foreach($bookings as $booking)
                                <option value="{{ $booking->id }}" @selected(old('booking_id', $review->booking_id) == $booking->id)>
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
                        <label for="rating" class="form-label required">Rating (1-5)</label>
                        <input class="form-control @error('rating') is-invalid @enderror" type="number" id="rating"
                            name="rating" required min="1" max="5" value="{{ old('rating', $review->rating) }}">
                        @error('rating')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="comment" class="form-label required">Komentar</label>
                        <textarea class="form-control @error('comment') is-invalid @enderror" id="comment"
                            name="comment" rows="4" required>{{ old('comment', $review->comment) }}</textarea>
                        @error('comment')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="text-end">
                <a href="{{ route('review.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>

        </form>

    </div>

</x-app>
