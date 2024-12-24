<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }

        .register-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .register-header h1 {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .form-control {
            margin-bottom: 15px;
        }

        .btn-primary {
            width: 100%;
        }

        .login-link {
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="register-container">
    <div class="register-header">
        <h1>Register</h1>
    </div>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="form-label">Name</label>
            <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus autocomplete="name">
            @if ($errors->has('name'))
                <div class="text-danger mt-1">{{ $errors->first('name') }}</div>
            @endif
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autocomplete="email">
            @if ($errors->has('email'))
                <div class="text-danger mt-1">{{ $errors->first('email') }}</div>
            @endif
        </div>

        <!-- Phone -->
        <div>
            <label for="phone" class="form-label">Phone</label>
            <input id="phone" type="text" name="phone" class="form-control" value="{{ old('phone') }}" required autocomplete="phone">
            @if ($errors->has('phone'))
                <div class="text-danger mt-1">{{ $errors->first('phone') }}</div>
            @endif
        </div>

        <!-- Address -->
        <div>
            <label for="address" class="form-label">Address</label>
            <input id="address" type="text" name="address" class="form-control" value="{{ old('address') }}" required autocomplete="address">
            @if ($errors->has('address'))
                <div class="text-danger mt-1">{{ $errors->first('address') }}</div>
            @endif
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" name="password" class="form-control" required autocomplete="new-password">
            @if ($errors->has('password'))
                <div class="text-danger mt-1">{{ $errors->first('password') }}</div>
            @endif
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
            @if ($errors->has('password_confirmation'))
                <div class="text-danger mt-1">{{ $errors->first('password_confirmation') }}</div>
            @endif
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" class="btn btn-primary">Register</button>
        </div>

        <!-- Login Link -->
        <div class="login-link">
            <p>Already registered? <a href="{{ route('login') }}">Log in</a></p>
        </div>
    </form>
</div>

</body>
</html>
