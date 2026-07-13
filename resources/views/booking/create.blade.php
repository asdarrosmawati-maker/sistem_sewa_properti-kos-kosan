<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">

        <form action="{{ route('booking.store') }}" method="post" class="form">
            @csrf

            <div class="row g-3 mb-3">
                <div class="col-md-12">
                    
                    <div class="mb-3">
                        <label for="user_id" class="form-label required">Penyewa</label>
                        <select class="form-select select2-default @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                            <option value="">Pilih Penyewa</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="room_id" class="form-label required">Kamar</label>
                        <select class="form-select select2-default @error('room_id') is-invalid @enderror" id="room_id" name="room_id" required>
                            <option value="">Pilih Kamar (Properti)</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}" @selected(old('room_id') == $room->id)>
                                    Kamar {{ $room->room_number }} ({{ $room->property->name ?? '-' }}) - Rp {{ number_format($room->price_per_month, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        @error('room_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="start_date" class="form-label required">Tanggal Mulai</label>
                        <input class="form-control @error('start_date') is-invalid @enderror" type="date" id="start_date"
                            name="start_date" required value="{{ old('start_date') }}">
                        @error('start_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="end_date" class="form-label required">Tanggal Selesai</label>
                        <input class="form-control @error('end_date') is-invalid @enderror" type="date" id="end_date"
                            name="end_date" required value="{{ old('end_date') }}">
                        @error('end_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="total_price" class="form-label required">Total Harga</label>
                        <input class="form-control @error('total_price') is-invalid @enderror" type="number" id="total_price"
                            name="total_price" required min="0" value="{{ old('total_price') }}">
                        @error('total_price')
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
                            <option value="Active" @selected(old('status') == 'Active')>Active</option>
                            <option value="Completed" @selected(old('status') == 'Completed')>Completed</option>
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
                <a href="{{ route('booking.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>

        </form>

    </div>

</x-app>
