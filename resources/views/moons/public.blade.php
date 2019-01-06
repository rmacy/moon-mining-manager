@extends('layouts.master-public', ['page' => 'moons'])

@section('title', 'Moons')

@section('content')

    <h1>Alliance Moons</h1>

    <p class="center">
        Click on table headings to sort. To inquire about renting a moon, please evemail
        <a href="https://zkillboard.com/character/93533671/">Metric Candy</a> quoting the relevant moon ID.
    </p>

    <p class="center">
        For more information on the Brave moon rental program, please consult
        <a href="https://wiki.bravecollective.com/member/alliance/industry/moon-rental" target="_blank">this wiki page</a>.
    </p>

    <p class="center">
        <strong>Any moon with an ID > 1502 is NOT for rent.</strong>
    </p>

    <div class="row">

        <table id="moons" class="moons">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Region</th>
                    <th>System</th>
                    <th>Mineral #1</th>
                    <th>Mineral #2</th>
                    <th>Mineral #3</th>
                    <th>Mineral #4</th>
                    <th class="numeric">Rent</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($moons as $moon)
                    <tr
                        @if (isset($moon->active_renter) || $moon->alliance_owned == 1)
                            class="rented"
                        @endif
                    >
                        <td>{{ $moon->id }}</td>
                        <td>{{ $moon->region->regionName }}</td>
                        <td class="nobreak">{{ $moon->system->solarSystemName }}</td>
                        <td>{{ $moon->mineral_1->typeName }} ({{ $moon->mineral_1_percent }}%)</td>
                        <td>{{ $moon->mineral_2->typeName }} ({{ $moon->mineral_2_percent }}%)</td>
                        <td>
                            @if ($moon->mineral_3_type_id)
                                {{ $moon->mineral_3->typeName }} ({{ $moon->mineral_3_percent }}%)
                            @endif
                        </td>
                        <td>
                            @if ($moon->mineral_4_type_id)
                                {{ $moon->mineral_4->typeName }} ({{ $moon->mineral_4_percent }}%)
                            @endif
                        </td>
                        <td class="numeric">{{ number_format($moon->monthly_rental_fee, 0) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <script>

        window.addEventListener('load', function () {
            $('#moons').tablesorter();
        });

    </script>

@endsection
