<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tamu;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TamusExport;
use Carbon\Carbon;

class TamuController extends Controller
{
    public function dashboard()
    {
        $hariIni = Tamu::whereDate('created_at', Carbon::today())->count();
        $mingguIni = Tamu::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $bulanIni = Tamu::whereMonth('created_at', Carbon::now()->month)->count();
        $total = Tamu::count();

        return view('dashboard', compact('hariIni', 'mingguIni', 'bulanIni', 'total'));
    }

    public function form()
    {
        return view('form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'keperluan' => 'required',
            'jenis_tamu' => 'nullable|string',
            'nama_tamu' => 'required|string',
            // 'nama_penerima' => 'required|string',
            'telepon' => 'required|string',
            'foto' => 'required|string',
            'tanggal_kunjungan' => 'required|date',
        ]);

        // Decode base64 ke file
        if (preg_match('/^data:image\/(\w+);base64,/', $request->foto, $type)) {
            $data = substr($request->foto, strpos($request->foto, ',') + 1);
            $data = base64_decode($data);
            $extension = strtolower($type[1]);
            $filename = uniqid() . '.' . $extension;

            Storage::put("public/foto/{$filename}", $data);
        } else {
            return back()->withErrors(['foto' => 'Foto tidak valid.'])->withInput();
        }

        Tamu::create([
            'keperluan' => $request->keperluan,
            'jenis_tamu' => $request->jenis_tamu,
            'nama_tamu' => $request->nama_tamu,
            // 'nama_penerima' => $request->nama_penerima,
            'telepon' => $request->telepon,
            'foto' => $filename,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
        ]);

        return redirect()->route('dashboard')->with('success', 'Data berhasil disimpan!');
    }

    public function history()
    {
        $tamus = Tamu::latest()->get();
        return view('history', compact('tamus'));
    }

    public function destroy($id)
    {
        $tamu = Tamu::findOrFail($id);

        if ($tamu->foto && Storage::exists('public/foto/' . $tamu->foto)) {
            Storage::delete('public/foto/' . $tamu->foto);
        }

        $tamu->delete();

        return redirect()->route('history')->with('success', 'Data berhasil dihapus!');
    }

    public function export()
    {
        return Excel::download(new TamusExport, 'riwayat_buku_tamu.xlsx');
    }
}
