<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="View your oil change check result, including maintenance status, distance since last service, and submitted vehicle values.">
    <title>Oil Change Result</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    @php
    $currentOdometerDisplay = (int) ceil((float) $oilCheck->current_odometer);
    $lastChangeOdometerDisplay = (int) ceil((float) $oilCheck->last_change_odometer);
    $kmSinceChangeDisplay = (int) ceil((float) $kmSinceChange);
    $monthsSinceChangeDisplay = (int) ceil((float) $monthsSinceChange);
    $distanceExceeded = (float) $kmSinceChange > 5000;
    $monthsExceeded = (float) $monthsSinceChange > 6;
    $monthsSinceChangeLabel = (float) $monthsSinceChange < 1
        ? 'Less than 1 month'
        : $monthsSinceChangeDisplay . ' months' ;
        @endphp

        <main class="container">
        <header class="flow">
            <img class="logo" src="{{ asset('oil-change.svg') }}" alt="Oil Change">
            <h1>{{ $needsChange ? 'Oil Change Required' : 'Oil Change Not Required' }}</h1>
            <p>This vehicle is {{ $needsChange ? 'not' : 'still' }} within the recommended maintenance interval.</p>
        </header>

        <article class="vehicle-metrics {{ $needsChange ? 'vehicle-metrics--alert' : '' }}">
            <div>
                @if($distanceExceeded)
                <svg class="metric-icon" fill="#ff0000" width="15" height="15" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <defs>
                            <style>
                                .cls-1 {
                                    fill-rule: evenodd;
                                }
                            </style>
                        </defs>
                        <path id="cancel" class="cls-1" d="M936,120a12,12,0,1,1,12-12A12,12,0,0,1,936,120Zm0-22a10,10,0,1,0,10,10A10,10,0,0,0,936,98Zm4.706,14.706a0.951,0.951,0,0,1-1.345,0l-3.376-3.376-3.376,3.376a0.949,0.949,0,1,1-1.341-1.342l3.376-3.376-3.376-3.376a0.949,0.949,0,1,1,1.341-1.342l3.376,3.376,3.376-3.376a0.949,0.949,0,1,1,1.342,1.342l-3.376,3.376,3.376,3.376A0.95,0.95,0,0,1,940.706,112.706Z" transform="translate(-924 -96)"></path>
                    </g>
                </svg>

                @else
                <svg class="metric-icon" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_4_393)">
                        <path d="M3.09625 11.4582C2.5732 10.9352 2.92001 9.83621 2.65393 9.19263C2.37763 8.52802 1.3645 7.98791 1.3645 7.27724C1.3645 6.56658 2.37763 6.02647 2.65393 5.36186C2.92001 4.71885 2.5732 3.6193 3.09625 3.09625C3.6193 2.5732 4.71885 2.92001 5.36186 2.65393C6.02931 2.37763 6.56658 1.3645 7.27724 1.3645C7.98791 1.3645 8.52802 2.37763 9.19263 2.65393C9.83621 2.92001 10.9352 2.5732 11.4582 3.09625C11.9813 3.6193 11.6345 4.71828 11.9006 5.36186C12.1769 6.02931 13.19 6.56658 13.19 7.27724C13.19 7.98791 12.1769 8.52802 11.9006 9.19263C11.6345 9.83621 11.9813 10.9352 11.4582 11.4582C10.9352 11.9813 9.83621 11.6345 9.19263 11.9006C8.52802 12.1769 7.98791 13.19 7.27724 13.19C6.56658 13.19 6.02647 12.1769 5.36186 11.9006C4.71885 11.6345 3.6193 11.9813 3.09625 11.4582Z" stroke="#008000" stroke-width="0.909653" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M5.00311 7.73203L6.36759 9.0965L9.55138 5.91272" stroke="#008000" stroke-width="0.909653" stroke-linecap="round" stroke-linejoin="round" />
                    </g>
                    <defs>
                        <clipPath id="clip0_4_393">
                            <rect width="14.5544" height="14.5544" fill="white" />
                        </clipPath>
                    </defs>
                </svg>
                @endif

                <p>{{ number_format($kmSinceChangeDisplay, 0) }} km driven (limit: 5000 km)</p>
            </div>
            <div>
                @if($monthsExceeded)
                <svg class="metric-icon" fill="#ff0000" width="15" height="15" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <defs>
                            <style>
                                .cls-1 {
                                    fill-rule: evenodd;
                                }
                            </style>
                        </defs>
                        <path id="cancel" class="cls-1" d="M936,120a12,12,0,1,1,12-12A12,12,0,0,1,936,120Zm0-22a10,10,0,1,0,10,10A10,10,0,0,0,936,98Zm4.706,14.706a0.951,0.951,0,0,1-1.345,0l-3.376-3.376-3.376,3.376a0.949,0.949,0,1,1-1.341-1.342l3.376-3.376-3.376-3.376a0.949,0.949,0,1,1,1.341-1.342l3.376,3.376,3.376-3.376a0.949,0.949,0,1,1,1.342,1.342l-3.376,3.376,3.376,3.376A0.95,0.95,0,0,1,940.706,112.706Z" transform="translate(-924 -96)"></path>
                    </g>
                </svg>

                @else
                <svg class="metric-icon" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_4_393)">
                        <path d="M3.09625 11.4582C2.5732 10.9352 2.92001 9.83621 2.65393 9.19263C2.37763 8.52802 1.3645 7.98791 1.3645 7.27724C1.3645 6.56658 2.37763 6.02647 2.65393 5.36186C2.92001 4.71885 2.5732 3.6193 3.09625 3.09625C3.6193 2.5732 4.71885 2.92001 5.36186 2.65393C6.02931 2.37763 6.56658 1.3645 7.27724 1.3645C7.98791 1.3645 8.52802 2.37763 9.19263 2.65393C9.83621 2.92001 10.9352 2.5732 11.4582 3.09625C11.9813 3.6193 11.6345 4.71828 11.9006 5.36186C12.1769 6.02931 13.19 6.56658 13.19 7.27724C13.19 7.98791 12.1769 8.52802 11.9006 9.19263C11.6345 9.83621 11.9813 10.9352 11.4582 11.4582C10.9352 11.9813 9.83621 11.6345 9.19263 11.9006C8.52802 12.1769 7.98791 13.19 7.27724 13.19C6.56658 13.19 6.02647 12.1769 5.36186 11.9006C4.71885 11.6345 3.6193 11.9813 3.09625 11.4582Z" stroke="#008000" stroke-width="0.909653" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M5.00311 7.73203L6.36759 9.0965L9.55138 5.91272" stroke="#008000" stroke-width="0.909653" stroke-linecap="round" stroke-linejoin="round" />
                    </g>
                    <defs>
                        <clipPath id="clip0_4_393">
                            <rect width="14.5544" height="14.5544" fill="white" />
                        </clipPath>
                    </defs>
                </svg>
                @endif
                <p>{{ $monthsSinceChangeLabel }} since last service (limit: 6 months)</p>
            </div>
        </article>

        <table class="data-table">
            <tbody>
                <tr>
                    <th>Current Odometer</th>
                    <td>{{ number_format($currentOdometerDisplay, 0) }} km</td>
                </tr>
                <tr>
                    <th>Previous Odometer</th>
                    <td>{{ number_format($lastChangeOdometerDisplay, 0) }} km</td>
                </tr>
                <tr>
                    <th>Distance Driven</th>
                    <td>{{ number_format($kmSinceChangeDisplay, 0) }} km</td>
                </tr>
                <tr>
                    <th>Last Oil Change Date</th>
                    <td>{{ $oilCheck->last_change_date->format('M d, Y') }}</td>
                </tr>
            </tbody>
        </table>

        <a href="{{ route('oil-change.index') }}" class="custom-btn">Check another vehicle</a>
        </main>
</body>

</html>