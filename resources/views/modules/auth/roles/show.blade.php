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
                        Role Information
                    </div>
                    <div class="float-end">
                        <a href="{{ route('auth.roles.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                    </div>
                </div>
                <div class="card-body">

                    <div class="mb-3 row">
                        <label for="name"
                            class="col-md-4 col-form-label text-md-end text-start"><strong>Name:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $role->name }}
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
                        <label for="roles"
                            class="col-md-4 col-form-label text-md-end text-start"><strong>Permissions:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            @if ($role->name == 'Super Admin')
                                <span class="badge bg-primary">All</span>
                            @else
                                <ul class="tristate">
                                    @foreach ($groupedData as $key => $value)
                                        @include('modules.auth.roles.menushow', [
                                            'key' => $key,
                                            'value' => $value,
                                        ])
                                    @endforeach
                                </ul>
                                {{-- @forelse ($rolePermissions as $permission)
                                    <span class="badge bg-primary">{{ ucwords($permission->title) }}</span>
                                @empty
                                @endforelse --}}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
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
