@foreach($categories as $key => $cat)
<tr>
    <td>{{ $key + 1 }}</td>
    <td>
        <div class="font-bold">{{ $cat->name  }}

        </div>
    </td>
    <td>
        <span class="badge badge-info text-white text-[11px] px-1.5 ml-2">
            {{ $cat->products_count }} sản phẩm <i class="fa-brands fa-product-hunt fa-lg"></i>
        </span>
    </td>
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
           class="btn btn-sm btn-warning text-white"><i class="fa-solid fa-pen-to-square"></i></a>

        <form action="{{ route('admin.categories.destroy', $cat->id) }}"
              method="POST" onsubmit="return confirm('Xóa danh mục này?')">
            @csrf
            @method('DELETE')
            <button style="background-color: red; margin: 2px; color:white;
            padding: 6px; border: none; border-radius: 4px;"><i class="fa-solid fa-trash"></i> </button>
        </form>
    </td>
</tr>
@endforeach
