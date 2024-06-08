<?php

namespace App\Http\Controllers;

use App\Exceptions\SimpleException;
use App\Models\Barang;
use App\Models\JenisBarang;
use App\Models\Transaksi;
use App\Responses\SimpleResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    public function index(Request $request): SimpleResponse
    {
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);
        $data = DB::table('v_transaksi');
        $sort = $request->query('sort', 'id'); // Default sorting by 'nama_barang'
        $order = $request->query('order', 'asc'); // Default sorting order 'asc'
        if ($request->has('filter')) {
            $search = $request->input('filter');
            $data->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', '%' . $search . '%')
                    ->orWhere('jenis_barang', 'like', '%' . $search . '%');
            });
        }

        $data = $data->orderBy($sort, $order)
            ->skip($offset)
            ->take($limit)
            ->get();
        return new SimpleResponse($data, 'Berhasil mendapatkan data', true);
    }

    public function compare(Request $request): SimpleException|SimpleResponse
    {
        $validator = Validator::make($request->all(), [
            'start_date' => 'date|before_or_equal:end_date',
            'end_date' => 'date|after_or_equal:start_date',
        ]);

        try {
            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first(), 400);
            }
            $orderBy = $request->input('order_by', 'desc');
            $startDate = $request->query('startDate', null);
            $endDate = $request->query('endDate', null);
            $data = DB::table('v_transaksi');
            if ($startDate && $endDate) {
                $startDate = Carbon::createFromFormat('d-m-Y', $startDate)->format('Y-m-d');
                $endDate = Carbon::createFromFormat('d-m-Y', $endDate)->format('Y-m-d');
                $data = $data->whereBetween('tanggal_transaksi', [$startDate, $endDate]);
            }
            $data = $data->get();
            $groupedData = $data->groupBy('jenis_barang');
            $comparison = $groupedData->map(function ($group) {
                return [
                    'jenis_barang' => $group->first()->jenis_barang,
                    'total_terjual' => $group->sum('jumlah_terjual')
                ];
            });
            if ($orderBy === 'desc') {
                $comparison = $comparison->sortByDesc('total_terjual');
            } else {
                $comparison = $comparison->sortBy('total_terjual');
            }
            return new SimpleResponse($comparison);
        } catch (\Exception $exception) {
            return new SimpleException($exception->getMessage(), 400);
        }


    }

    public function store(Request $request): SimpleResponse|SimpleException
    {
        $validator = Validator::make($request->all(), [
            'barang_id' => 'required',
            'jumlah_terjual' => 'required',
            'tanggal_transaksi' => 'required|date'
        ]);

        try {
            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first(), 400);
            }

            DB::beginTransaction();
            $barang = Barang::find($request->get('barang_id'));
            if ($barang->stok_barang < $request->get('jumlah_terjual')) {
                throw new \Exception("Stok tidak cukup", 400);
            }
            $newTransaksi = new Transaksi([
                'barang_id' => $request->get('barang_id'),
                'jumlah_terjual' => $request->get('jumlah_terjual'),
                'tanggal_transaksi' => $request->get('tanggal_transaksi'),
                'stok' => $barang->stok_barang
            ]);
            $newTransaksi->save();

            $barang->stok_barang = $barang->stok_barang - $request->get('jumlah_terjual');
            $barang->save();
            DB::commit();

            return new SimpleResponse(null, 'Transaksi berhasil dilakukan');
        } catch (\Exception $exception) {
            DB::rollback();
            return new SimpleException($exception->getMessage(), 400);
        }
    }

    public function update(Request $request, $id): SimpleResponse|SimpleException
    {
        $validator = Validator::make($request->all(), [
            'jumlah_terjual' => 'required',
            'tanggal_transaksi' => 'required|date'
        ]);

        try {
            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first(), 400);
            }

            DB::beginTransaction();
            $transaksi = Transaksi::find($id);
            if ($transaksi->stok < $request->get('jumlah_terjual')) {
                throw new \Exception("Stok tidak cukup", 400);
            }
            $barang = Barang::find($transaksi->barang_id);
            $barang->stok_barang = $barang->stok_barang + $transaksi->jumlah_terjual - $request->get('jumlah_terjual');
            $transaksi->jumlah_terjual = $request->get('jumlah_terjual');
            $transaksi->tanggal_transaksi = $request->get('tanggal_transaksi');

            $transaksi->save();
            $barang->save();
            DB::commit();
            return new SimpleResponse(null, 'Transaksi berhasil di update');
        } catch (\Exception $exception) {
            DB::rollback();
            return new SimpleException($exception->getMessage(), 400);
        }
    }

    public function destroy($id): SimpleResponse|SimpleException
    {
        try {
            DB::beginTransaction();
            Transaksi::destroy($id);
            DB::commit();
            return new SimpleResponse(null, 'Transaksi berhasil di hapus');
        } catch (\Exception $exception) {
            DB::rollback();
            return new SimpleException($exception->getMessage(), 400);
        }
    }
}
