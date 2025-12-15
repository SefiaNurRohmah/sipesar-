<?php

namespace App\Http\Controllers;

use App\Events\AnnouncementCreated;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPengumumanController extends Controller
{
    /**
     * Display a listing of announcements.
     */
    public function index()
    {
        $announcements = Announcement::latest()->get();
        return view('admin.kelola_pengumuman', compact('announcements'));
    }

    /**
     * Store a newly created announcement.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:active,inactive',
        ], [
            'title.required' => 'Judul pengumuman wajib diisi',
            'title.max' => 'Judul maksimal 255 karakter',
            'content.required' => 'Konten pengumuman wajib diisi',
            'status.required' => 'Status wajib dipilih',
        ]);

        $validated['created_by'] = Auth::id() ?? 1; // default to 1 if no auth

        $announcement = Announcement::create($validated);

        // Dispatch event AnnouncementCreated
        AnnouncementCreated::dispatch($announcement);

        return response()->json([
            'success' => true,
            'message' => 'Pengumuman berhasil ditambahkan!'
        ]);
    }

    /**
     * Show the form for editing the specified announcement.
     */
    public function edit($id)
    {
        $announcement = Announcement::findOrFail($id);
        return response()->json($announcement);
    }

    /**
     * Update the specified announcement.
     */
    public function update(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:active,inactive',
        ], [
            'title.required' => 'Judul pengumuman wajib diisi',
            'title.max' => 'Judul maksimal 255 karakter',
            'content.required' => 'Konten pengumuman wajib diisi',
            'status.required' => 'Status wajib dipilih',
        ]);

        $announcement->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pengumuman berhasil diperbarui!'
        ]);
    }

    /**
     * Remove the specified announcement.
     */
    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pengumuman berhasil dihapus!'
        ]);
    }
}
