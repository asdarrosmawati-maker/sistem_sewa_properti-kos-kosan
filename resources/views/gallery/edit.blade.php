<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">

        <form action="{{ route('gallery.update', $gallery) }}" method="post" class="form" enctype="multipart/form-data">
            @csrf
            @method('put')

            <div class="row g-3 mb-3">
                <div class="col-md-12">
                    
                    <div class="mb-3">
                        <label for="property_id" class="form-label required">Properti</label>
                        <select class="form-select select2-default @error('property_id') is-invalid @enderror" id="property_id" name="property_id" required>
                            <option value="">Pilih Properti</option>
                            @foreach($properties as $property)
                                <option value="{{ $property->id }}" @selected(old('property_id', $gallery->property_id) == $property->id)>{{ $property->name }}</option>
                            @endforeach
                        </select>
                        @error('property_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="room_id" class="form-label">Kamar (Opsional)</label>
                        <select class="form-select select2-default @error('room_id') is-invalid @enderror" id="room_id" name="room_id">
                            <option value="">Pilih Kamar (Jika foto khusus kamar)</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}" @selected(old('room_id', $gallery->room_id) == $room->id)>Kamar {{ $room->room_number }} ({{ $room->property->name ?? '-' }})</option>
                            @endforeach
                        </select>
                        <small class="text-muted d-block mt-1">Biarkan kosong jika foto ini untuk tampilan umum properti (misal: tampak depan, fasilitas umum).</small>
                        @error('room_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Ganti Gambar (Opsional)</label>
                        <input class="form-control @error('image') is-invalid @enderror" type="file" id="image"
                            name="image" accept="image/*">
                        <small class="text-muted d-block mt-1">Pilih gambar baru jika ingin mengganti gambar lama. Maksimal 2MB.</small>
                        
                        <div class="mt-2">
                            <p class="mb-1">Gambar saat ini:</p>
                            @if(Str::startsWith($gallery->image_path, 'dummy/'))
                                <img src="{{ asset('niceadmin/img/card.jpg') }}" alt="Gallery" width="200" class="img-thumbnail">
                            @else
                                <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="Gallery" width="200" class="img-thumbnail">
                            @endif
                        </div>

                        @error('image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="caption" class="form-label">Caption (Opsional)</label>
                        <input class="form-control @error('caption') is-invalid @enderror" type="text" id="caption"
                            name="caption" value="{{ old('caption', $gallery->caption) }}" placeholder="Deskripsi singkat gambar...">
                        @error('caption')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="text-end">
                <a href="{{ route('gallery.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>

        </form>

    </div>

</x-app>
