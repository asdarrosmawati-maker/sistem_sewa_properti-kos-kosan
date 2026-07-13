<table class="table table-bordered">
    <tr>
        <th>Booking</th>
        <td>Kamar {{ $maintenance->booking->room->room_number ?? '-' }} ({{ $maintenance->booking->room->property->name ?? '-' }})</td>
    </tr>
    <tr>
        <th>Pengguna (Tenant)</th>
        <td>{{ $maintenance->user->name ?? '-' }}</td>
    </tr>
    <tr>
        <th>Deskripsi Keluhan</th>
        <td>{!! nl2br(e($maintenance->issue_description)) !!}</td>
    </tr>
    <tr>
        <th>Status Penyelesaian</th>
        <td>
            @if($maintenance->status == 'Resolved')
                <span class="badge bg-success">{{ $maintenance->status }}</span>
            @elseif($maintenance->status == 'Pending')
                <span class="badge bg-danger">{{ $maintenance->status }}</span>
            @else
                <span class="badge bg-warning">{{ $maintenance->status }}</span>
            @endif
        </td>
    </tr>
    <tr>
        <th>Tanggal Lapor</th>
        <td>{{ \Carbon\Carbon::parse($maintenance->created_at)->format('d F Y H:i') }}</td>
    </tr>
</table>
