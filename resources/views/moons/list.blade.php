@extends('layouts.master')

@section('title', 'Moon Composition Data')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card-heading">Existing Moon Data</div>
            <table id="moons">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Region</th>
                        <th>System</th>
                        <th>P</th>
                        <th>M</th>
                        <th>Mineral composition</th>
                        <th>Total %</th>
                        <th class="numeric">Monthly fee</th>
                        <th class="numeric">Last month</th>
                        <th>Renter</th>
                        <th>updated</th>
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
                            <td>{{ $moon->system->solarSystemName }}</td>
                            <td>{{ $moon->planet }}</td>
                            <td>{{ $moon->moon }}</td>
                            <td>
                                {{ $moon->mineral_1->typeName }} ({{ round($moon->mineral_1_percent, 2) }}%)
                                &#0183; {{ $moon->mineral_2->typeName }} ({{ round($moon->mineral_2_percent, 2) }}%)
                                @if ($moon->mineral_3_type_id)
                                    &#0183; {{ $moon->mineral_3->typeName }} ({{ round($moon->mineral_3_percent, 2) }}%)
                                @endif
                                @if ($moon->mineral_4_type_id)
                                    &#0183; {{ $moon->mineral_4->typeName }} ({{ round($moon->mineral_4_percent, 2) }}%)
                                @endif
                            </td>
                            <td>
                                {{ round(
                                    $moon->mineral_1_percent + $moon->mineral_2_percent +
                                        $moon->mineral_3_percent + $moon->mineral_4_percent,
                                    2
                                ) }}%
                            </td>
                            <td class="numeric">{{ number_format($moon->monthly_rental_fee, 0) }}</td>
                            <td class="numeric">{{ number_format($moon->previous_monthly_rental_fee, 0) }}</td>
                            <td>
                                {{ $moon->active_renter ? $moon->active_renter->character_name : '' }}
                                {{ $moon->alliance_owned ? 'Alliance' : '' }}
                            </td>
                            <td>{{ $moon->updated_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script type="text/javascript">
        window.addEventListener('load', function() {
            $('#moons').tablesorter();
        });
    </script>

@endsection
