@if (auth()->user()->role == 'admin')
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
                            Tổng thành viên <div class="badge badge-sm badge-secondary">{{ $totalUsers > 0 ? '+' . $totalUsers : 'Không có' }} </div>
                        </button>
                    </div>

                    <a href="{{ route('admin.users.create') }}"
                       class="btn btn-primary mb-4 text-white">
                        + Thêm thành viên
                    </a>

                    <input type="text"
                    id="search"
                    placeholder="Tìm thành viên..."
                    class="input input-bordered w-full max-w-xs mb-4">

                    <div class="overflow-x-auto">
                        <div id="user-table">
                            @include('admin.users.partials.table')
                        </div>
                    </div>

                    <div class="mt-4">
                        {{ $users->links('pagination::tailwind') }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
const searchInput = document.getElementById('search');

searchInput.addEventListener('keyup', function () {
    let keyword = this.value;

    fetch("{{ route('admin.users.index') }}?keyword=" + encodeURIComponent(keyword), {
        headers: {
            "X-Requested-With": "XMLHttpRequest"
        }
    })
    .then(res => res.text())
    .then(html => {
        document.getElementById('user-table').innerHTML = html;
    });
});
</script>
@endif
