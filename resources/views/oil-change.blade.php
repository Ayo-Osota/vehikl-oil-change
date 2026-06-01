<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oil Change Checker</title>
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
            max-width: 480px;
         }
        h1 { 
            font-size: 1.5rem; 
            margin-bottom: 1.5rem; 
            color: #1f2937; 
        }
        .form-group { 
            margin-bottom: 1.25rem; 
        }
        label { 
            display: block; 
            font-size: 0.875rem; 
            font-weight: 600; 
            color: #374151; 
            margin-bottom: 0.375rem; 
        }
        input { 
            width: 100%; 
            padding: 0.625rem 0.75rem; 
            border: 1px solid #d1d5db; 
            border-radius: 6px; 
            font-size: 1rem; 
            transition: border-color 0.2s; 
        }
        input:focus { 
            outline: none; 
            border-color: #3b82f6; 
            box-shadow: 0 0 0 3px rgba(59,130,246,0.1); 
        }
        input.is-invalid { 
            border-color: #ef4444; 
        }
        .error { 
            color: #ef4444; 
            font-size: 0.8rem; 
            margin-top: 0.25rem; 
        }
        button { 
            width: 100%; 
            padding: 0.75rem; 
            background: #3b82f6; 
            color: #fff; 
            border: none; 
            border-radius: 6px; 
            font-size: 1rem; 
            font-weight: 600; 
            cursor: pointer; 
            transition: background 0.2s; 
        }
        button:hover { 
            background: #2563eb; 
        }
        .result { 
            margin-top: 1.5rem; 
            padding: 1rem; 
            border-radius: 8px; 
            font-size: 0.95rem; 
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
            | }
        .result li { 
            margin-top: 0.25rem; 
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Oil Change Checker</h1>

        <form method="POST" action="{{ route('oil-change.check') }}">
            @csrf

            <div class="form-group">
                <label for="current_odometer">Current Odometer (km)</label>
                <input type="number" id="current_odometer" name="current_odometer"
                       value="{{ old('current_odometer', $input['current_odometer'] ?? '') }}"
                       class="{{ $errors->has('current_odometer') ? 'is-invalid' : '' }}"
                       placeholder="e.g. 85000">
                @error('current_odometer')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="last_change_date">Date of Previous Oil Change</label>
                <input type="date" id="last_change_date" name="last_change_date"
                       value="{{ old('last_change_date', $input['last_change_date'] ?? '') }}"
                       class="{{ $errors->has('last_change_date') ? 'is-invalid' : '' }}">
                @error('last_change_date')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="last_change_odometer">Odometer at Previous Oil Change (km)</label>
                <input type="number" id="last_change_odometer" name="last_change_odometer"
                       value="{{ old('last_change_odometer', $input['last_change_odometer'] ?? '') }}"
                       class="{{ $errors->has('last_change_odometer') ? 'is-invalid' : '' }}"
                       placeholder="e.g. 80000">
                @error('last_change_odometer')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit">Check Oil Change Status</button>
        </form>

        @isset($needsChange)
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
        @endisset
    </div>
</body>
</html>
