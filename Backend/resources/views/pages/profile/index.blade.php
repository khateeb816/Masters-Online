@extends('layouts.app')

@section('title', 'Profile Settings - ' . config('app.name'))

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="zmdi zmdi-account mr-2"></i>Profile Settings</h5>
            </div>
            <div class="card-body">
                <!-- Navigation Tabs -->
                <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab">
                            <i class="zmdi zmdi-account mr-1"></i>Profile Information
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="password-tab" data-toggle="tab" href="#password" role="tab">
                            <i class="zmdi zmdi-lock mr-1"></i>Change Password
                        </a>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content mt-3" id="profileTabsContent">
                    <!-- Profile Information Tab -->
                    <div class="tab-pane fade show active" id="profile" role="tabpanel">
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Profile Picture -->
                                <div class="col-md-3 text-center mb-4">
                                    <div class="profile-picture-container">
                                        <img src="{{ $user->profile_picture ? asset('uploads/' . $user->profile_picture) : asset('assets/images/profile.jpg') }}"
                                             alt="Profile Picture"
                                             class="img-fluid rounded-circle mb-3"
                                             style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #3498db;">
                                        <div class="mt-2">
                                            <label for="profile_picture" class="btn btn-outline-primary btn-sm">
                                                <i class="zmdi zmdi-camera mr-1"></i>Change Photo
                                            </label>
                                            <input type="file" id="profile_picture" name="profile_picture" class="d-none" accept="image/*">
                                        </div>
                                    </div>
                                </div>

                                <!-- Profile Information -->
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="first_name">First Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                                       id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
                                                @error('first_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="last_name">Last Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                                       id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
                                                @error('last_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Email <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                       id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone">Phone</label>
                                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                                       id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="date_of_birth">Date of Birth</label>
                                                <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror"
                                                       id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $user->profile->date_of_birth ?? '') }}">
                                                @error('date_of_birth')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="gender">Gender</label>
                                                <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender">
                                                    <option value="">Select Gender</option>
                                                    <option value="male" {{ old('gender', $user->profile->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                                                    <option value="female" {{ old('gender', $user->profile->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                                                    <option value="other" {{ old('gender', $user->profile->gender ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                                </select>
                                                @error('gender')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="alternative_phone">Alternative Phone</label>
                                        <input type="text" class="form-control @error('alternative_phone') is-invalid @enderror"
                                               id="alternative_phone" name="alternative_phone" value="{{ old('alternative_phone', $user->profile->alternative_phone ?? '') }}">
                                        @error('alternative_phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="address_line_1">Address Line 1</label>
                                        <input type="text" class="form-control @error('address_line_1') is-invalid @enderror"
                                               id="address_line_1" name="address_line_1" value="{{ old('address_line_1', $user->profile->address_line_1 ?? '') }}">
                                        @error('address_line_1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="address_line_2">Address Line 2</label>
                                        <input type="text" class="form-control @error('address_line_2') is-invalid @enderror"
                                               id="address_line_2" name="address_line_2" value="{{ old('address_line_2', $user->profile->address_line_2 ?? '') }}">
                                        @error('address_line_2')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="city">City</label>
                                                <input type="text" class="form-control @error('city') is-invalid @enderror"
                                                       id="city" name="city" value="{{ old('city', $user->profile->city ?? '') }}">
                                                @error('city')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="state">State</label>
                                                <input type="text" class="form-control @error('state') is-invalid @enderror"
                                                       id="state" name="state" value="{{ old('state', $user->profile->state ?? '') }}">
                                                @error('state')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="zip">ZIP Code</label>
                                                <input type="text" class="form-control @error('zip') is-invalid @enderror"
                                                       id="zip" name="zip" value="{{ old('zip', $user->profile->zip ?? '') }}">
                                                @error('zip')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <input type="text" class="form-control @error('country') is-invalid @enderror"
                                               id="country" name="country" value="{{ old('country', $user->profile->country ?? '') }}">
                                        @error('country')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="zmdi zmdi-save mr-1"></i>Update Profile
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Change Password Tab -->
                    <div class="tab-pane fade" id="password" role="tabpanel">
                        <form action="{{ route('profile.change-password') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="current_password">Current Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                               id="current_password" name="current_password" required>
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="new_password">New Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                               id="new_password" name="new_password" required>
                                        @error('new_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="new_password_confirmation">Confirm New Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control"
                                               id="new_password_confirmation" name="new_password_confirmation" required>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-warning">
                                            <i class="zmdi zmdi-lock mr-1"></i>Change Password
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Preview profile picture before upload
document.getElementById('profile_picture').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.querySelector('.profile-picture-container img').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
