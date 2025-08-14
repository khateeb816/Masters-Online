@extends('layouts.app')

@section('title', 'Add User - ' . config('app.name'))

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">


            

            <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-title">Personal Information</div>
                <hr>

                <div class="form-group">
                    <label for="input-1">First Name</label>
                    <input type="text" class="form-control" id="input-1" placeholder="Enter Your First Name" name="first_name">
                </div>
                <div class="form-group">
                    <label for="input-1">Last Name</label>
                    <input type="text" class="form-control" id="input-1" placeholder="Enter Your Last Name" name="last_name">
                </div>
                <div class="form-group">
                    <label for="input-1">Username</label>
                    <input type="text" class="form-control" id="input-1" placeholder="Enter Your Username" name="username">
                </div>
                <div class="form-group">
                    <label for="input-2">Email</label>
                    <input type="email" class="form-control" id="input-2" placeholder="Enter Your Email Address" name="email">
                </div>
                <div class="form-group">
                    <label for="input-3">Phone</label>
                    <input type="text" class="form-control" id="input-3" placeholder="Enter Your Phone Number" name="phone">
                </div>
                <div class="form-group">
                    <label for="input-4">Password</label>
                    <input type="password" class="form-control" id="input-4" placeholder="Enter Password" name="password">
                </div>
                <div class="form-group">
                    <label for="input-5">Confirm Password</label>
                    <input type="password" class="form-control" id="input-5" placeholder="Confirm Password" name="password_confirmation">
                </div>
                <div class="form-group">
                    <label for="input-6">Profile Picture</label>
                    <input type="file" class="form-control" id="input-6" name="profile_picture">
                </div>
                <br>
                <div class="card-title">Address Information</div>
                <hr>
                <div class="form-group">
                    <label for="input-7">Address Line 1</label>
                    <input type="text" class="form-control" id="input-7" placeholder="Enter Your Address Line 1" name="address_line_1">
                </div>
                <div class="form-group">
                    <label for="input-8">Address Line 2</label>
                    <input type="text" class="form-control" id="input-8" placeholder="Enter Your Address Line 2" name="address_line_2">
                </div>
                <div class="form-group">
                    <label for="input-9">City</label>
                    <input type="text" class="form-control" id="input-9" placeholder="Enter Your City" name="city">
                </div>
                <div class="form-group">
                    <label for="input-10">State</label>
                    <input type="text" class="form-control" id="input-10" placeholder="Enter Your State" name="state">
                </div>
                <div class="form-group">
                    <label for="input-11">Country</label>
                    <input type="text" class="form-control" id="input-11" placeholder="Enter Your Country" name="country">
                </div>
                <div class="form-group">
                    <label for="input-12">Zip Code</label>
                    <input type="text" class="form-control" id="input-12" placeholder="Enter Your Zip Code" name="zip">
                </div>
                <div class="form-group">
                    <label for="input-13">Alternative Phone</label>
                    <input type="text" class="form-control" id="input-13" placeholder="Enter Your Alternative Phone" name="alternative_phone">
                </div>
                <br>
                <div class="card-title">Other Information</div>
                <hr>
                <div class="form-group">
                    <div class="icheck-material-white">
                        <input type="checkbox" id="user-checkbox1" checked="" name="status">
                        <label for="user-checkbox1">Active</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-13">Date of Birth</label>
                    <input type="date" class="form-control" id="input-13" placeholder="Enter Your Date of Birth" name="date_of_birth">
                </div>
                <div class="form-group">
                    <label for="input-14">Gender</label>
                    <select class="form-select" aria-label="Default select example" name="gender">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-light px-5"><i class="icon-lock"></i> Register</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
