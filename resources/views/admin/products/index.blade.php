@if (in_array(auth()->user()->role, ['admin', 'staff']))
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quản lý sản phẩm') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <button class="btn">
                            Tổng sản phẩm <div class="badge badge-sm badge-secondary">{{ $totalProducts > 0 ? '+' . $totalProducts : 'Không có' }} </div>
                        </button>
                    </div>

                    <a href="{{ route('admin.products.create') }}"
                       class="btn btn-primary mb-4 text-white">
                        + Thêm sản phẩm
                    </a>

                    <input type="text"
                    id="search"
                    placeholder="Tìm sản phẩm..."
                    class="input input-bordered w-full max-w-xs mb-4">

                    <a href="{{ route('admin.products.trash') }}" class="btn btn-info mb-4 text-white">
                        🗑 Thùng rác
                    </a>

                    <div class="overflow-x-auto">
                        <div id="product-table">
                            @include('admin.products.partials.table')
                        </div>
                    </div>

                    <div class="mt-4">
                        {{ $products->links('pagination::tailwind') }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@endif
<script>
const searchInput = document.getElementById('search');

searchInput.addEventListener('keyup', function () {
    let keyword = this.value;

    fetch("{{ route('admin.products.index') }}?keyword=" + encodeURIComponent(keyword), {
        headers: {
            "X-Requested-With": "XMLHttpRequest"
        }
    })
    .then(res => res.text())
    .then(html => {
        document.getElementById('product-table').innerHTML = html;
    });
});
</script>
