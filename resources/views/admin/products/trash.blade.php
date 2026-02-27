

@if (in_array(auth()->user()->role, ['admin', 'staff']))
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Thùng rác sản phẩm') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('admin.products.index') }}"
                       class="btn btn-sm btn-error text-white mb-4">
                        <i class="fa-solid fa-backward"></i>Quay lại
                    </a>

                    <div class="overflow-x-auto">
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th>Tên sản phẩm</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>
                                        <form action="{{ route('admin.products.restore',$product->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            <button style="background-color: green; color:white;
                                            padding: 6px; border: none; border-radius: 4px; margin-right: 5px; padding-right: 10px;">Khôi phục</button>
                                        </form>

                                        <form action="{{ route('admin.products.forceDelete',$product->id) }}" method="POST"
                                            onsubmit="return confirm('Xóa vĩnh viễn?')" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" style="background-color: red; color:white; padding: 5px;">
                                               Xóa vĩnh viễn
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                {{-- @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>
                            <form action="{{ route('admin.products.restore',$product->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-success btn-sm">Khôi phục</button>
                            </form>

                            <form action="{{ route('admin.products.forceDelete',$product->id) }}" method="POST"
                                onsubmit="return confirm('Xóa vĩnh viễn?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Xóa vĩnh viễn</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach --}}
            </div>
        </div>
    </div>
</x-app-layout>
@endif

