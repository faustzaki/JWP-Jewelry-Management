<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class MasterDataController extends Controller
{
    public function index()
    {
        $kategoris = KategoriBarang::withCount('barangs')->get();
        // Eager load relasi kategori untuk mencegah bottleneck performa N+1 query
        $barangs = Barang::with('kategoriBarang')->get();
        $penggunas = User::all();

        return view('master-data.master-data', compact('kategoris', 'barangs', 'penggunas'));
    }

}
