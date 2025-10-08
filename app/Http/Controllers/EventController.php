<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventGuest;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\GuestsImport;
use App\Exports\GuestsExport;
use App\Models\EventGuestAttendance;

class EventController extends Controller
{
    /**
     * Menampilkan semua event
     */
    public function index()
    {
        $events = Event::withCount('guests')->latest()->get();
        return view('events.index', compact('events'));
    }

    /**
     * Form tambah event
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Simpan event baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_event' => 'required|string|max:255',
            'jenis_event' => 'required|string|max:100',
            'pt_penyelenggara' => 'required|string|max:255',
            'tanggal_event' => 'required|date',
        ]);

        Event::create([
            'nama_event' => $request->nama_event,
            'jenis_event' => $request->jenis_event,
            'pt_penyelenggara' => $request->pt_penyelenggara,
            'tanggal_event' => $request->tanggal_event,
        ]);

        return redirect()->route('events.index')->with('success', 'Event berhasil ditambahkan!');
    }

    /**
     * Menampilkan daftar tamu per event
     */
    public function guests($event_id)
    {
        $event = Event::with('guests')->findOrFail($event_id);
        return view('events.guests', compact('event'));
    }

    /**
     * Tandai kehadiran tamu
     */
   public function markAttendance(Request $request, $event_id, $guest_id)
    {
        $guest = EventGuest::where('event_id', $event_id)
                            ->where('id', $guest_id)
                            ->firstOrFail();

        $foto = $request->input('foto');

        // === CEK BASE64 ===
        if ($foto && strpos($foto, 'data:image') === 0) {
        preg_match("/^data:image\/(.*);base64,/", $foto, $matches);
        $imageType = $matches[1] ?? 'jpeg';

        $image = preg_replace('/^data:image\/(.*);base64,/', '', $foto);
        $image = str_replace(' ', '+', $image);

        $fileName = 'attendances/' . uniqid('guest_') . '.' . $imageType;
        $saved = \Storage::disk('public')->put($fileName, base64_decode($image));

        if (!$saved) {
            return back()->with('error', 'Gagal menyimpan file di server.');
        }

        $path = $fileName;
    }

        // === FALLBACK UPLOAD MANUAL ===
        elseif ($request->hasFile('foto')) {
            $request->validate(['foto' => 'image|mimes:jpg,jpeg,png|max:2048']);
            $path = $request->file('foto')->store('attendances', 'public');
        } else {
            return back()->with('error', 'Foto tidak ditemukan, silakan coba lagi.');
        }

        // Simpan data kehadiran
        EventGuestAttendance::create([
            'event_id' => $event_id,
            'guest_id' => $guest_id,
            'foto' => $path,
            'waktu_hadir' => now(),
        ]);

        $guest->kehadiran = 1;
        $guest->save();

        return back()->with('success', 'Kehadiran tamu berhasil dicatat.');
    }

    /**
     * Import tamu dari Excel
     */
    public function importGuests(Request $request, $event_id)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new GuestsImport($event_id), $request->file('file'));

        return back()->with('success', 'Daftar tamu berhasil diimport.');
    }

    /**
     * Export tamu ke Excel
     */
    public function exportGuests($event_id)
    {
        $event = Event::findOrFail($event_id);
        return Excel::download(new GuestsExport($event_id), 'daftar_tamu_'.$event->nama_event.'.xlsx');
    }

    /**
     * Form tambah tamu manual
     */
    public function createGuest($event_id)
    {
        $event = Event::findOrFail($event_id);
        return view('events.create-guest', compact('event'));
    }

    /**
     * Simpan tamu manual
     */
    public function storeGuest(Request $request, $eventId)
    {
        $event = Event::findOrFail($eventId);

        $validated = $request->validate([
            'guests' => 'required|array',
            'guests.*.nama_tamu' => 'required|string|max:255',
            'guests.*.jenis_tamu' => 'nullable|string|max:255',
            'guests.*.no_telp' => 'nullable|string|max:20',
        ]);

        foreach ($validated['guests'] as $guestData) {
            EventGuest::create([
                'event_id' => $event->id,
                'nama_tamu' => $guestData['nama_tamu'],
                'jenis_tamu' => $guestData['jenis_tamu'] ?? null,
                'no_telp' => $guestData['no_telp'] ?? null,
                'hadir' => false,
            ]);
        }

        return redirect()->route('events.index', $event->id)->with('success', 'Daftar tamu berhasil ditambahkan!');
    }
}
