@extends('layouts.page_layout')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ $title }}</h4>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Manage Roles</div>
        <div class="card-body">
            @can('role/create')
                <a href="{{ route('auth.roles.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i>
                    Add New Role</a>
            @endcan
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">S#</th>
                        <th scope="col">Name</th>
                        <th scope="col" style="width: 250px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $role)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $role->name }}</td>
                            <td>
                                <form action="{{ route('auth.roles.destroy', $role->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')

                                    <a href="{{ route('auth.roles.show', $role->id) }}" class="btn btn-warning btn-sm"><i
                                            class="bi bi-eye"></i> Show</a>

                                    @if ($role->name != 'Super Admin')
                                        @can('role/edit')
                                            <a href="{{ route('auth.roles.edit', $role->id) }}"
                                                class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                                        @endcan

                                        @can('role/destroy')
                                            @if ($role->name != Auth::user()->hasRole($role->name))
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Do you want to delete this role?');"><i
                                                        class="bi bi-trash"></i> Delete</button>
                                            @endif
                                        @endcan
                                    @endif

                                </form>
                            </td>
                        </tr>
                    @empty
                        <td colspan="3">
                            <span class="text-danger">
                                <strong>No Role Found!</strong>
                            </span>
                        </td>
                    @endforelse
                </tbody>
            </table>

            {{ $roles->links() }}

        </div>
    </div>
@endsection

@section('scriptjs')
    <script type="text/javascript">
        $(document).ready(function() {
            console.log('scriptjs ');
        })
    </script>
@endsection
