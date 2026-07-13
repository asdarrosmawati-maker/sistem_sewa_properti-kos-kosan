<table class="table table-bordered">
    <tr>
        <th>Nama Properti</th>
        <td>{{ $property->name }}</td>
    </tr>
    <tr>
        <th>Pemilik</th>
        <td>{{ $property->user->name ?? '-' }}</td>
    </tr>
    <tr>
        <th>Alamat</th>
        <td>{{ $property->address }}</td>
    </tr>
    <tr>
        <th>Deskripsi</th>
        <td>{{ $property->description ?? '-' }}</td>
    </tr>
</table>
