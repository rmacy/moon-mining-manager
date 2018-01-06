@extends('layouts.master')

@section('title', 'Renter Details')

@section('content')

    <div class="row">

        <div class="col-4">
            <div class="card-heading">Renter</div>
            @include('common.card', [
                'avatar' => $renter->avatar->px128x128,
                'name' => $renter->name, 
                'sub' => $renter->corporation->name
            ])
        </div>

        <div class="col-4">
            <div class="card-heading">Total rental income paid</div>
            <div class="card highlight">
                <span class="num">{{ number_format($total_rent_paid) }}</span> ISK
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-8">

            <div class="card-heading">Activity Log</div>

            <table>
                <thead>
                    <tr>
                        <th>Activity</th>
                        <th class="numeric">Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($activity_log as $activity)
                        <tr>
                            <td>
                                @if (isset($activity->amount))
                                    Invoice sent
                                @endif
                                @if (isset($activity->amount_received))
                                    Payment received
                                @endif
                            </td>
                            <td class="numeric">
                                @if (isset($activity->amount))
                                    {{ number_format($activity->amount) }} ISK
                                @endif
                                @if (isset($activity->amount_received))
                                    {{ number_format($activity->amount_received) }} ISK
                                @endif
                            </td>
                            <td>
                                {{ date('g:ia, jS F Y', strtotime($activity->created_at)) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

        <div class="col-4">

            <div class="card-heading">
                Refineries rented
            </div>

            <table>
                <tbody>
                    @foreach ($rentals as $rental)
                        <tr>
                            <td><a href="/renters/refinery/{{$rental->refinery_id }}">{{ $rental->refinery->name }}</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>

@endsection