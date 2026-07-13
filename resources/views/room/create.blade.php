<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">

        <form action="{{ route('room.store') }}" method="post" class="form">
            @csrf

            <div class="row g-3 mb-3">
                <div class="col-md-12">
                    
                    <div class="mb-3">
                        <label for="property_id" class="form-label required">Properti</label>
                        <select class="form-select select2-default @error('property_id') is-invalid @enderror" id="property_id" name="property_id" required>
                            <option value="">Pilih Properti</option>
                            @foreach($properties as $property)
                                <option value="{{ $property->id }}" @selected(old('property_id') == $property->id)>{{ $property->name }}</option>
                            @endforeach
                        </select>
                        @error('property_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="room_number" class="form-label required">Nomor Kamar</label>
                        <input class="form-control @error('room_number') is-invalid @enderror" type="text" id="room_number"
                            name="room_number" required value="{{ old('room_number') }}">
                        @error('room_number')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price_per_month" class="form-label required">Harga per Bulan</label>
                        <input class="form-control @error('price_per_month') is-invalid @enderror" type="number" id="price_per_month"
                            name="price_per_month" required min="0" value="{{ old('price_per_month') }}">
                        @error('price_per_month')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label required">Status</label>
                        <select class="form-select select2-default @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="">Pilih Status</option>
                            <option value="Available" @selected(old('status') == 'Available')>Available</option>
                            <option value="Occupied" @selected(old('status') == 'Occupied')>Occupied</option>
                            <option value="Maintenance" @selected(old('status') == 'Maintenance')>Maintenance</option>
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
                <a href="{{ route('room.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>

        </form>

    </div>

</x-app>
