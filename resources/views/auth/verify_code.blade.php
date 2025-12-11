@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Email Verification</h3>
    <p>Please enter the 6-digit code sent to your email.</p>

    @if (session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div style="color: red;">{{ session('error') }}</div>
    @endif

    <form action="{{ route('verification.check') }}" method="POST">
        @csrf
        <input type="hidden" name="email" value="{{ session('email') }}">
        <div class="form-group">
            <label for="code">Verification Code</label>
            <input type="text" name="code" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Verify</button>
    </form>

    <hr>

    <form action="{{ route('verification.resend') }}" method="POST" style="margin-top: 20px;">
        @csrf
        <input type="hidden" name="email" value="{{ session('email') }}">
        <button type="submit" class="btn btn-link">Send Code Again</button>
    </form>
</div>
@endsection
