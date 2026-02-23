<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    @vite(['resources/css/app.css','resources/js/app.js'])

    {{-- Toastr --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    {{-- font awsome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-white shadow">
        <div class="p-4 font-bold text-xl">ADMIN</div>
        <ul class="space-y-2 px-4">
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('admin.categories.index') }}">Danh mục</a></li>
            <li><a href="{{ route('admin.products.index') }}">Sản phẩm</a></li>
        </ul>
    </aside>

    {{-- CONTENT --}}
    <main class="flex-1 p-6">
        @yield('content')
    </main>

</div>

{{-- JS --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
toastr.options = {
    closeButton: true,
    progressBar: true,
    positionClass: "toast-top-right",
    timeOut: 3000,
};

@if(session('success'))
    toastr.success("{{ session('success') }}");
@endif
@if(session('error'))
    toastr.error("{{ session('error') }}");
@endif
@if($errors->any())
    @foreach($errors->all() as $err)
        toastr.error("{{ $err }}");
    @endforeach
@endif
</script>
</body>
</html>
