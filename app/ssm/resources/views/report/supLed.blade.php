@extends('layouts.master')

@section('content')
<style>
    svg{
        width: 20px;
    }
</style>

<div class="container my-4">
        <!-- Heading Row -->



        <div class="row fw-bold border-bottom pb-2">



            <div class="col">Entry Time</div>
            <div class="col">Date</div>

            <div class="col">Narration</div>
            <div class="col">Trunction No</div>
            <div class="col">Credit</div>
            <div class="col">Payment</div>
            <div class="col">Current Amount</div>
        </div>

        @foreach ($records as $record)
        <div class="row py-2 border-bottom">
            <div class="col">{{ $record->created_at }}</div>

            <div class="col">{{ $record->date }}</div>
            <div class="col">{{ $record->narration }}</div>
            <div class="col">{{ $record->tid }}</div>
            <div class="col">{{ $record->credit ? '₹'.$record->credit : ' ' }}</div>
            <div class="col">{{ $record->debit ? '₹'.$record->debit : ' ' }}</div>
            <div class="col">{{ '₹'.$record->current_amomount }}</div>
        </div>
    @endforeach

    <div class="mt-4">
        {{ $records->appends(request()->query())->links() }}
    </div>
    </div>

    @endsection
