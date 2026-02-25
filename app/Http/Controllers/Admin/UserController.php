<?php

// app/Http/Controllers/Admin/UserController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Đếm tổng số người dùng (dùng cho pagination info)
        $totalUsers = User::count();

        $query = User::query();

        if ($request->keyword) {
            $query->where('name','like','%'.$request->keyword.'%');
        }

        $users = $query->paginate(5);

        // Nếu là AJAX → trả về partial view
        if ($request->ajax()) {
            return view('admin.users.partials.table', compact('users', 'totalUsers'))->render();
        }

        return view('admin.users.index', compact('users', 'totalUsers'));

    }

    public function create()
    {
        $users = User::where('status',1)->get();
        return view('admin.users.create',compact('users'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required',
            'status' => 'required|boolean',
        ],[
            'name.required' => 'Vui lòng nhập tên',
            'email.required' => 'Vui lòng nhập email',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu tối thiểu 6 ký tự',
            'password.confirmed' => 'Mật khẩu nhập lại không khớp',
            'role.required' => 'Vui lòng chọn quyền',
            'status.required' => 'Vui lòng chọn trạng thái',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success','Thêm thành viên thành công');
    }

    // Xử lý cập nhật
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required',
            'status' => 'required|boolean',
            'password' => 'nullable|min:6|confirmed',
        ],[
            'name.required' => 'Vui lòng nhập tên',
            'role.required' => 'Vui lòng chọn quyền',
            'status.required' => 'Vui lòng chọn trạng thái',
            'password.min' => 'Mật khẩu tối thiểu 6 ký tự',
            'password.confirmed' => 'Mật khẩu nhập lại không khớp',
        ]);

        $data = [
            'name' => $request->name,
            'role' => $request->role,
            'status' => $request->status,
        ];

        // Nếu có nhập mật khẩu mới
        if($request->filled('password')){
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success','Cập nhật thành viên thành công');
    }

    public function ban($id)
    {
        $user = User::findOrFail($id);
        $user->status = 0; // ban
        $user->save();

        return back()->with('success','Đã ban thành viên');
    }

    public function unban($id)
    {
        $user = User::findOrFail($id);
        $user->status = 1; // gỡ ban
        $user->save();

        return back()->with('success','Đã gỡ ban thành viên');
    }

    public function destroy(User $user)
    {
        if ($user->id == auth()->id()) {
            return back()->with('error','Không thể xóa chính mình');
        }

        $user->delete();
        return back()->with('success','Xóa user thành công');
    }
}
