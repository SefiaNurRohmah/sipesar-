<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Registration;

class DetailCalonSiswaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $registration = Registration::firstWhere('user_id', $user->id);

        return view('siswa.detail_calonsiswa', [
            'user' => $user,
            'registration' => $registration,
        ]);
    }

}
