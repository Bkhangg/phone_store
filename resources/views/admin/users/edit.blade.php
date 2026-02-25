<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Sửa thành viên</h2>
    </x-slot>

    <div class="py-6 max-w-xl mx-auto">
        <form action="{{ route('admin.users.update',$user->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

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

            <button class="btn btn-primary w-full">Cập nhật</button>
        </form>
    </div>
</x-app-layout>
