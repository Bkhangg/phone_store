<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Sửa sản phẩm</h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto">
        <form action="{{ route('admin.products.update',$product->id) }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-4 bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')

            {{-- Tên --}}
            <div>
                <label class="label">Tên sản phẩm</label>
                <input type="text" name="name"
                       value="{{ old('name',$product->name) }}"
                       class="input input-bordered w-full">
            </div>

            {{-- Giá --}}
            <div>
                <label class="label">Giá</label>
                <input type="text" id="price_display"
                    value="{{ number_format(old('price', $product->price)) }}"
                    class="input input-bordered w-full">

                <input type="hidden" name="price" id="price">
            </div>

            {{-- Danh mục --}}
            <div>
                <label class="label">Danh mục</label>
                <select name="category_id" class="select select-bordered w-full">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Mô tả --}}
            <div>
                <label class="label">Mô tả</label>
                <textarea name="description"
                    id="editor"
                    class="textarea textarea-bordered w-full"
                    rows="4">{{ old('description', $product->description) }}</textarea>
            </div>

            {{-- Trạng thái --}}
            <div>
                <label class="label">Trạng thái</label>
                <select name="status" class="select select-bordered w-full">
                    <option value="1" {{ $product->status==1?'selected':'' }}>Hiển thị</option>
                    <option value="0" {{ $product->status==0?'selected':'' }}>Ẩn</option>
                </select>
            </div>

            {{-- Ảnh chính hiện tại --}}
            <div>
                <label class="label">Ảnh hiện tại</label>
                <img id="thumbnail-preview"
                    src="{{ asset('storage/'.$product->thumbnail) }}"
                    class="w-32 rounded mt-2">
            </div>

            {{-- Đổi ảnh chính --}}
            <div>
                <label class="label">Đổi ảnh chính</label>
                <input type="file" name="thumbnail"
                    id="thumbnail-input"
                    class="file-input file-input-bordered w-full">
            </div>

            {{-- Ảnh phụ --}}
            <div>
                <label class="label">Ảnh phụ hiện tại</label>
                <div id="images-preview" class="grid grid-cols-5 gap-2">
                    @foreach($product->images as $img)
                        <img src="{{ asset('storage/'.$img->image_path) }}"
                            class="h-20 object-cover rounded">
                    @endforeach
                </div>
            </div>

            {{-- Thêm ảnh phụ mới --}}
            <div>
                <label class="label">Thêm ảnh phụ</label>
                <input type="file" name="images[]" multiple
                    id="images-input"
                    class="file-input file-input-bordered w-full">
            </div>

            <div class="flex items-center gap-4 mt-4">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md
                        font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500
                        focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                        transition ease-in-out duration-150">
                    Cập nhật sản phẩm
                </button>

                <a href="{{ route('admin.products.index') }}"
                    class="btn btn-sm btn-error text-white">
                    Quay lại
                </a>
            </div>
        </form>
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
    document.getElementById('thumbnail-input').addEventListener('change', function(e) {
        const preview = document.getElementById('thumbnail-preview');
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('images-input').addEventListener('change', function(e) {
        const previewContainer = document.getElementById('images-preview');
        previewContainer.innerHTML = '';
        const files = e.target.files;
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('h-20', 'object-cover', 'rounded');
                previewContainer.appendChild(img);
            }
            reader.readAsDataURL(file);
        }
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

{{-- JS format + strip dấu chấm giá tiền --}}
<script>
const priceDisplay = document.getElementById('price_display');
const priceHidden = document.getElementById('price');

function formatNumber(val){
    val = val.replace(/\D/g,'');
    return val.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// set giá trị ban đầu cho hidden
priceHidden.value = priceDisplay.value.replace(/\./g,'');

priceDisplay.addEventListener('input', function(){
    let raw = this.value.replace(/\./g,'');
    this.value = formatNumber(raw);
    priceHidden.value = raw;
});
</script>
