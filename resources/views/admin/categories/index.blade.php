@if (in_array(auth()->user()->role, ['admin', 'staff']))
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Trang Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
             <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <button class="btn">
                            Tổng danh mục <div class="badge badge-sm badge-secondary">{{ $totalCategories > 0 ? '+' . $totalCategories : 'Không có' }} </div>
                        </button>
                    </div>
                    <a href="{{ route('admin.categories.create') }}"
                    class="btn btn-primary mb-4 text-white">
                        <i class="fa-solid fa-plus"></i>Thêm danh mục
                    </a>
                    <input type="text"
                        id="search"
                        placeholder="Tìm danh mục..."
                        class="input input-bordered w-full max-w-xs mb-4">

                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="table table-zebra">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên danh mục</th>
                                    <th>Số lượng sản phẩm</th>
                                    <th>Slug</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>

                            <tbody id="category-table">
                                @include('admin.categories.partials.rows')
                            </tbody>
                        </table>

                    </div>

                </div>
                <div class="mt-4">
                    {{ $categories->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
const searchInput = document.getElementById('search');

searchInput.addEventListener('keyup', function () {
    let keyword = this.value;

    fetch("{{ route('admin.categories.index') }}?keyword=" + encodeURIComponent(keyword), {
        headers: {
            "X-Requested-With": "XMLHttpRequest"
        }
    })
    .then(res => res.text())
    .then(html => {
        document.getElementById('category-table').innerHTML = html;
    });
});
</script>
@endif
