<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;

class DataCalonSiswaController extends Controller
{
    public function index(Request $request)
    {
        // Ambil kata kunci dari input search
        $search = $request->input('search');

        // Query dengan pencarian dan filter lain
        $query = Registration::orderBy('created_at', 'desc');

        // Search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%") // nomor pendaftaran
                    ->orWhere('nama_tk', 'like', "%{$search}%")
                    ->orWhere('jenis_kelamin', 'like', "%{$search}%");
            });
        }

        // Gender filter
        if (request()->filled('gender')) {
            $query->where('jenis_kelamin', request('gender'));
        }

        // Status filter
        if (request()->filled('status')) {
            $query->where('status', request('status'));
        }

        // Date range filter
        $startDate = request('start_date');
        $endDate = request('end_date');
        if ($startDate && $endDate) {
            $query->whereDate('created_at', '>=', $startDate)
                  ->whereDate('created_at', '<=', $endDate);
        } elseif ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        } elseif ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        $registrations = $query->paginate(10)->withQueryString();

        // Kirim data ke view
        return view('admin.data_calonsiswa', compact('registrations'));
    }
}
