<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">

        <form action="{{ route('expense.store') }}" method="post" class="form">
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
                        <label for="expense_date" class="form-label required">Tanggal Pengeluaran</label>
                        <input class="form-control @error('expense_date') is-invalid @enderror" type="date" id="expense_date"
                            name="expense_date" required value="{{ old('expense_date', \Carbon\Carbon::now()->format('Y-m-d')) }}">
                        @error('expense_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label required">Deskripsi / Keterangan</label>
                        <input class="form-control @error('description') is-invalid @enderror" type="text" id="description"
                            name="description" required value="{{ old('description') }}" placeholder="Contoh: Tagihan listrik, Gaji penjaga...">
                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="amount" class="form-label required">Nominal Pengeluaran (Rp)</label>
                        <input class="form-control @error('amount') is-invalid @enderror" type="number" id="amount"
                            name="amount" required min="0" value="{{ old('amount') }}">
                        @error('amount')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="text-end">
                <a href="{{ route('expense.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>

        </form>

    </div>

</x-app>
