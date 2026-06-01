<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oil Change Result</title>
    <style>
        * { 
            box-sizing: border-box; 
            margin: 0; 
            padding: 0; 
        }
        body { 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
             background: #f3f4f6; 
             min-height: 100vh; 
             display: flex; 
             align-items: center; 
             justify-content: center; 
             padding: 2rem; 
            }
        .card { 
            background: #fff; 
            border-radius: 12px; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.08); 
            padding: 2.5rem; 
            width: 100%; 
            max-width: 520px; 
        }
        h1 { 
            font-size: 1.5rem; 
            margin-bottom: 1.5rem; 
            color: #1f2937; 
        }
        .result { 
            padding: 1rem; 
            border-radius: 8px; 
            font-size: 0.95rem; 
            margin-bottom: 1.5rem;
         }
        .result.due { 
            background: #fef2f2; 
            border: 1px solid #fecaca; 
            color: #991b1b; 
        }
        .result.ok { 
            background: #f0fdf4; 
            border: 1px solid #bbf7d0;
             color: #166534; 
            }
        .result ul {
             margin-top: 0.5rem; 
             padding-left: 1.25rem; 
            }
        .result li { 
            margin-top: 0.25rem; 
        }
        .details { 
            background: #f9fafb; 
            border: 1px solid #e5e7eb;
            border-radius: 8px; 
            padding: 1rem; 
            }
        .details h2 {
             font-size: 1rem; 
             color: #374151; 
             margin-bottom: 0.75rem; 
            }
        .details dl {
             display: grid; 
             grid-template-columns: 1fr 1fr; 
             gap: 0.5rem;
             }
        .details dt { 
            font-size: 0.8rem;
            color: #6b7280;
            font-weight: 600; 
        }
        .details dd { 
            font-size: 0.95rem; 
            color: #1f2937; 
            margin-bottom: 0.5rem; 
        }
        .back-link { 
            display: inline-block; 
            margin-top: 1.5rem; 
            color: #3b82f6; 
            text-decoration: none; 
            font-weight: 600; 
        }
        .back-link:hover { 
            text-decoration: underline;
         }
    </style>
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
                <p style="margin-top: 0.5rem;">{{ $kmSinceChange }} km driven &middot; {{ $monthsSinceChange }} months since last change.</p>
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
