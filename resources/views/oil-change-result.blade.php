<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oil Change Result</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <div class="card">
        <h1>Oil Change Result</h1>

        <div class="result {{ $needsChange ? 'due' : 'ok' }}">
            @if($needsChange)
            <strong>Oil change is due!</strong>
            <ul>
                @foreach($reasons as $reason)
                <li>{{ $reason }}</li>
                @endforeach
            </ul>
            @else
            <strong>No oil change needed yet.</strong>
            <p class="result-summary">{{ $kmSinceChange }} km driven &middot; {{ $monthsSinceChange }} months since last change.</p>
            @endif
        </div>

        <div class="details">
            <h2>Submitted Values</h2>
            <dl>
                <dt>Current Odometer</dt>
                <dd>{{ number_format($oilCheck->current_odometer, 0) }} km</dd>

                <dt>Date of Previous Oil Change</dt>
                <dd>{{ $oilCheck->last_change_date->format('M d, Y') }}</dd>

                <dt>Odometer at Previous Oil Change</dt>
                <dd>{{ number_format($oilCheck->last_change_odometer, 0) }} km</dd>
            </dl>
        </div>

        <a href="{{ route('oil-change.index') }}" class="back-link">&larr; Check another vehicle</a>
    </div>
</body>

</html>