<table class="table table-bordered">
    <tr>
        <th>Booking</th>
        <td>Kamar {{ $review->booking->room->room_number ?? '-' }} ({{ $review->booking->room->property->name ?? '-' }})</td>
    </tr>
    <tr>
        <th>Pengguna (Tenant)</th>
        <td>{{ $review->user->name ?? '-' }}</td>
    </tr>
    <tr>
        <th>Rating</th>
        <td>
            @for($i=1; $i<=5; $i++)
                @if($i <= $review->rating)
                    <i class="bx bxs-star text-warning"></i>
                @else
                    <i class="bx bx-star text-warning"></i>
                @endif
            @endfor
            ({{ $review->rating }} / 5)
        </td>
    </tr>
    <tr>
        <th>Komentar</th>
        <td>{!! nl2br(e($review->comment)) !!}</td>
    </tr>
</table>
