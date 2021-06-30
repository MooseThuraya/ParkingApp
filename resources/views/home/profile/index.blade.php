@extends('layouts.home')

<title> Profile Page </title>

@section('content')
    <div class="flex-form">
        <div class="container">
            <div class=" row justify-content-center">
                <div class="col-md-8">
                    <div class="form-group row justify-content-center">
                        <div class="col-md-12">
                            <h3 class="center-text">Profile Page</h3>
                        </div>
                    </div>
                    <div class="inputs-wrapper">
                        <div class="form-group row justify-content-center">
                            <div class="col-md-6 validate-input">
                                <label class="profile-label">First name</label>
                                <input class="profile-field" value="{{ $profile_info['user']['first_name'] }}">
                            </div>
                        </div>
                        <div class="form-group row justify-content-center">
                            <div class="col-md-6">
                                <label class="profile-label">Last name</label>
                                <input class="profile-field" value="{{ $profile_info['user']['last_name'] }}" >
                            </div>
                        </div>
                        <div class="form-group row justify-content-center">
                            <div class="col-md-6">
                                <label class="profile-label">Mobile numeber</label>
                                <input class=" profile-field " value="{{ $profile_info['user']['mobile_number'] }}">
                            </div>
                        </div>
                        <div class="form-group row justify-content-center">
                            <div class="col-md-6">
                                <label class="profile-label">Account balance</label>
                                <input class=" profile-field " value="{{ $profile_info['user']['user_points'] ?? 0}} Points">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
