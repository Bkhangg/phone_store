@if (auth()->user()->role == 'admin')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Thêm thành viên</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-12xl mx-auto sm:px-5 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
            <div class="py-6 max-w-xl mx-auto">
                <fieldset class="fieldset bg-base-200 border-base-300 rounded-box border p-4">
                    <legend class="fieldset-legend">Thêm thành viên</legend>
                            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                                @csrf

                                <div>
                                    <label>Tên</label>
                                    <input type="text" name="name" class="input input-bordered w-full" value="{{ old('name') }}">
                                    @error('name') <p class="text-red-500">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label>Email</label>
                                    <input type="email" name="email" class="input input-bordered w-full" value="{{ old('email') }}">
                                    @error('email') <p class="text-red-500">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label>Mật khẩu</label>
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
                                        <option value="">-- Chọn quyền --</option>
                                        <option value="admin">Admin</option>
                                        <option value="staff">Staff</option>
                                        <option value="user">User</option>
                                    </select>
                                    @error('role') <p class="text-red-500">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label>Trạng thái</label>
                                    <select name="status" class="select select-bordered w-full">
                                        <option value="1">Hoạt động</option>
                                        <option value="0">Bị khóa</option>
                                    </select>
                                </div>

                                <div class="flex flex-col sm:flex-row gap-2 mt-4">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md
                                        font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500
                                        focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                                        transition ease-in-out duration-150">
                                     Thêm thành viên
                                </button>

                                <a href="{{ route('admin.users.index') }}"
                                class="btn btn-sm btn-error text-white w-full sm:w-auto">
                                    Quay lại
                                </a>
                            </div>
                            </form>
                </fieldset>

            </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@endif
