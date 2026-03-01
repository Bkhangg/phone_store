<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }


    private function generateUniqueSlug($name)
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

    public function index(Request $request)
    {
        // Đếm tổng số sản phẩm (dùng cho pagination info)
        $totalProducts = Product::count();

        $query = Product::query();

        if ($request->keyword) {
            $query->where('name', 'like', '%' . $request->keyword . '%')
                  ->orWhere('email', 'like', '%' . $request->keyword . '%');
        }

        $products = $query->paginate(5);

        // Nếu là AJAX → chỉ trả bảng
        if ($request->ajax()) {
            return view('admin.products.partials.table', compact('products','totalProducts'))->render();
        }

        return view('admin.products.index', compact('products','totalProducts'));
    }

    public function create()
    {
        $categories = Category::where('status',1)->get();
        return view('admin.products.create',compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {

        // Tạo sản phẩm qua service
        $this->productService->createProduct($request);

        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công');

    }

    public function edit(Product $product)
    {
        $categories = Category::where('status',1)->get();
        return view('admin.products.edit',compact('product','categories'));
    }


    public function update(UpdateProductRequest $request, Product $product)
    {
        // tạo slug KHÔNG TRÙNG (trừ chính nó)
        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $count = 1;

        while (
            Product::where('slug', $slug)
                ->where('id', '!=', $product->id)
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        $this->productService->updateProduct($product, $request);

        return redirect()->route('admin.products.index')
            ->with('success','Cập nhật sản phẩm thành công');

        // $data = $request->only(['name','price','category_id','description','status']);
        // $data['slug'] = $slug;

        // if ($request->hasFile('thumbnail')) {
        //     $data['thumbnail'] = $request->file('thumbnail')->store('products','public');
        // }

        // $product->update($data);

        // return redirect()->route('admin.products.index')
        //     ->with('success','Cập nhật sản phẩm thành công');
    }

    public function toggleStatus($id)
    {
        $product = Product::findOrFail($id);
        $product->status = $product->status == 1 ? 0 : 1;
        $product->save();

        return back();
    }


    public function destroy(Product $product)
    {
        $product->delete(); // soft delete
        return back()->with('success','Đã chuyển sản phẩm vào thùng rác');
    }

    public function trash()
    {
        $products = Product::onlyTrashed()->paginate(5);
        return view('admin.products.trash', compact('products'));
    }

    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('admin.products.index')->with('success','Khôi phục sản phẩm thành công');
    }

    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);

        // xóa ảnh nếu muốn
        if ($product->thumbnail) {
            Storage::disk('public')->delete($product->thumbnail);
        }

        $product->forceDelete();

        return back()->with('success','Đã xóa vĩnh viễn sản phẩm');
    }

    public function destroyImage($id)
    {
        ProductImage::findOrFail($id)->delete();
        return back()->with('success', 'Xóa ảnh sản phẩm thành công');
    }
}
