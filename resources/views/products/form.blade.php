@extends('layouts.master')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg p-8">
    <div class="mb-8 border-b pb-4">
        <h1 class="text-2xl font-bold text-gray-800">
            {{ isset($product) ? 'Edit Produk' : 'Tambah Produk Baru' }}
        </h1>
        <p class="text-gray-500 mt-1">Silakan isi detail produk di bawah ini.</p>
    </div>

    <form action="{{ isset($product) ? route('products.update', $product->id_produk) : route('products.store') }}" method="POST">
        @csrf
        @if(isset($product))
            @method('PUT')
        @endif

        <div class="space-y-6">
            <!-- Name -->
            <div>
                <label for="nama_produk" class="form-label">Nama Produk <span class="text-red-500">*</span></label>
                <input type="text" name="nama_produk" id="nama_produk" class="form-input @error('nama_produk') border-red-500 ring-1 ring-red-500 @enderror"
                    value="{{ old('nama_produk', $product->nama_produk ?? '') }}" placeholder="Masukkan nama produk" required>
                @error('nama_produk')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price -->
            <div>
                <label for="harga" class="form-label">Harga (Rp) <span class="text-red-500">*</span></label>
                <input type="number" name="harga" id="harga" class="form-input @error('harga') border-red-500 ring-1 ring-red-500 @enderror"
                    value="{{ old('harga', isset($product) ? (int)$product->harga : '') }}" placeholder="Masukkan harga (hanya angka)" required>
                @error('harga')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Category -->
                <div>
                    <label for="kategori_id" class="form-label">Kategori <span class="text-red-500">*</span></label>
                    <select name="kategori_id" id="kategori_id" class="form-input bg-white @error('kategori_id') border-red-500 ring-1 ring-red-500 @enderror" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id_kategori }}" {{ old('kategori_id', $product->kategori_id ?? '') == $category->id_kategori ? 'selected' : '' }}>
                                {{ $category->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status_id" class="form-label">Status <span class="text-red-500">*</span></label>
                    <select name="status_id" id="status_id" class="form-input bg-white @error('status_id') border-red-500 ring-1 ring-red-500 @enderror" required>
                        <option value="">Pilih Status</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id_status }}" {{ old('status_id', $product->status_id ?? '') == $status->id_status ? 'selected' : '' }}>
                                {{ $status->nama_status }}
                            </option>
                        @endforeach
                    </select>
                    @error('status_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t mt-6">
                <a href="{{ route('products.index') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">
                    {{ isset($product) ? 'Perbarui Produk' : 'Simpan Produk' }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
