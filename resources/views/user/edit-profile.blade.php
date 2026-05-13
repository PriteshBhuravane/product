<x-navbar />
<div class="container">
    <h1>Edit Profile</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('user.updateProfile') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
        </div>
        <button type="submit" class="btn btn-success">Update Profile</button>
        <a href="{{ url('/user/home') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
