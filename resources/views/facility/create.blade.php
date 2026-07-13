<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">

        <form action="{{ route('facility.store') }}" method="post" class="form">
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
                        <label for="name" class="form-label required">Nama Fasilitas</label>
                        <input class="form-control @error('name') is-invalid @enderror" type="text" id="name"
                            name="name" required value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="icon" class="form-label">Icon (opsional)</label>
                        <input class="form-control @error('icon') is-invalid @enderror" type="text" id="icon"
                            name="icon" value="{{ old('icon') }}" placeholder="Misal: bx bx-wifi">
                        <small class="text-muted d-block mt-1">Gunakan class dari <a href="https://boxicons.com/" target="_blank">Boxicons</a> atau <a href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icons</a>.</small>
                        @error('icon')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi (opsional)</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                            name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="text-end">
                <a href="{{ route('facility.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>

        </form>

    </div>

</x-app>
