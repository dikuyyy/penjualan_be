<?php

namespace App\Http\Controllers;

use App\Exceptions\SimpleException;
use App\Models\Barang;
use App\Models\JenisBarang;
use App\Responses\SimpleResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class JenisBarangController extends Controller
{
    public function index(Request $request): SimpleResponse
    {
        $filter = $request->input('filter', null);
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);
        $data = JenisBarang::skip($offset)
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
            'nama' => 'required|max:50'
        ]);

        try {
            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first(), 400);
            }

            DB::beginTransaction();
            $newJenisBarang = new JenisBarang([
                'nama' => $request->get('nama')
            ]);

            $newJenisBarang->save();
            DB::commit();

            return new SimpleResponse($newJenisBarang, 'Data berhasil dibuat');
        } catch (\Exception $exception) {
            DB::rollback();
            return new SimpleException($exception->getMessage(), 400);
        }
    }

    public function update(Request $request, $id): SimpleResponse|SimpleException
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|max:50'
        ]);

        try {
            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first(), 400);
            }

            DB::beginTransaction();
            $updateJenisBarang = JenisBarang::where('id', $id)->update([
                'nama' => $request->get('nama')
            ]);
            DB::commit();
            return new SimpleResponse($updateJenisBarang, 'Data berhasil diupdate');
        } catch (\Exception $exception) {
            DB::rollback();
            return new SimpleException($exception->getMessage(), 400);
        }
    }

    public function destroy($id): SimpleResponse|SimpleException
    {
        try {
            DB::beginTransaction();
            $masterBarang = Barang::where('jenis_id', $id)->get();
            if(count($masterBarang) > 0) {
                throw new \Exception('Tidak bisa menghapus jenis barang yang terelasi dengan barang');
            }
            JenisBarang::destroy($id);
            DB::commit();
            return new SimpleResponse(null, 'Data berhasil dihapus');
        } catch (\Exception $exception) {
            DB::rollback();
            return new SimpleException($exception->getMessage(), 400);
        }
    }
}
