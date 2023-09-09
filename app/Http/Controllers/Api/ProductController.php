<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Utils\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Middleware\QueryUrlWhiteLists;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(QueryUrlWhiteLists::class)->only('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Response::make(200, 'Product lists', Product::query()->paginate($request->get('perPage', 10)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        return Response::make(200, 'Product created', Product::create($request->getData()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return Response::make(200, 'Product detail', $product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Product $product, ProductRequest $request)
    {
        $product->update($request->getData());

        return Response::make(200, 'Product updated', $product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return Response::make(200, 'Product deleted', $product);
    }
}
