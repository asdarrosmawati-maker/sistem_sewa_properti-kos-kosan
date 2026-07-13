<table class="table table-bordered">
    <tr>
        <th>Properti</th>
        <td>{{ $gallery->property->name ?? '-' }}</td>
    </tr>
    <tr>
        <th>Kamar</th>
        <td>{{ $gallery->room ? 'Kamar ' . $gallery->room->room_number : 'Umum (Properti)' }}</td>
    </tr>
    <tr>
        <th>Caption</th>
        <td>{{ $gallery->caption ?? '-' }}</td>
    </tr>
    <tr>
        <th>Gambar</th>
        <td>
            @if(Str::startsWith($gallery->image_path, 'dummy/'))
                <img src="{{ asset('niceadmin/img/card.jpg') }}" alt="Gallery" class="img-fluid" style="max-width: 400px;">
            @else
                <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="Gallery" class="img-fluid" style="max-width: 400px;">
            @endif
        </td>
    </tr>
</table>
