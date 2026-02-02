@extends('layouts.master')

@section('content')
<div class="bg-white rounded-xl shadow-lg p-6">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Daftar Produk</h1>
            <p class="text-gray-500 text-sm">Menampilkan produk</p>
        </div>
        <a href="{{ route('products.create') }}" class="btn-primary flex items-center gap-2">
            <span>+ Tambah Produk</span>
        </a>
    </div>

    <!-- Filter Form -->
    <form action="{{ route('products.index') }}" method="GET" class="mb-6 bg-gray-50 p-4 rounded-lg flex flex-wrap gap-4 items-end">
        <div class="flex-1 min-w-[200px]">
            <label class="form-label text-xs">Cari Nama</label>
            <input type="text" name="search" value="{{ request('search') }}" class="form-input text-sm" placeholder="Nama Produk...">
        </div>
        <div class="min-w-[150px]">
            <label class="form-label text-xs">Kategori</label>
            <select name="kategori_id" class="form-input text-sm">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id_kategori }}" {{ request('kategori_id') == $cat->id_kategori ? 'selected' : '' }}>
                        {{ $cat->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="min-w-[150px]">
             <label class="form-label text-xs">Status</label>
             <select name="status_id" class="form-input text-sm">
                 <option value="">(Default: Bisa Dijual)</option>
                 @foreach($statuses as $st)
                     <option value="{{ $st->id_status }}" {{ request('status_id') == $st->id_status ? 'selected' : '' }}>
                         {{ $st->nama_status }}
                     </option>
                 @endforeach
             </select>
        </div>
        <button type="submit" class="btn-secondary text-sm h-[42px]">Filter</button>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200 text-gray-600 uppercase text-xs">
                    <th class="py-3 px-4 font-semibold whitespace-nowrap">ID</th>
                    <th class="py-3 px-4 font-semibold whitespace-nowrap">Nama Produk</th>
                    <th class="py-3 px-4 font-semibold whitespace-nowrap">Kategori</th>
                    <th class="py-3 px-4 font-semibold text-right whitespace-nowrap">Harga</th>
                    <th class="py-3 px-4 font-semibold text-center whitespace-nowrap">Status</th>
                    <th class="py-3 px-4 font-semibold text-center whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="py-3 px-4 text-gray-500 text-sm whitespace-nowrap">#{{ $product->id_produk }}</td>
                    <td class="py-3 px-4 font-medium text-gray-800 whitespace-nowrap">{{ $product->nama_produk }}</td>
                    <td class="py-3 px-4 text-gray-600 whitespace-nowrap">
                        <span class="bg-blue-100 text-blue-700 py-1 px-3 rounded-full text-xs font-semibold whitespace-nowrap">
                            {{ $product->kategori->nama_kategori ?? '-' }}
                        </span>
                    </td>
                    <td class="py-3 px-4 text-right font-medium text-gray-800 whitespace-nowrap">
                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                    </td>
                    <td class="py-3 px-4 text-center whitespace-nowrap">
                        <span class="{{ $product->status->nama_status == 'bisa dijual' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }} py-1 px-3 rounded-full text-xs font-semibold whitespace-nowrap">
                            {{ $product->status->nama_status ?? '-' }}
                        </span>
                    </td>
                    <td class="py-3 px-4 text-center whitespace-nowrap">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('products.edit', $product->id_produk) }}" class="text-blue-600 hover:text-blue-800 transition">
                                Edit
                            </a>
                            <button onclick="confirmDelete('{{ $product->id_produk }}')" class="text-red-600 hover:text-red-800 transition">
                                Hapus
                            </button>
                            <form id="delete-form-{{ $product->id_produk }}" action="{{ route('products.destroy', $product->id_produk) }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-8 text-center text-gray-500">
                        No products found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endsection
