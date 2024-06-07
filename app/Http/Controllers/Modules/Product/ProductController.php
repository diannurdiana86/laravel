<?php

namespace App\Http\Controllers\Modules\Product;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Instantiate a new ProductController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:master/products/index', ['only' => ['index']]);
        $this->middleware('permission:master/products/show', ['only' => ['show']]);
        $this->middleware('permission:master/products/store', ['only' => ['store']]);
        $this->middleware('permission:master/products/create', ['only' => ['create']]);
        $this->middleware('permission:master/products/update', ['only' => ['update']]);
        $this->middleware('permission:master/products/edit', ['only' => ['edit']]);
        $this->middleware('permission:master/products/delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $data = [
            'title' => 'Product List',
            'products' => Product::latest()->paginate(3)
        ];
        return view('modules.product.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $data = [
            'title' => 'Create Product',
        ];
        return view('modules.product.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        Product::create($request->all());
        return redirect()->route('master.products.index')
            ->withSuccess('New product is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): View
    {
        $data = [
            'title' => 'Detail Product',
            'product' => $product,
        ];
        return view('modules.product.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        $data = [
            'title' => 'Edit Product',
            'product' => $product,
        ];
        return view('modules.product.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $product->update($request->all());
        return redirect()->back()
            ->withSuccess('Product is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        return redirect()->route('master.products.index')
            ->withSuccess('Product is deleted successfully.');
    }
}
