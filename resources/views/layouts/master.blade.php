<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'FastPrint') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .btn-primary { @apply bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300; }
        .btn-danger { @apply bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-300; }
        .btn-secondary { @apply bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-300; }
        .form-input { @apply w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500; }
        .form-label { @apply block text-sm font-medium text-gray-700 mb-1; }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-800">
    <nav class="bg-white shadow-md mb-8">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('products.index') }}" class="text-2xl font-bold text-blue-600">FastPrint Test</a>
            <div>
                <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-blue-600 px-3">Produk</a>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-6">
        @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: "{{ session('success') }}",
                        timer: 2000,
                        showConfirmButton: false
                    });
                });
            </script>
        @endif

        @yield('content')
    </main>

    <footer class="mt-12 text-center text-gray-500 py-6">
        &copy; {{ date('Y') }} Junior Programmer Test
    </footer>

    @stack('scripts')
</body>
</html>
