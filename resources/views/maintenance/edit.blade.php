<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">

        <form action="{{ route('maintenance.update', $maintenance) }}" method="post" class="form">
            @csrf
            @method('put')

            <div class="row g-3 mb-3">
                <div class="col-md-12">
                    
                    <div class="mb-3">
                        <label class="form-label">Pemesanan</label>
                        <input type="text" class="form-control" disabled value="Kamar {{ $maintenance->booking->room->room_number ?? '-' }} ({{ $maintenance->booking->room->property->name ?? '-' }})">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi Keluhan</label>
                        <textarea class="form-control" rows="4" disabled>{{ $maintenance->issue_description }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label required">Status Penyelesaian</label>
                        <select class="form-select select2-default @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="Pending" @selected(old('status', $maintenance->status) == 'Pending')>Pending (Menunggu)</option>
                            <option value="In Progress" @selected(old('status', $maintenance->status) == 'In Progress')>In Progress (Sedang Dikerjakan)</option>
                            <option value="Resolved" @selected(old('status', $maintenance->status) == 'Resolved')>Resolved (Selesai)</option>
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
                <a href="{{ route('maintenance.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Status</button>
            </div>

        </form>

    </div>

</x-app>
