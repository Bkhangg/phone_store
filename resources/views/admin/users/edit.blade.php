@if (auth()->user()->role == 'admin')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Sửa thành viên</h2>
    </x-slot>

        <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="py-6 max-w-xl mx-auto">
                    <form action="{{ route('admin.users.update',$user->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box border p-4">
                            <legend class="fieldset-legend">Thêm sản phẩm</legend>
                        <div>
                            <label>Tên</label>
                            <input type="text" name="name"
                                class="input input-bordered w-full"
                                value="{{ old('name',$user->name) }}">
                            @error('name') <p class="text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label>Email</label>
                            <input type="email"
                                class="input input-bordered w-full"
                                value="{{ $user->email }}" disabled>
                        </div>

                        <div>
                            <label>Mật khẩu mới (bỏ trống nếu không đổi)</label>
                            <input type="password" name="password" class="input input-bordered w-full">
                            @error('password') <p class="text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label>Nhập lại mật khẩu</label>
                            <input type="password" name="password_confirmation" class="input input-bordered w-full">
                        </div>

                        <div>
                            <label>Quyền</label>
                            <select name="role" class="select select-bordered w-full">
                                <option value="admin" {{ $user->role=='admin'?'selected':'' }}>Admin</option>
                                <option value="staff" {{ $user->role=='staff'?'selected':'' }}>Staff</option>
                                <option value="user" {{ $user->role=='user'?'selected':'' }}>User</option>
                            </select>
                        </div>

                        <div>
                            <label>Trạng thái</label>
                            <select name="status" class="select select-bordered w-full">
                                <option value="1" {{ $user->status==1?'selected':'' }}>Hoạt động</option>
                                <option value="0" {{ $user->status==0?'selected':'' }}>Bị khóa</option>
                            </select>
                        </div>

                        <div class="flex items-center gap-4 mt-4">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md
                                    font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500
                                    focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                                    transition ease-in-out duration-150">
                                Cập nhật thành viên
                            </button>

                            <a href="{{ route('admin.users.index') }}"
                                class="btn btn-sm btn-error text-white">
                                Quay lại
                            </a>
                        </div>
                        </fieldset>

                    </form>
                </div>
            </div>
        </div>

</x-app-layout>
@endif
