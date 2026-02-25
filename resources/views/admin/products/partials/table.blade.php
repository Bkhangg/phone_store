<table class="table table-zebra">
    <thead>
        <tr>
            <th>#</th>
            <th>Hình ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Danh mục</th>
            <th>Giá</th>
            <th>Trạng thái</th>
            <th>Mô tả</th>
            <th>Hành động</th>
        </tr>
    </thead>

    <tbody>
        @foreach($products as $key => $product)
        <tr>
            <td>{{ $key + 1 }}</td>

            {{-- Ảnh --}}
            <td>
                <img src="{{ asset('storage/'.$product->thumbnail) }}"
                    class="w-16 h-20 object-cover rounded cursor-pointer"
                    onclick="document.getElementById('img-modal-{{ $product->id }}').showModal()">

                {{-- MODAL ẢNH --}}
                <dialog id="img-modal-{{ $product->id }}" class="modal modal-bottom sm:modal-middle">
                    <div class="modal-box w-full max-w-5xl p-3 sm:p-6">
                        <h3 class="font-bold text-base sm:text-lg mb-3 sm:mb-4">
                            Hình ảnh: {{ $product->name }}
                        </h3>

                        <!-- Ảnh đại diện -->
                        <img src="{{ asset('storage/'.$product->thumbnail) }}"
                            class="w-full h-60 sm:h-64 object-contain rounded mb-6 sm:mb-4">

                        @if($product->images->count())
                            <!-- Grid ảnh responsive -->
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
                                @foreach($product->images as $img)
                                    <img src="{{ asset('storage/'.$img->image_path) }}"
                                        class="w-full h-24 sm:h-40 md:h-60 object-cover rounded">
                                @endforeach
                            </div>
                        @endif

                        <div class="modal-action">
                            <form method="dialog">
                                <button class="btn btn-sm sm:btn-md">Đóng</button>
                            </form>
                        </div>
                    </div>
                </dialog>
            </td>

            <td class="font-bold max-w-[300px]">
                <p class="line-clamp-3">
                    {{ $product->name }}
                </p>
            </td>
            <td>{{ $product->category->name ?? 'Chưa có' }}</td>
            <td>
                {{ number_format((int) str_replace(['.', ','], '', $product->price)) }} đ
            </td>

            <td>
                <a href="{{ route('admin.products.toggleStatus', $product->id) }}"
                onclick="return confirm('Bạn có muốn đổi trạng thái sản phẩm này không?')">

                    @if($product->status == 1)
                        <span class="badge badge-success text-white text-[11px] px-1.5 cursor-pointer">
                            <i class="fa-solid fa-eye text-xs"></i> Hiện
                        </span>
                    @else
                        <span class="badge badge-error text-white text-[11px] px-1.5 cursor-pointer">
                            <i class="fa-solid fa-ban"></i> Ẩn
                        </span>
                    @endif

                </a>
            </td>

            {{-- MÔ TẢ --}}
            <td>

                <button style="background-color: rgb(103, 178, 222); color:white; padding: 6px; border: none; border-radius: 4px;"
                    onclick="document.getElementById('desc-modal-{{ $product->id }}').showModal()">
                    <i class="fa-regular fa-eye"></i> Xem
                </button>

                {{-- MODAL MÔ TẢ --}}
                <dialog id="desc-modal-{{ $product->id }}" class="modal">
                    <div class="modal-box w-11/12 max-w-2xl">
                        <h3 class="font-bold text-lg mb-3">
                            {{ $product->name }}
                        </h3>

                        <div class="prose max-w-none">
                            {!! $product->description !!}
                        </div>

                        <div class="modal-action">
                            <form method="dialog">
                                <button style="background-color: rgb(117, 105, 229); color:white; padding: 6px; border: none; border-radius: 4px;">Đóng</button>
                            </form>
                        </div>
                    </div>
                </dialog>
            </td>

            <td class="flex gap-2 mt-6">
                <a href="{{ route('admin.products.edit',$product->id) }}"
                   class="btn btn-warning btn-sm text-white"><i class="fa-solid fa-pen-to-square"></i></a>

                <form action="{{ route('admin.products.destroy',$product->id) }}"
                      method="POST"
                      onsubmit="return confirm('Xóa sản phẩm?')">
                    @csrf
                    @method('DELETE')
                    <button style="background-color: red; color:white;
                    padding: 6px; border: none; border-radius: 4px;"><i class="fa-solid fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

