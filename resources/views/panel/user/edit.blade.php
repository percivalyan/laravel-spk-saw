@extends('panel.layouts.app')

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="mb-2">Edit User</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ url('/') }}"><i class="feather icon-home"></i></a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ url('panel/role') }}">User</a>
                                </li>
                                <li class="breadcrumb-item active">Edit User</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Form Section ] start -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header">
                            <h5 class="mb-0">User Information</h5>
                        </div>
                        <div class="card-body">
                            <form action="" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">User Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ $getRecord->name }}">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">E-Mail</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        value="{{ $getRecord->email }}" required>
                                    <div style="color:red">{{ $errors->first('email') }}</div>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="text" name="password" id="password" class="form-control">
                                    (Change Password if you want...)
                                </div>
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role</label>
                                    <div class="col-sm-12">
                                        <select name="role_id" id="role" class="form-control" required>
                                            <option value="">Select</option>
                                            @foreach ($getRole as $value)
                                                <option value="{{ $value->id }}"
                                                    {{ ($getRecord->role_id == $value->id) ? 'selected' : '' }}>
                                                    {{ $value->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <a href="{{ url('panel/role') }}" class="btn btn-secondary me-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ Form Section ] end -->
        </div>
    </div>
@endsection
