<table class="table table-bordered">
    <tr>
        <th>Properti</th>
        <td>{{ $expense->property->name ?? '-' }}</td>
    </tr>
    <tr>
        <th>Tanggal Pengeluaran</th>
        <td>{{ \Carbon\Carbon::parse($expense->expense_date)->format('d F Y') }}</td>
    </tr>
    <tr>
        <th>Deskripsi / Keterangan</th>
        <td>{{ $expense->description }}</td>
    </tr>
    <tr>
        <th>Nominal Pengeluaran</th>
        <td class="text-danger fw-bold">Rp {{ number_format($expense->amount, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Tanggal Input Sistem</th>
        <td>{{ \Carbon\Carbon::parse($expense->created_at)->format('d F Y H:i:s') }}</td>
    </tr>
</table>
