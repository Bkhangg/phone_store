<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    private function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $count = Product::where('slug', 'like', $slug.'%')->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }

    public function index(Request $request)
    {
        // Đếm tổng số sản phẩm (dùng cho pagination info)
        $totalProducts = Product::count();

        $query = Product::with(['category','images']);

        if ($request->keyword) {
            $query->where('name','like','%'.$request->keyword.'%');
        }

        $products = $query->paginate(5);

        // Nếu là AJAX → trả về partial view
        if ($request->ajax()) {
            return view('admin.products.partials.table', compact('products', 'totalProducts'))->render();
        }

        return view('admin.products.index', compact('products', 'totalProducts'));
    }

    public function create()
    {
        $categories = Category::where('status',1)->get();
        return view('admin.products.create',compact('categories'));
    }

    public function store(Request $request)
    {
        if ($request->filled('price')) {
            $request->merge([
                'price' => str_replace([',','.'], '', $request->price)
            ]);
        }

        $request->validate([
            'name' => 'required|unique:products,name',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required',
            'thumbnail' => 'required|image',
            'images.*' => 'image',
            'description' => 'nullable|string'
        ],
        [
            'name.required' => 'Vui lòng nhập tên sản phẩm',
            'name.unique' => 'Tên sản phẩm đã tồn tại',
            'price.required' => 'Vui lòng nhập giá sản phẩm',
            'price.numeric' => 'Giá phải là số',
            'category_id.required' => 'Vui lòng chọn danh mục',
            'thumbnail.required' => 'Vui lòng chọn ảnh chính',
            'thumbnail.image' => 'Ảnh chính phải là file hình ảnh',
            'images.*.image' => 'Ảnh phụ phải là file hình ảnh',
            'description.string' => 'Mô tả không hợp lệ'
        ]);

        $thumb = $request->file('thumbnail')->store('products','public');

        $slug = $this->generateUniqueSlug($request->name);

        $product = Product::create([
            'name'=>$request->name,
            'slug'=>Str::slug($request->name),
            'category_id'=>$request->category_id,
            'price'=>$request->price,
            'thumbnail'=>$thumb,
            'description'=>$request->description,
            'status'=>$request->status ?? 1
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

        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('status',1)->get();
        return view('admin.products.edit',compact('product','categories'));
    }


    public function update(Request $request, Product $product)
    {
        // XÓA dấu . và ,
        if ($request->filled('price')) {
            $request->merge([
                'price' => str_replace([',','.'], '', $request->price)
            ]);
        }

        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required',
        ],
        [
            'name.required' => 'Vui lòng nhập tên sản phẩm',
            'price.required' => 'Vui lòng nhập giá sản phẩm',
            'price.numeric' => 'Giá phải là số',
            'category_id.required' => 'Vui lòng chọn danh mục',
        ]);

        $data = $request->only(['name','price','category_id','description','status']);
        $data['slug'] = Str::slug($request->name);

        if($request->hasFile('thumbnail')){
            $data['thumbnail'] = $request->file('thumbnail')->store('products','public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success','Cập nhật sản phẩm thành công');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Xóa sản phẩm thành công');
    }

    public function destroyImage($id)
    {
        ProductImage::findOrFail($id)->delete();
        return back()->with('success', 'Xóa ảnh sản phẩm thành công');
    }
}
