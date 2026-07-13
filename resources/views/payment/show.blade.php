<table class="table table-bordered">
    <tr>
        <th>Booking</th>
        <td>{{ $payment->booking->user->name ?? '-' }} (Kamar {{ $payment->booking->room->room_number ?? '-' }})</td>
    </tr>
    <tr>
        <th>Tanggal Bayar</th>
        <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d F Y') }}</td>
    </tr>
    <tr>
        <th>Jumlah Bayar</th>
        <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Status</th>
        <td>
            @if($payment->status == 'Verified')
                <span class="badge bg-success">{{ $payment->status }}</span>
            @elseif($payment->status == 'Pending')
                <span class="badge bg-warning">{{ $payment->status }}</span>
            @elseif($payment->status == 'Rejected')
                <span class="badge bg-danger">{{ $payment->status }}</span>
            @else
                <span class="badge bg-info">{{ $payment->status }}</span>
            @endif
        </td>
    </tr>
    <tr>
        <th>Bukti Pembayaran</th>
        <td>
            @if($payment->proof_of_payment)
                <img src="{{ asset('storage/' . $payment->proof_of_payment) }}" alt="Bukti Pembayaran" class="img-fluid" style="max-width: 300px;">
            @else
                <span class="text-muted">Tidak ada bukti pembayaran</span>
            @endif
        </td>
    </tr>
</table>
