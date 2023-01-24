<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use ProductImage;
//use ProductVariant;
//use ProductVariantPrice;

class Product extends Model
{
    use HasFactory;
    public static $image,$imageNewName,$directory,$imgUrl;

    public static $product, $productId, $product_image,$product_variant1, $product_variant2, $product_variant3, $product_variant_prices,
        $product_variant1Id, $product_variant2Id, $product_variant3Id;

    public static function saveProduct($request)
    {
        self::$product = new Product();
        self::$product->title = $request->product_name;
        self::$product->sku = $request->product_sku;
        self::$product->description = $request->product_description;
        self::$product->save();

        self::$productId = self::$product->orderBy('id','desc')->take(1)->first();
        self::$productId = self::$productId->id;

        self::$product_image = new ProductImage();
        self::$product_image->product_id = self::$productId;
        self::$product_image->file_path = self::saveImage($request);
        self::$product_image->save();

        self::$product_variant1 = new ProductVariant();
        self::$product_variant1->variant = $request->product_variant1;
        self::$product_variant1->variant_id = $request->variant_id1;
        self::$product_variant1->product_id = self::$productId;
        self::$product_variant1->save();

        self::$product_variant2 = new ProductVariant();
        self::$product_variant2->variant = $request->product_variant2;
        self::$product_variant2->variant_id = $request->variant_id2;
        self::$product_variant2->product_id = self::$productId;
        self::$product_variant2->save();

        self::$product_variant3 = new ProductVariant();
        self::$product_variant3->variant = $request->product_variant3;
        self::$product_variant3->variant_id = $request->variant_id3;
        self::$product_variant3->product_id = self::$productId;
        self::$product_variant3->save();

        self::$product_variant1Id = self::$product_variant1->orderBy('id','desc')->skip(2)->take(1)->first();
        self::$product_variant1Id = self::$product_variant1Id->id;
        self::$product_variant2Id = self::$product_variant2->orderBy('id','desc')->skip(1)->take(1)->first();
        self::$product_variant2Id = self::$product_variant2Id->id;
        self::$product_variant3Id = self::$product_variant3->orderBy('id','desc')->take(1)->first();
        self::$product_variant3Id = self::$product_variant3Id->id;

        self::$product_variant_prices = new ProductVariantPrice();
        self::$product_variant_prices->product_variant_one = self::$product_variant1Id;
        self::$product_variant_prices->product_variant_two = self::$product_variant2Id;
        self::$product_variant_prices->product_variant_three = self::$product_variant3Id;
        self::$product_variant_prices->price = $request->product_price;
        self::$product_variant_prices->stock = $request->product_stoke;
        self::$product_variant_prices->product_id = self::$productId;
        self::$product_variant_prices->save();
        return redirect(route('product.create'));
    }

    private static function saveImage($request)
    {
        self::$image = $request->file('product_image');
        if (self::$image)
        {
            if (self::$product)
            {
                if (file_exists(self::$product_image->file_path))
                {
                    unlink(self::$product_image->file_path);
                }
            }
            self::$imageNewName = rand().'.'.self::$image->getClientOriginalExtension();
            self::$directory = 'product_image/';
            self::$imgUrl = self::$directory.self::$imageNewName;
            self::$image->move(self::$directory,self::$imageNewName);
        }
        else
        {
            self::$imgUrl = self::$product_image->file_path;
        }

        return self::$imgUrl;
    }
    public static function updateProduct($request)
    {
        self::$product = Product::find($request->product_id);
        self::$product->title = $request->product_name;
        self::$product->sku = $request->product_sku;
        self::$product->description = $request->product_description;
        self::$product->save();
        ;
        self::$productId = self::$product->id;

        self::$product_image = ProductImage::find($request->product_image_id);
        self::$product_image->product_id = self::$productId;
        self::$product_image->file_path = self::saveImage($request);
        self::$product_image->save();

        self::$product_variant1 = ProductVariant::find($request->product_variant_id1);
        self::$product_variant1Id = self::$product_variant1->id;
        self::$product_variant1->variant = $request->product_variant1;
        self::$product_variant1->variant_id = self::$product_variant1->variant_id;
        self::$product_variant1->product_id = self::$productId;
        self::$product_variant1->save();

        self::$product_variant2 = ProductVariant::find($request->product_variant_id2);
        self::$product_variant2Id = self::$product_variant2->id;
        self::$product_variant2->variant = $request->product_variant2;
        self::$product_variant2->variant_id = self::$product_variant2->variant_id;
        self::$product_variant2->product_id = self::$productId;
        self::$product_variant2->save();

        self::$product_variant3 = ProductVariant::find($request->product_variant_id3);
        self::$product_variant3Id = self::$product_variant3->id;
        self::$product_variant3->variant = $request->product_variant3;
        self::$product_variant3->variant_id = self::$product_variant3->variant_id;
        self::$product_variant3->product_id = self::$productId;
        self::$product_variant3->save();

//        self::$product_variant1Id = self::$product_variant1;
//        self::$product_variant2Id = self::$product_variant2;
//        self::$product_variant3Id = self::$product_variant3;

        self::$product_variant_prices = ProductVariantPrice::find($request->product_variant_prices_id);
        self::$product_variant_prices->product_variant_one = self::$product_variant1Id;
        self::$product_variant_prices->product_variant_two = self::$product_variant2Id;
        self::$product_variant_prices->product_variant_three = self::$product_variant3Id;
        self::$product_variant_prices->price = $request->product_price;
        self::$product_variant_prices->stock = $request->product_stoke;
        self::$product_variant_prices->product_id = self::$productId;
        self::$product_variant_prices->save();
        return redirect(route('product.index'));
    }
}
