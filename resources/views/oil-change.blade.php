<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Check whether your vehicle needs an oil change based on current odometer, previous odometer, and last oil change date.">
    <title>Oil Change Checker</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <main class="container">
        <header class="flow">
            <img class="logo" src="{{ asset('logo.png') }}" alt="Oil Change Checker logo">
            <h1>Check if a vehicle is due for maintenance in seconds</h1>
            <p>Enter mileage and last service details to determine status</p>
        </header>

        <form class="flow" style="--flow-spacer: 1.5rem" method="POST" action="{{ route('oil-change.check') }}">
            @csrf

            <div class="form-control">
                <label for="current_odometer">Current Odometer (km)</label>
                <input type="number" id="current_odometer" name="current_odometer"
                    value="{{ old('current_odometer') }}"
                    class="{{ $errors->has('current_odometer') ? 'custom-input is-invalid' : 'custom-input' }}"
                    placeholder="e.g. 85000">
                @error('current_odometer')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-control">
                <label for="last_change_date">Date of Previous Oil Change</label>
                <input type="date" id="last_change_date" name="last_change_date"
                    value="{{ old('last_change_date') }}"
                    class="{{ $errors->has('last_change_date') ? 'custom-input is-invalid' : 'custom-input' }}">
                @error('last_change_date')
                <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-control">
                <label for="last_change_odometer">Odometer at Previous Oil Change (km)</label>
                <input type="number" id="last_change_odometer" name="last_change_odometer"
                    value="{{ old('last_change_odometer') }}"
                    class="{{ $errors->has('last_change_odometer') ? 'custom-input is-invalid' : 'custom-input' }}"
                    placeholder="e.g. 80000">
                @error('last_change_odometer')
                <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="custom-btn">Check Oil Change Status</button>
        </form>
        <footer>
            <p>We’ll instantly calculate maintenance status</p>

            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_3_212)">
                    <path d="M8 14C11.3137 14 14 11.3137 14 8C14 4.68629 11.3137 2 8 2C4.68629 2 2 4.68629 2 8C2 11.3137 4.68629 14 8 14Z" stroke="#C2C2C2" stroke-width="0.646353" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M7.5 7.5C7.63261 7.5 7.75979 7.55268 7.85355 7.64645C7.94732 7.74021 8 7.86739 8 8V10.5C8 10.6326 8.05268 10.7598 8.14645 10.8536C8.24021 10.9473 8.36739 11 8.5 11" stroke="#C2C2C2" stroke-width="0.646353" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M7.75 6C8.16421 6 8.5 5.66421 8.5 5.25C8.5 4.83579 8.16421 4.5 7.75 4.5C7.33579 4.5 7 4.83579 7 5.25C7 5.66421 7.33579 6 7.75 6Z" fill="#C2C2C2" />
                </g>
                <defs>
                    <clipPath id="clip0_3_212">
                        <rect width="16" height="16" fill="white" />
                    </clipPath>
                </defs>
            </svg>

        </footer>
    </main>
</body>

</html>