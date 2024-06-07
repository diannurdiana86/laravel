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
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        Add New Product
                    </div>
                    <div class="float-end">
                        <a href="{{ route('master.products.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('master.products.store') }}" method="post">
                        @csrf

                        <div class="mb-3 row">
                            <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="description"
                                class="col-md-4 col-form-label text-md-end text-start">Description</label>
                            <div class="col-md-6">
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description') }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="text-danger">{{ $errors->first('description') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Add Product">
                        </div>

                    </form>
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
