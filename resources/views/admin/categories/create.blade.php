<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Thêm danh mục') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="POST"
                          action="{{ route('admin.categories.store') }}"
                          class="space-y-6 max-w-md mx-auto">
                        @csrf

                        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box border p-4">
                            <legend class="fieldset-legend">Thêm danh mục</legend>

                            <!-- Tên danh mục -->
                            <label class="label">Tên danh mục</label>
                            <input type="text"
                                   class="input input-bordered w-full"
                                   name="name"
                                   value="{{ old('name') }}"
                                   placeholder="Tên danh mục..." />
                            @error('name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror

                            <!-- Trạng thái -->
                            <label class="label">Trạng thái</label>
                            <select class="select select-bordered w-full" name="status">
                                <option value="1">Hiển thị</option>
                                <option value="0">Ẩn</option>
                            </select>

                            <!-- Nút -->
                            <div class="flex items-center gap-4 mt-4">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md
                                        font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500
                                        focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                                        transition ease-in-out duration-150">
                                    Lưu danh mục
                                </button>

                                <a href="{{ route('admin.categories.index') }}"
                                   class="btn btn-sm btn-error text-white">
                                    Quay lại
                                </a>
                            </div>
                        </fieldset>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
