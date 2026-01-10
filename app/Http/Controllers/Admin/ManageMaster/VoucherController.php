<?php

namespace App\Http\Controllers\Admin\ManageMaster;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class VoucherController extends Controller
{
    public function index()
    {
        return view('admin.manage_master.voucher.index')->with('sb', 'Voucher');
    }

    public function getall()
    {
        $query = Voucher::orderBy('id', 'DESC')->get();

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('status', function (Voucher $voucher) {
                $badge = $voucher->status === 'active' ? 'badge-success' : 'badge-danger';
                return '<span class="badge ' . $badge . '">' . strtoupper($voucher->status) . '</span>';
            })
            ->addColumn('action', function (Voucher $voucher) {
                return '
                <div class="dropdown d-inline">
                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                        Aksi
                    </button>
                    <ul class="dropdown-menu">
                        <li><a data-id="' . $voucher->id . '" class="dropdown-item edit" style="cursor:pointer">Edit</a></li>
                        <li><a data-id="' . $voucher->id . '" class="dropdown-item hapus text-danger" style="cursor:pointer">Hapus</a></li>
                    </ul>
                </div>';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:50|unique:vouchers,code',
            'discount_percent' => 'required|numeric|min:0|max:100',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Voucher::create($request->all());

        return redirect()->back()->with('message', 'Voucher berhasil ditambahkan!');
    }

    public function get(Request $request)
    {
        return response()->json(Voucher::findOrFail($request->id));
    }

    public function update(Request $request)
    {
        $voucher = Voucher::findOrFail($request->id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:50|unique:vouchers,code,' . $voucher->id,
            'discount_percent' => 'required|numeric|min:0|max:100',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $voucher->update($request->all());

        return redirect()->back()->with('message', 'Voucher berhasil diperbarui!');
    }

    public function delete(Request $request)
    {
        Voucher::findOrFail($request->id)->delete();
        return response()->json(['message' => 'Voucher berhasil dihapus']);
    }
}