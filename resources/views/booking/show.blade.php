<table class="table table-bordered">
    <tr>
        <th>Penyewa</th>
        <td>{{ $booking->user->name ?? '-' }}</td>
    </tr>
    <tr>
        <th>Kamar</th>
        <td>Kamar {{ $booking->room->room_number ?? '-' }} ({{ $booking->room->property->name ?? '-' }})</td>
    </tr>
    <tr>
        <th>Tanggal Mulai</th>
        <td>{{ \Carbon\Carbon::parse($booking->start_date)->format('d F Y') }}</td>
    </tr>
    <tr>
        <th>Tanggal Selesai</th>
        <td>{{ \Carbon\Carbon::parse($booking->end_date)->format('d F Y') }}</td>
    </tr>
    <tr>
        <th>Total Harga</th>
        <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Status</th>
        <td>
            @if($booking->status == 'Active')
                <span class="badge bg-success">{{ $booking->status }}</span>
            @elseif($booking->status == 'Pending')
                <span class="badge bg-warning">{{ $booking->status }}</span>
            @elseif($booking->status == 'Rejected')
                <span class="badge bg-danger">{{ $booking->status }}</span>
            @else
                <span class="badge bg-info">{{ $booking->status }}</span>
            @endif
        </td>
    </tr>
</table>
