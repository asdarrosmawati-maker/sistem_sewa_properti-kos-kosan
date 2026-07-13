<table class="table table-bordered">
    <tr>
        <th>Properti</th>
        <td>{{ $room->property->name ?? '-' }}</td>
    </tr>
    <tr>
        <th>No. Kamar</th>
        <td>{{ $room->room_number }}</td>
    </tr>
    <tr>
        <th>Harga per Bulan</th>
        <td>Rp {{ number_format($room->price_per_month, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Status</th>
        <td>
            @if($room->status == 'Available')
                <span class="badge bg-success">{{ $room->status }}</span>
            @elseif($room->status == 'Occupied')
                <span class="badge bg-danger">{{ $room->status }}</span>
            @else
                <span class="badge bg-warning">{{ $room->status }}</span>
            @endif
        </td>
    </tr>
</table>
