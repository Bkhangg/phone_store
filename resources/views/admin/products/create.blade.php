
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Thêm sản phẩm') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-12xl mx-auto sm:px-5 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST"
                        action="{{ route('admin.products.store') }}"
                        enctype="multipart/form-data"
                        class="space-y-4 max-w-3xl">
                        @csrf

                        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box border p-4">
                            <legend class="fieldset-legend">Thêm sản phẩm</legend>

                            <!-- Grid responsive -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                <!-- Tên sản phẩm -->
                                <div class="md:col-span-2">
                                    <label class="label text-sm">Tên sản phẩm</label>
                                    <input type="text"
                                        class="input input-bordered input-sm w-full"
                                        name="name"
                                        value="{{ old('name') }}"
                                        placeholder="Tên sản phẩm..." />
                                    @error('name')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Danh mục -->
                                <div>
                                    <label class="label text-sm">Danh mục</label>
                                    <select class="select select-bordered w-full" name="category_id">
                                        <option value="">-- Chọn danh mục --</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}"
                                                {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Giá -->
                                <div>
                                    <label class="label text-sm">Giá</label>
                                    <input type="text" id="price"
                                        name="price"
                                        value="{{ old('price', $product->price ?? '') }}"
                                        class="input input-bordered w-full"
                                        placeholder="Nhập giá...">
                                    @error('price')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Ảnh đại diện -->
                                <div>
                                    <label class="label">Ảnh chính</label>
                                    <input type="file" name="thumbnail" id="thumbnailInput"
                                        class="file-input file-input-bordered w-full">

                                    <img id="thumbnailPreview"
                                        class="mt-2 w-32 h-32 object-cover rounded hidden">
                                    @error('thumbnail')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Ảnh phụ -->
                                <div>
                                    <label class="label">Ảnh phụ</label>
                                    <input type="file" name="images[]" id="imagesInput" multiple
                                        class="file-input file-input-bordered w-full">

                                    <div id="imagesPreview" class="mt-2 grid grid-cols-5 gap-2"></div>

                                    @error('images.*')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Mô tả -->
                                <div class="md:col-span-2">
                                    <label class="label text-sm">Mô tả</label>
                                    <textarea name="description"
                                        id="editor"
                                        class="textarea textarea-bordered textarea-sm w-full"
                                        rows="4"
                                        placeholder="Mô tả sản phẩm...">{{ old('description') }}</textarea>
                                </div>

                                <!-- Trạng thái -->
                                <div>
                                    <label class="label">Trạng thái</label>
                                    <select class="select select-bordered w-full" name="status">
                                        <option value="1">Hiển thị</option>
                                        <option value="0">Ẩn</option>
                                    </select>
                                </div>

                            </div>

                            <!-- Nút -->
                            <div class="flex flex-col sm:flex-row gap-2 mt-4">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md
                                        font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500
                                        focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                                        transition ease-in-out duration-150">
                                     Thêm sản phẩm
                                </button>

                                <a href="{{ route('admin.products.index') }}"
                                class="btn btn-sm btn-error text-white w-full sm:w-auto">
                                    Quay lại
                                </a>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.0/classic/ckeditor.js"></script>

    <script>
    ClassicEditor
        .create(document.querySelector('#editor'), {
            language: 'vi'
        })
        .catch(error => {
            console.error(error);
        });
    </script>
</x-app-layout>

{{-- Script để xem trước ảnh --}}
<script>
document.getElementById('thumbnailInput').addEventListener('change', function(e){
    const file = e.target.files[0];
    if(file){
        document.getElementById('thumbnailPreview').src = URL.createObjectURL(file);
        document.getElementById('thumbnailPreview').classList.remove('hidden');
    }
});

document.getElementById('imagesInput').addEventListener('change', function(e){
    const preview = document.getElementById('imagesPreview');
    preview.innerHTML = "";

    Array.from(e.target.files).forEach(file => {
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.className = "w-24 h-24 object-cover rounded";
        preview.appendChild(img);
    });
});
</script>

{{-- Nhập giá tiền format --}}
<script>
const priceInput = document.getElementById('price');

priceInput.addEventListener('input', function (e) {
    let value = this.value.replace(/\D/g, ''); // bỏ ký tự không phải số

    if (value === '') {
        this.value = '';
        return;
    }

    // format có dấu chấm
    this.value = new Intl.NumberFormat('vi-VN').format(value);
});

// Trước khi submit form → bỏ dấu chấm
document.querySelector('form').addEventListener('submit', function () {
    let raw = priceInput.value.replace(/\./g, '');
    priceInput.value = raw;
});
</script>
