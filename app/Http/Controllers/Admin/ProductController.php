<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Psy\Util\Str;

class ProductController extends Controller
{
    public function index(Request $request) {
        $products = Product::with('category')
            ->when($request->search, function($q) use ($request){
                $q->where('name','like','%'.$request->search.'%');
            })
            ->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function create() {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request) {
        $request->validate([
            'name'=>'required',
            'price'=>'required|numeric',
            'thumbnail'=>'required|image',
        ]);

        $thumb = $request->file('thumbnail')->store('products','public');

        $product = Product::create([
            'category_id'=>$request->category_id,
            'name'=>$request->name,
            'slug'=>Str::slug($request->name),
            'price'=>$request->price,
            'thumbnail'=>$thumb,
            'description'=>$request->description,
            'status'=>$request->status ?? 1,
        ]);

        if($request->hasFile('images')){
            foreach($request->file('images') as $img){
                $path = $img->store('products','public');
                $product->images()->create([
                    'image_path'=>$path
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success','Thêm sản phẩm thành công');
    }
}
