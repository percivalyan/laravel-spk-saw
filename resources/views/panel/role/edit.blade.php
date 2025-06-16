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
                                <h5 class="mb-2">Edit Role</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ url('/') }}"><i class="feather icon-home"></i></a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ url('panel/role') }}">Roles</a>
                                </li>
                                <li class="breadcrumb-item active">Edit Role</li>
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
                            <h5 class="mb-0">Role Information</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ url('panel/role/edit/' . $getRecord->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Role Name</label>
                                    <input type="text" name="name" id="name" value="{{ $getRecord->name }}"
                                        class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label style="display: block; margin-button: 20px" for="name"
                                        class="form-label">Permission</label>
                                    <br>
                                    @foreach ($getPermission as $value)
                                        <div class="row" style="margin-button: 20px">
                                            <div class="col-md-3">
                                                {{ $value['name'] }}
                                            </div>
                                            <div class="col-md-9">
                                                <div class="row">
                                                    @foreach ($value['group'] as $group)
                                                        @php
                                                            $checked = '';
                                                        @endphp
                                                        @foreach ($getRolePermission as $role)
                                                            @if ($role->permission_id == $group['id'])
                                                                @php
                                                                    $checked = 'checked';
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                        <div class="col-md-3">
                                                            <label>
                                                                <input type="checkbox" {{ $checked }}
                                                                    value="{{ $group['id'] }}" name="permission_id[]">
                                                                {{ $group['name'] }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    @endforeach
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
