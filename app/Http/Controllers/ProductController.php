<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\ProductVariantPrice;
use App\Models\Variant;
use Illuminate\Http\Request;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $products = DB::table('products')
//        ->join('product_variants','products.id','=','product_variants.product_id')
            ->join('product_variant_prices','products.id','=','product_variant_prices.product_id')
            ->select('products.*','product_variant_prices.price','product_variant_prices.stock')
            ->orderBy('id','desc')
            ->paginate(15);

//        $variants = ProductVariant::all();
        $variants = DB::table('variants')
            ->join('product_variants','variants.id','=','product_variants.variant_id')
            ->select('product_variants.*')
            ->get();
        return view('products.index',[
            'products' => $products,
            'variants' => $variants,
        ]);
    }
    public function filterProduct(Request $request)
    {
        $products = DB::table('products')
//            ->join('product_variants','products.id','=','product_variants.product_id')
            ->join('product_variant_prices','products.id','=','product_variant_prices.product_id')
            ->select('products.*','product_variant_prices.price','product_variant_prices.stock')
            ->orderBy('id','desc')
            ->where('title','LIKE','%'.$request->title.'%')
            ->where('price','>',$request->price_from)
            ->where('price','<',$request->price_to)
            ->whereDate('products.created_at',$request->date);

        $products = $products->get();
        $variants =DB::table('variants')
            ->join('product_variants','variants.id','=','product_variants.variant_id')
            ->select('product_variants.*')
            ->get();

        return view('products.filter',[
            'products'=> $products,
//            'product_variants' => ProductVariant::all(),
            'variants' => $variants,
        ]);
    }
    public function editProduct($id)
    {
        $product = Product::find($id);
        $product_image =ProductImage::where('product_id',$id)->first();
        $product_variant_prices =ProductVariantPrice::where('product_id',$id)->first();
        $variants1 = DB::table('variants')
            ->join('product_variants','variants.id','=','product_variants.variant_id')
            ->select('variants.*','product_variants.product_id','product_variants.variant_id','product_variants.variant')
            ->where('product_variants.product_id',$id)
            ->take(1)
            ->first();
        $variants2 = DB::table('variants')
            ->join('product_variants','variants.id','=','product_variants.variant_id')
            ->select('variants.*','product_variants.product_id','product_variants.variant_id','product_variants.variant')
            ->where('product_variants.product_id',$id)
            ->skip(1)
            ->take(1)
            ->first();
        $variants3 = DB::table('variants')
            ->join('product_variants','variants.id','=','product_variants.variant_id')
            ->select('variants.*','product_variants.product_id','product_variants.variant_id','product_variants.variant')
            ->where('product_variants.product_id',$id)
            ->skip(2)
            ->take(1)
            ->first();
//        return $product_image;

        return view('products.edit',[
            'products' => $product,
            'variant1' => $variants1,
            'variant2' => $variants2,
            'variant3' => $variants3,
            'product_image' => $product_image,
            'product_variant_prices' => $product_variant_prices,

        ]);
    }
    public function updateProduct(Request $request)
    {
        Product::updateProduct($request);
        return redirect(route('product.index'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $variants = Variant::all();
        return view('products.create', compact('variants'));
    }
    public function saveProduct(Request $request)
    {
        Product::saveProduct($request);
//        ProductImage::saveImage($request);
//        ProductVariant::saveVariant($request);
//        ProductVariantPrice::saveVariantPrice($request);
        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $variants = Variant::all();
        return view('products.edit', compact('variants'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
