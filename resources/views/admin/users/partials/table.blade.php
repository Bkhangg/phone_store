<table class="table table-zebra">
    <thead>
        <tr>
            <th>#</th>
            <th>Tên</th>
            <th>Email</th>
            <th>Quyền</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $key => $user)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                @if($user->role == 'admin')
                    <span class="badge badge-error text-white">Admin</span>
                @else
                    <span class="badge badge-info text-white">User</span>
                @endif
            </td>
            <td class="flex gap-2">
                <a href="{{ route('admin.users.edit',$user->id) }}"
                class="btn btn-warning btn-sm text-white">
                <i class="fa-solid fa-pen"></i>
                </a>

                <form action="{{ route('admin.users.destroy',$user->id) }}"
                    method="POST"
                    onsubmit="return confirm('Xóa thành viên này?')">
                    @csrf
                    @method('DELETE')
                    <button style="background-color: red; color:white;
                    padding: 6px; border: none; border-radius: 4px;"><i class="fa-solid fa-trash"></i></button>
                </form>
                @if($user->status == 1)
                    <form action="{{ route('admin.users.ban',$user->id) }}" method="POST">
                        @csrf
                        <button style="background-color: red; color:white;
                        padding: 6px; border: none; border-radius: 4px;">Ban</button>
                    </form>
                @else
                    <form action="{{ route('admin.users.unban',$user->id) }}" method="POST">
                        @csrf
                        <button style="background-color: rgb(70, 130, 221); color:white;
                        padding: 6px; border: none; border-radius: 4px;"><font style="font-size: 10px;">Gỡ Ban</font></button>
                    </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
