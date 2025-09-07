<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventGuest;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\GuestsImport;
use App\Exports\GuestsExport;

class EventController extends Controller
{
    /**
     * Tampilkan semua event
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
            'tanggal_event' => 'required|date',
        ]);

        Event::create($request->only('nama_event', 'tanggal_event'));

        return redirect()->route('events.index')->with('success', 'Event berhasil ditambahkan!');
    }

    /**
     * Menampilkan daftar tamu untuk event tertentu
     */
    public function guests($event_id)
    {
        $event = Event::with('guests')->findOrFail($event_id);
        return view('events.guests', compact('event'));
    }

    /**
     * Tandai kehadiran tamu
     */
    public function markAttendance(Request $request, $guest_id)
    {
        $guest = EventGuest::findOrFail($guest_id);
        $guest->kehadiran = !$guest->kehadiran; // toggle hadir/belum hadir
        $guest->save();

        return back()->with('success', 'Status kehadiran berhasil diperbarui.');
    }

    /**
     * Import daftar tamu dari Excel
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
     * Export daftar nama tamu ke Excel (tanpa status kehadiran)
     */
    public function exportGuests($event_id)
    {
        $event = Event::findOrFail($event_id);
        return Excel::download(new GuestsExport($event_id), 'daftar_tamu_'.$event->nama_event.'.xlsx');
    }
}
