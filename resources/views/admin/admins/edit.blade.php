@extends('layouts.admin')
@section('title')
    الإعدادات العامة
@endsection

@section('contents')
    <style>

    </style>
    <div class="container" style="min-height: 100vh">
        <fieldset>
            <legend>Edit Admin's Info</legend>

            <form action="{{ route('update-admin-info') }}" method="post">

                @csrf
                <input type="hidden" name="id" value="{{ $user->id }}">
                <div class="input-group mt-3">
                    <label for="first_name" class="input-group-text required">First Name</label>
                    <input type="text" name="first_name" id="first_name" class="form-control" required
                        value="{{ old('first_name', $user->profile->first_name) }}">
                    <label for="last_name" class="input-group-text required">Family</label>
                    <input type="text" name="last_name" id="last_name" class="form-control" required
                        value="{{ old('last_name', $user->profile->last_name) }}">
                </div>
                <div class="input-group mt-3">
                    <label for="userName" class="input-group-text">User Name</label>
                    <input type="text" name="userName" id="userName" class="form-control" required
                        value="{{ old('userName', $user->userName) }}">
                    <label for="email" class="input-group-text ">Email</label>
                    <input type="text" name="email" id="email" class="form-control"
                        value="{{ old('email', $user->email) }}" required>

                </div>
                <div class="input-group mt-3">

                    @php $t = strtotime(old('dob', $user->profile->dob)) @endphp
                    <label for="gender" class="input-group-text">Gender</label>
                    <select name="gender" id="gender" class="custom-select" value="{{ old('gender') }}">
                        <option hidden>Select Gender</option>
                        <option {{ old('natId', $user->profile->gender) == 1 ? 'selected' : '' }} value="1">Male
                        </option>
                        <option {{ old('natId', $user->profile->gender) == 0 ? 'selected' : '' }} value="0">Female
                        </option>
                    </select>
                    <label for="dob" class="input-group-text">Date of Birth</label>
                    <input type="date" name="dob" id="dob" class="form-control"
                        value="{{ date('m/d/Y', $t) }}">
                    <label class="input-group-text">{{ date('m/d/Y', $t) }} </label>
                </div>

                <div class="input-group mt-3">
                    <label for="phone" class="input-group-text">Phone Number</label>
                    <input type="text" name="phone" autocomplete="phone" id="dob" class="form-control"
                        value="{{ old('phone', $user->profile->phone) }}">

                    <label for="natId" class="input-group-text">National Id</label>
                    <input type="text" name="natId" id="natId" class="form-control"
                        value="{{ old('natId', $user->profile->natId) }}">
                </div>

                <div style="btn-group">
                    <br>
                    <button id="dismiss_btn" class="btn btn-info"
                        onclick="window.location='{{ route('display-admins-list') }}'" type="button"
                        id="submitBtn">Cancel</button>
                    <button class="btn btn-success" type="submit" id="submitBtn">Update</button>
                </div>

            </form>
            <div class="alert alert-sm px-3 py-1 mt-3">(
                <span style="color: red">*</span> ) Refere to required fields.
            </div>
        </fieldset>

    </div>
@endsection


@section('script')
@endsection
