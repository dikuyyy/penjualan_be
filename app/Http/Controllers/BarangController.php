<?php

namespace App\Http\Controllers;

use App\Exceptions\SimpleException;
use App\Models\Barang;
use App\Models\JenisBarang;
use App\Responses\SimpleResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index(Request $request): SimpleResponse
    {
        $filter = $request->input('filter', null);
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);
        $data = Barang::with('JenisBarang')
            ->skip($offset)
            ->take($limit);

        if ($filter) {
            $data = $data->where('nama' ,'like' ,'%'. $filter .'%');
        }

        $data = $data->get();
        return new SimpleResponse($data, 'Data berhasil di tampilkan', true);
    }

    public function store(Request $request): SimpleResponse|SimpleException
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|max:50',
            'stok_barang' => 'required|integer|min:1',
            'jenis_id' => 'required|integer|min:1',
        ]);

        try {
            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first(), 400);
            }

            DB::beginTransaction();
            $newBarang = new Barang([
                'nama' => $request->get('nama'),
                'stok_barang' => $request->get('stok_barang'),
                'jenis_id' => $request->get('jenis_id')
            ]);

            $newBarang->save();
            DB::commit();

            return new SimpleResponse($newBarang, 'Data berhasil dibuat');
        } catch (\Exception $exception) {
            DB::rollback();
            return new SimpleException($exception->getMessage(), 400);
        }
    }

    public function update(Request $request, $id): SimpleResponse|SimpleException
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|max:50',
            'stok_barang' => 'required|integer|min:1',
            'jenis_id' => 'required|integer|min:1',
        ]);

        try {
            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first(), 400);
            }

            DB::beginTransaction();
            $updateBarang = Barang::where('id', $id)->update([
                'nama' => $request->get('nama'),
                'stok_barang' => $request->get('stok_barang'),
                'jenis_id' => $request->get('jenis_id')
            ]);
            DB::commit();
            return new SimpleResponse($updateBarang, 'Data berhasil diupdate');
        } catch (\Exception $exception) {
            DB::rollback();
            return new SimpleException($exception->getMessage(), 400);
        }
    }

    public function destroy($id): SimpleResponse|SimpleException
    {
        try {
            DB::beginTransaction();
            Barang::destroy($id);
            DB::commit();
            return new SimpleResponse(null, 'Data berhasil dihapus');
        } catch (\Exception $exception) {
            DB::rollback();
            return new SimpleException($exception->getMessage(), 400);
        }
    }
}
