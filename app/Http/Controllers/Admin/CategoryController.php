<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        // Đếm tổng số sản phẩm (dùng cho pagination info)
        $totalCategories = Category::count();

        $query = Category::withCount('products');

        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('slug', 'like', '%' . $request->keyword . '%');
        }

        $categories = $query->latest()->paginate(5);

        // Nếu là request ajax thì chỉ trả tbody
        if ($request->ajax()) {
            return view('admin.categories.partials.rows', compact('categories', 'totalCategories'))->render();
        }

        return view('admin.categories.index', compact('categories', 'totalCategories'));
    }

    public function create() {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name'
        ], [
            'name.required' => 'Tên danh mục không được để trống',
            'name.unique'   => 'Tên danh mục đã tồn tại'
        ]);

        Category::create([
            'name'   => $request->name,
            'slug'   => Str::slug($request->name),
            'status' => $request->status ?? 1
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Thêm danh mục thành công');
    }

    public function edit(Category $category) {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'status' => 'required|boolean',
        ], [
            'name.required' => 'Tên danh mục không được để trống',
            'name.unique' => 'Danh mục này đã tồn tại',
            'status.required' => 'Vui lòng chọn trạng thái',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->status
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success','Cập nhật danh mục thành công');
    }

    public function destroy(Category $category)
    {
        // Nếu còn sản phẩm → không cho xóa
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Danh mục đang có sản phẩm, không thể xóa.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Xóa danh mục thành công');
    }
}
