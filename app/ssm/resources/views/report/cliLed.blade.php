@extends('layouts.master')

@section('content')
<style>
    svg{
        width: 20px;
    }
    nav[aria-label="Pagination Navigation"] {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

nav .pagination-container {
    display: flex;
    align-items: center;
}

nav .pagination-container .page-item {
    margin: 0 5px;
}

nav .pagination-container .page-item:first-child {
    margin-right: 15px;
}

/* Default pagination link styles */
.page-link {
    padding: 8px 12px;
    font-size: 14px;
    border: 1px solid #ddd;
    color: #007bff;
    text-decoration: none;
    background-color: white;
    border-radius: 4px;
    transition: background-color 0.2s ease, color 0.2s ease;
}

/* Hover effect for pagination links */
.page-link:hover {
    background-color: #f1f1f1;
    color: #0056b3;
}

/* Styling for the active/current page number */
nav [aria-current="page"] .page-link {
    background-color: blue;
    color: white;
    cursor: default;
    border-color: #007bff;
}

/* Disabled link style */
.page-link[aria-disabled="true"] {
    color: #999;
    background-color: #e9ecef;
    cursor: not-allowed;
}

/* Rounded corners for the first and last page links */
.rounded-l-md {
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
}

.rounded-r-md {
    border-top-right-radius: 4px;
    border-bottom-right-radius: 4px;
}


</style>

<div class="container my-4">
    <!-- Heading Row -->
    <input type="hidden" id="clid" value="{{ $clid }}">

    <table class="table table-striped">
        <thead class="fw-bold border-bottom pb-2">
            <tr>
                <th>Date</th>
                <th>Narration</th>
                <th>Reference</th>
                <th>Credit</th>
                <th>Payment</th>
                <th>Type</th>
                <th>Transaction</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($records as $record)
            <tr style="color: {{ $record->credit ? 'blue' : 'green' }};">
                <td>{{ $record->date }}</td>
                <td>{{ $record->remarks }}</td>
                <td>{{ $record->refno }}</td>
                <td>{{ $record->credit ? '₹'.$record->credit : ' ' }}</td>
                <td>{{ $record->debit ? '₹'.$record->debit : ' ' }}</td>
                <td>{{ $record->mode }}</td>
                <td>{{ $record->tid }}</td>
                <td>{{ '₹'.$record->current_amount }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $records->appends(request()->query())->links() }}
    </div>
</div>

@endsection
