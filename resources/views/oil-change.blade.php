<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oil Change Checker</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <div class="card form-card">
        <h1>Oil Change Checker</h1>

        <form method="POST" action="{{ route('oil-change.check') }}">
            @csrf

            <div class="form-group">
                <label for="current_odometer">Current Odometer (km)</label>
                <input type="number" id="current_odometer" name="current_odometer"
                    value="{{ old('current_odometer') }}"
                    class="{{ $errors->has('current_odometer') ? 'is-invalid' : '' }}"
                    placeholder="e.g. 85000">
                @error('current_odometer')
                <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="last_change_date">Date of Previous Oil Change</label>
                <input type="date" id="last_change_date" name="last_change_date"
                    value="{{ old('last_change_date') }}"
                    class="{{ $errors->has('last_change_date') ? 'is-invalid' : '' }}">
                @error('last_change_date')
                <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="last_change_odometer">Odometer at Previous Oil Change (km)</label>
                <input type="number" id="last_change_odometer" name="last_change_odometer"
                    value="{{ old('last_change_odometer') }}"
                    class="{{ $errors->has('last_change_odometer') ? 'is-invalid' : '' }}"
                    placeholder="e.g. 80000">
                @error('last_change_odometer')
                <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit">Check Oil Change Status</button>
        </form>
    </div>
</body>

</html>