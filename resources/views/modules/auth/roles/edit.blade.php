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

    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        Edit Role
                    </div>
                    <div class="float-end">
                        <a href="{{ route('auth.roles.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('auth.roles.update', $role->id) }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="mb-3 row">
                            <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ $role->name }}">
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>

                        @php
                            if (!function_exists('groupData')) {
                                function groupData($data, $permissionsData, $delimiter = '/')
                                {
                                    $grouped = [];
                                    foreach ($data as $index => $item) {
                                        $keys = explode($delimiter, $item);
                                        $currentGroup = &$grouped;
                                        foreach ($keys as $key) {
                                            if (!isset($currentGroup[$key])) {
                                                $currentGroup[$key] = [];
                                            }
                                            $currentGroup = &$currentGroup[$key];
                                        }
                                        if (end($keys)) {
                                            $currentGroup = (object) [
                                                'id' => $permissionsData[$index]['id'],
                                                'name' => isset($permissionsData[$index]['name']) ? $permissionsData[$index]['name'] : null,
                                                'title' => $permissionsData[$index]['title'],
                                            ];
                                        }
                                        $currentGroup = &$grouped;
                                    }
                                    return $grouped;
                                }
                            }
                            $permissionsData = [];
                            foreach ($permissions as $permission) {
                                $permissionsData[] = [
                                    'id' => $permission->id,
                                    'title' => $permission->title,
                                    'name' => $permission->name,
                                ];
                            }
                            $permissionNames = array_column($permissionsData, 'name');
                            $groupedData = groupData($permissionNames, $permissionsData);
                            // print_r($groupedData);
                            // print_r($rolePermissions);
                        @endphp

                        <div class="mb-3 row">
                            <label for="permissions"
                                class="col-md-4 col-form-label text-md-end text-start">Permissions</label>
                            <div class="col-md-6">
                                <ul class="tristate">
                                    @foreach ($groupedData as $key => $value)
                                        @include('modules.auth.roles.menuedit', [
                                            'key' => $key,
                                            'value' => $value,
                                        ])
                                    @endforeach
                                </ul>
                                @if ($errors->has('permissions'))
                                    <span class="text-danger">{{ $errors->first('permissions') }}</span>
                                @endif
                            </div>
                        </div>
                </div>
            </div>

            <div class="mb-3 row">
                <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Update Role">
            </div>

            </form>
        </div>
    </div>
    </div>
    </div>
@endsection

@section('scriptjs')
    <script src="{{ url('/') }}/assets/js/jquery.tristate.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.tristate').tristate();
        })
    </script>
@endsection
