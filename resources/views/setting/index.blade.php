@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Profile</h4>
                </div>
                <div class="mt-3 mt-sm-0">
                </div>
            </div>
        </div>
    </div>

    <div class="row align-items-start mt-3">
        <div class="d-flex justify-content-center col-md-5">
            <div class="pt-3">
                <h3>Profile Information</h3>
                <p>Update your account's profile information and email address.</p>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <form action="">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" placeholder="Enter your name" value="{{ auth()->user()->name }}">
                            </div>

                            <div class="col-md-12">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Enter your email" value="{{ auth()->user()->email }}">
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-dark">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row align-items-start mt-3">
        <div class="d-flex justify-content-center col-md-5">
            <div class="pt-3">
                <h3>Update Password</h3>
                <p>Ensure your account is using a long, random password to stay secure.</p>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <form action="" method="POST">
                        @csrf
                        <div class="row g-3">
                            <!-- Current Password -->
                            <div class="col-md-12">
                                <label for="current_password" class="form-label fw-semibold">Current Password</label>
                                    <input 
                                        type="password" 
                                        class="form-control" 
                                        id="current_password" 
                                        name="current_password" 
                                        placeholder="Enter current password">
                            </div>

                            <!-- New Password -->
                            <div class="col-md-12">
                                <label for="new_password" class="form-label fw-semibold">New Password</label>
                                    <input 
                                        type="password" 
                                        class="form-control" 
                                        id="new_password" 
                                        name="new_password" 
                                        placeholder="Enter new password">
                            </div>

                            <!-- Confirm Password -->
                            <div class="col-md-12">
                                <label for="confirm_password" class="form-label fw-semibold">Confirm Password</label>
                                    <input 
                                        type="password" 
                                        class="form-control" 
                                        id="confirm_password" 
                                        name="confirm_password" 
                                        placeholder="Re-enter new password">
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-dark px-4">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection