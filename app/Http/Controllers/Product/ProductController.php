<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $products = auth()->user()->products;
        if (is_null($products)) {
            return response()->json(
                ['success' => false, 'message' => 'No Records found'],
                400);
        }

        return response()->json(
            ['success' => true, 'products' => $products->toArray()],
            200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //            validate details
        $this->validate($request, [
                'name' => 'required|min:3',
                'price' => 'required|integer',

            ]
        );

//            create a user with the verified details
        $saveProduct = new Product();
        $saveProduct->name = $request->name;
        $saveProduct->price = $request->price;

        if (auth()->user()->products()->save($saveProduct)) {
            return response()->json(
                ['success' => true, 'data' => $saveProduct->toArray()],
                200);
        }
        return response()->json(
            ['success' => false, 'message' => 'User failed Authentication So product not Saved'],
            401);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $product = auth()->user()->products()->find($id);

        if (is_null($product)) {
            return response()->json(
                ['success' => false, 'message' => "No products with $id found"],
                400);
        }
        return response()->json(
            ['success' => true, 'data' => $product->toArray()],
            200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $product = auth()->user()->products()->find($id);

        if (is_null($product)) {
            return response()->json(
                ['success' => false, 'message' => "No products with $id found"],
                400);
        }
//        update information
        $updated = $product->fill($request->all())->save();

        if ($updated) {
            return response()->json(
                ['success' => true, 'message' => 'Product Updated Successfully'],
                200);
        } else{
            return response()->json(
                ['success' => false, 'message' => 'Could Not be updated'],
                500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $product = auth()->user()->products()->find($id);

        if (is_null($product)) {
            return response()->json(
                ['success' => false, 'message' => "No products with $id found"],
                400);
        }

//        delete information with id
        if ($product->delete()) {
            return response()->json(
                ['success' => true, 'message' => 'Product Deleted Successfully'],
                200);
        } else{
            return response()->json(
                ['success' => false, 'message' => 'Could Not be Deleted'],
                500);
        }
    }
}
