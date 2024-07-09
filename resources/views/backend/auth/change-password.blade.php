<!-- resources/views/change-password.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
</head>
<body>
    <h1>Change Password</h1>

    @if(session('status'))
        <p>{{ session('status') }}</p>
    @endif

    <form method="POST" action="{{ route('change-password.post') }}">
        @csrf

        <div>
            <label for="email">Email Address</label>
            <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email">
            @error('email')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password">New Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password">
            @error('password')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password-confirm">Confirm New Password</label>
            <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password">
        </div>

        <button type="submit">Change Password</button>
    </form>
</body>
</html>
