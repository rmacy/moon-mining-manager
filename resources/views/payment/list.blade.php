@extends('layouts.master')

@section('title', 'Manual Payment')

@section('content')

    <div class="row">

        <div class="col-12">

            <a href="/payment/new">Add new payment</a>
            <br><br>

            @foreach ([$minerPayments, $rentalPayments] as $idx => $payments)
                <table>
                    <thead>
                        <tr>
                            <th>
                                @if ($idx === 0)
                                    Miner
                                @else
                                    Renter
                                @endif
                            </th>
                            <th>Created by</th>
                            <th class="numeric">Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $payment)
                            <tr>
                                <td>
                                    @if (isset($payment->miner))
                                        {{ $payment->miner->name }}
                                    @else
                                        {{ $payment->character->name }}
                                    @endif
                                </td>
                                <td>
                                    {{ $payment->createdBy->name }}
                                </td>
                                <td class="numeric">
                                    {{ number_format($payment->amount_received) }} ISK
                                </td>
                                <td>
                                    {{ date('g:ia, jS F Y', strtotime($payment->created_at)) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br><br>
            @endforeach

        </div>

    </div>

@endsection
