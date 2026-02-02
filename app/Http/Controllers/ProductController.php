<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Status;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::with(['kategori', 'status']);

        // Filter Status ("bisa dijual" by default, unless overriden or showing all)
        // User asked to "Add Filter", implying dynamic.
        // But Rule 5 said: "tampilkan data yang hanya memiliki status 'bisa dijual'".
        // I will keep the default as "bisa dijual" but allow user to clear it or change it?
        // Let's implement a rigid rule: Always 'bisa dijual' UNLESS specifically asked otherwise,
        // but for this test, I will simply allow filtering by Status ID if provided, otherwise default to "bisa dijual".

        if ($request->has('status_id') && $request->status_id != '') {
             $query->where('status_id', $request->status_id);
        } else {
             $query->whereHas('status', function($q) {
                $q->where('nama_status', 'bisa dijual');
             });
        }

        // Filter Category
        if ($request->has('kategori_id') && $request->kategori_id != '') {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Search Name
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_produk', 'ilike', '%' . $request->search . '%');
        }

        $products = $query->orderBy('id_produk', 'desc')->paginate(10);

        $categories = Kategori::all();
        $statuses = Status::all(); // For filter dropdown

        return view('products.index', compact('products', 'categories', 'statuses'));
    }

    public function create()
    {
        $categories = Kategori::all();
        $statuses = Status::all();
        return view('products.form', compact('categories', 'statuses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string',
            'harga' => 'required|numeric',
            'kategori_id' => 'required|exists:kategori,id_kategori',
            'status_id' => 'required|exists:status,id_status',
        ]);

        Produk::create($request->all());

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(string $id)
    {

    }

    public function edit(string $id)
    {
        $product = Produk::findOrFail($id);
        $categories = Kategori::all();
        $statuses = Status::all();
        return view('products.form', compact('product', 'categories', 'statuses'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_produk' => 'required|string',
            'harga' => 'required|numeric',
            'kategori_id' => 'required|exists:kategori,id_kategori',
            'status_id' => 'required|exists:status,id_status',
        ]);

        $product = Produk::findOrFail($id);
        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $product = Produk::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
