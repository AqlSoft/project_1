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

            <form action="{{ route('store-admin-info') }}" method="post">

                @csrf
                <div class="input-group mt-3">
                    <label for="first_name" class="input-group-text required">First Name</label>
                    <input type="text" name="first_name" id="first_name" class="form-control" required
                        value="{{ old('first_name') }}">
                    <label for="last_name" class="input-group-text required">Family</label>
                    <input type="text" name="last_name" id="last_name" class="form-control" required
                        value="{{ old('last_name') }}">
                </div>
                <div class="input-group mt-3">
                    <label for="userName" class="input-group-text required">Username</label>
                    <input type="text" name="userName" id="userName" class="form-control" value="{{ old('userName') }}"
                        required>
                    <label for="email" class="input-group-text required required">Email</label>
                    <input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}"
                        required>
                </div>

                <div class="input-group mt-3">
                    <label for="password" class="input-group-text required">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required
                        value="{{ old('password') }}">
                    <label for="possition" class="input-group-text">Possition</label>
                    <select name="possition" id="possition" class="form-control" value="{{ old('possition') }}" required>
                        <option value=""></option>
                        @foreach ($jobs as $job)
                            <option value="{{ $job->id }}">{{ $job->job_title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="button-group">
                    <br>
                    <button id="dismiss_btn" class="btn btn-info"
                        onclick="window.location='{{ route('display-admins-list') }}'" type="button"
                        id="submitBtn">Cancel</button>
                    <button class="btn btn-success" type="submit" id="submitBtn">Save</button>
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
