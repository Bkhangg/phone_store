@foreach($categories as $key => $cat)
<tr>
    <td>{{ $key + 1 }}</td>
    <td><div class="font-bold">{{ $cat->name }}</div></td>
    <td>{{ $cat->slug }}</td>
    <td>
        @if($cat->status == 1)
            <span class="badge badge-success text-white text-[11px] px-1.5">
                <i class="fa-solid fa-eye text-xs"></i>Hiện
            </span>
        @else
            <span class="badge badge-error text-white text-[11px] px-1.5">
                <i class="fa-solid fa-ban"></i>Ẩn
            </span>
        @endif
    </td>
    <td class="flex gap-2">
        <a href="{{ route('admin.categories.edit', $cat->id) }}"
           class="btn btn-sm btn-warning text-white">Sửa</a>

        <form action="{{ route('admin.categories.destroy', $cat->id) }}"
              method="POST" onsubmit="return confirm('Xóa danh mục này?')">
            @csrf
            @method('DELETE')
            <button style="background-color: red; color:white; padding: 6px; border: none; border-radius: 4px;">Xóa</button>
        </form>
    </td>
</tr>
@endforeach
