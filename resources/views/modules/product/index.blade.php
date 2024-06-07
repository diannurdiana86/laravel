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
        <div class="card-header">Product List</div>
        <div class="card-body">
            @can('master/products/create')
                <a href="{{ route('master.products.create') }}" class="btn btn-success btn-sm my-2"><i
                        class="bi bi-plus-circle"></i> Add
                    New Product</a>
            @endcan
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">S#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>
                                <form action="{{ route('master.products.destroy', $product->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')

                                    <a href="{{ route('master.products.show', $product->id) }}"
                                        class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Show</a>

                                    @can('master/products/edit')
                                        <a href="{{ route('master.products.edit', $product->id) }}"
                                            class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                                    @endcan

                                    @can('master/products/destroy')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Do you want to delete this product?');"><i
                                                class="bi bi-trash"></i> Delete</button>
                                    @endcan
                                </form>
                            </td>
                        </tr>
                    @empty
                        <td colspan="4">
                            <span class="text-danger">
                                <strong>No Product Found!</strong>
                            </span>
                        </td>
                    @endforelse
                </tbody>
            </table>

            {{ $products->links() }}

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
