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
        // Validasi dasar
        $request->validate([
            'keperluan' => 'required|string',
            'jenis_tamu' => 'nullable|string',
            'nama_tamu' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'nama_penerima' => 'nullable|string|max:255',
            'foto' => 'required|string',
            'tanggal_kunjungan' => 'required|date',
            'jam_kunjungan' => 'nullable|string',
            'nomor_kartu' => 'nullable|string|max:50',
            'dari_pt' => 'nullable|string|max:255',
        ]);

        // Decode base64 ke file
        if (preg_match('/^data:image\/(\w+);base64,/', $request->foto, $type)) {
            $data = substr($request->foto, strpos($request->foto, ',') + 1);
            $data = base64_decode($data);
            $extension = strtolower($type[1]);
            $filename = uniqid('foto_') . '.' . $extension;

            Storage::put("public/foto/{$filename}", $data);
        } else {
            return back()->withErrors(['foto' => 'Foto tidak valid.'])->withInput();
        }

        // Simpan data tamu
        Tamu::create([
            'keperluan' => $request->keperluan,
            'jenis_tamu' => $request->jenis_tamu ?? '-',
            'nama_tamu' => $request->nama_tamu,
            'telepon' => $request->telepon,
            'nama_penerima' => $request->nama_penerima,
            'foto' => $filename,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'jam_kunjungan' => $request->jam_kunjungan,
            'nomor_kartu' => $request->nomor_kartu,
            'dari_pt' => $request->dari_pt ?? '-',

        ]);

        return redirect()->route('dashboard')->with('success', 'Data berhasil disimpan!');
    }

    public function history(Request $request)
    {
        $query = Tamu::query();

        if ($request->filled('search')) {
            $query->where('nama_tamu', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        if ($request->filled('jenis_tamu')) {
            $query->where('jenis_tamu', $request->jenis_tamu);
        }

        $tamus = $query->latest()->paginate(9);

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

    public function keluar($id)
    {
        $tamu = Tamu::findOrFail($id);
        $tamu->jam_keluar = now()->format('H:i');
        $tamu->save();

        return redirect()->route('history')->with('success', 'Tamu berhasil keluar.');
    }

}
