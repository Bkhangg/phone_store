<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductService
{
    public function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    public function createProduct(Request $request)
    {


            $thumb = $request->file('thumbnail')->store('products','public');

            $slug = $this->generateUniqueSlug($request->name);

            $product = Product::create([
                'name' => $request->name,
                'slug' => $slug,
                'category_id' => $request->category_id,
                'price' => $request->price,
                'thumbnail' => $thumb,
                'description' => $request->description,
                'status' => $request->status ?? 1
            ]);

            if($request->hasFile('images')){
                foreach($request->file('images') as $img){
                    $path = $img->store('products','public');
                    ProductImage::create([
                        'product_id'=>$product->id,
                        'image_path'=>$path
                    ]);
                }
            }
    }

    public function updateProduct($product, $request)
    {
        $data = $request->only(['name','price','category_id','description','status']);
        $data['slug'] = $this->generateUniqueSlug($request->name);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('products','public');
        }

        $product->update($data);
    }

}
