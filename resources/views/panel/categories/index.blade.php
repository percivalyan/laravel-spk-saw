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
                                <h5 class="mb-2">Categories</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ url('/') }}"><i class="feather icon-home"></i></a>
                                </li>
                                <li class="breadcrumb-item active">Categories</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <div class="row">
                <div class="col-sm-12">
                    @include('panel._message')
                    <div class="card shadow-sm border-0">
                        <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                            <h5 class="mb-2 mb-md-0">Category List</h5>

                            <div class="d-flex align-items-center">
                                <form action="{{ route('categories.index') }}" method="GET" class="d-flex me-2">
                                    <input type="text" name="search" class="form-control form-control-sm me-2"
                                        placeholder="Search name or code..." value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-sm btn-outline-primary">
                                        <i class="feather icon-search"></i>
                                    </button>
                                </form>

                                @if ($PermissionAdd)
                                    <a href="{{ route('categories.create') }}" class="btn btn-sm btn-primary"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Add New Category">
                                        <i class="feather icon-plus-circle me-1"></i> Add Category
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Display Category Table -->
                        @if ($categories->isEmpty())
                            <div class="alert alert-warning">
                                <i class="feather icon-info"></i> No categories found. Please add some data.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle text-center">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="px-4 py-2">Name</th>
                                            <th class="px-4 py-2">Code</th>
                                            <th class="px-4 py-2">Description</th>
                                            <th class="px-4 py-2">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $category)
                                            <tr>
                                                <td class="px-4 py-2">{{ $category->name }}</td>
                                                <td class="px-4 py-2">{{ $category->code_category }}</td>
                                                <td class="px-4 py-2">{{ Str::limit($category->description, 50) }}</td>
                                                <td class="px-4 py-2">
                                                    @if ($PermissionShow)
                                                        <a href="{{ route('categories.show', $category->id) }}"
                                                            class="btn btn-info btn-sm" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="View Category">
                                                            <i class="feather icon-eye"></i> Show
                                                        </a>
                                                    @endif
                                                    @if ($PermissionEdit)
                                                        <a href="{{ route('categories.edit', $category->id) }}"
                                                            class="btn btn-warning btn-sm" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Edit Category">
                                                            <i class="feather icon-edit"></i> Edit
                                                        </a>
                                                    @endif
                                                    @if ($PermissionDelete)
                                                        <form action="{{ route('categories.destroy', $category->id) }}"
                                                            method="POST" class="d-inline"
                                                            onsubmit="return confirm('Are you sure you want to delete this category?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Delete Category">
                                                                <i class="feather icon-trash-2"></i> Delete
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- Pagination Links -->
                                <div class="d-flex justify-content-center mt-2">
                                    <div class="pagination-wrapper">
                                        {{ $categories->links('pagination::bootstrap-4') }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script to initialize tooltips -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = Array.from(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
@endsection
