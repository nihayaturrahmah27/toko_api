<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $data = Produk::select('id', 'kode_produk', 'nama_produk', 'harga')->latest()->get();
        return response()->json([
            "code" => 200,
            "status" => true,
            "data" => $data,
        ]);
    }

    public function store(Request $req)
    {
        $data = [
            'kode_produk' => $req->kode_produk,
            'nama_produk' => $req->nama_produk,
            'harga' => $req->harga,
        ];
        try {
            $data = Produk::create($data);
            return response()->json([
                "message" => "Berhasil Simpan Data",
                "code" => 200,
                "status" => true,
                "data" => $data,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Gagal Simpan Data",
                "status" => false,
            ]);
        }
    }

    public function show($id)
    {
        $data = Produk::where("id", "=", $id)->first();
        if ($data) {
            return response()->json([
                "code" => 200,
                "status" => true,
                "data" => $data,
            ]);
        } else {
            return response()->json([
                "message" => "Data Tidak Ditemukan",
                "status" => false,
            ]);
        }
    }

    public function update(Request $req, $id)
    {
        $data = Produk::where("id", "=", $id)->first();
        $dataToUpdate = [
            'kode_produk' => $req->kode_produk,
            'nama_produk' => $req->nama_produk,
            'harga' => $req->harga,
        ];
        try {
            if ($data) {
                $data->update($dataToUpdate);
                $data = Produk::select('id', 'kode_produk', 'nama_produk', 'harga')->where("id", "=", $id)->first();
                return response()->json([
                    "code" => 200,
                    "status" => true,
                    "message" => "Berhasil Update Data",
                    "data" => $data,
                ]);
            } else {
                return response()->json(["message" => "Data Tidak Ditemukan"]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Gagal Update Data",
                "status" => false,
            ]);
        }
    }

    public function destroy($id)
    {
        $data = Produk::where("id", "=", $id)->first();
        try {
            if ($data) {
                $data->delete();
                return response()->json([
                    "code" => 200,
                    "data" => true,
                    "message" => "Berhasil Hapus Data"
                ]);
            } else {
                return response()->json([
                    "code" => 200,
                    "data" => false,
                    "message" => "Data Tidak Ditemukan"
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "data" => false,
                "message" => "Gagal Hapus Data"
            ]);
        }
    }
}
