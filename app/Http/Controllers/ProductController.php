<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Inertable\ProductTable;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return inertia('products/index')->inertable(new ProductTable)->title('Add Products');
    }

    public function store(ProductRequest $request)
    {
        Product::create($request->getData());

        return back()->success('Berhasil menambah produk');
    }

    public function update(Product $product, ProductRequest $request)
    {
        $product->update($request->getData());

        return back()->success('Berhasil mengubah produk');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return back()->success('Berhasil menghapus produk');
    }
}
