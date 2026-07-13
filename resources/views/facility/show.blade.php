<table class="table table-bordered">
    <tr>
        <th>Properti</th>
        <td>{{ $facility->property->name ?? '-' }}</td>
    </tr>
    <tr>
        <th>Nama Fasilitas</th>
        <td>{{ $facility->name }}</td>
    </tr>
    <tr>
        <th>Icon</th>
        <td>
            @if($facility->icon)
                <i class="{{ $facility->icon }} fs-4 me-2"></i> {{ $facility->icon }}
            @else
                <span class="text-muted">Tidak ada icon</span>
            @endif
        </td>
    </tr>
    <tr>
        <th>Deskripsi</th>
        <td>{!! nl2br(e($facility->description ?? '-')) !!}</td>
    </tr>
</table>
