<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\NotificationController; // Import NotificationController

use App\Http\Controllers\SiswaDashboardController;
use App\Http\Controllers\DetailCalonSiswaController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\HasilSeleksiController;

use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\Admin\ApplicantController;
use App\Http\Controllers\Admin\AdminLaporanController;
use App\Http\Controllers\AdminPengumumanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ----------------- Halaman utama -----------------
Route::get('/', [AuthController::class, 'welcome'])->name('welcome');

// ----------------- Guest (belum login) -----------------
Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);

    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});

// ----------------- Logout (sudah login) -----------------
Route::middleware('auth')->post('logout', [AuthController::class, 'logout'])->name('logout');

// ----------------- Notifications -----------------
Route::middleware('auth')->group(function () {
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/mark-as-read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
});


// ----------------- Siswa -----------------
Route::prefix('siswa')->name('siswa.')->middleware(['auth','role:siswa'])->group(function () {
    Route::get('dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');

    // Formulir pendaftaran
    Route::get('formulir-pendaftaran', [RegistrationController::class, 'show'])->name('form');
    Route::post('formulir-pendaftaran', [RegistrationController::class, 'store'])->name('form.submit');

    // Halaman siswa lain
    Route::get('detail-calon-siswa', [DetailCalonSiswaController::class, 'index'])->name('detail');

    // ❗ sebelumnya "/siswa/pengumuman" (dobel prefix). Benar: "pengumuman"
    Route::get('pengumuman', [PengumumanController::class, 'index'])->name('pengumuman');

    Route::get('hasil-seleksi', [HasilSeleksiController::class, 'index'])->name('hasil');

    // Dokumen milik siswa yang login
    Route::get('dokumen/{type}', [RegistrationController::class, 'viewDocument'])->name('document.view');

});

// ----------------- Admin -----------------
Route::prefix('admin')->name('admin.')->middleware(['auth','role:admin'])->group(function () {
    Route::get('dashboard', [DashboardAdminController::class, 'index'])->name('dashboard');
    Route::get('activity-logs', [DashboardAdminController::class, 'activityLogs'])->name('activity-logs');

    // Data calon siswa
    Route::get('data-calonsiswa', [ApplicantController::class, 'index'])->name('data');
    Route::get('detail/{id}', [ApplicantController::class, 'show'])->name('detail');
    Route::get('detail/{id}/document/{type}', [ApplicantController::class, 'viewDocument'])->name('detail.document');

    // Verifikasi
    Route::get('verify/{id}', [ApplicantController::class, 'verifyForm'])->name('verify');
    Route::post('verify/{id}', [ApplicantController::class, 'updateVerification'])->name('verify.update');

    // Hapus pendaftar (INI YANG WAJIB KAMU TAMBAH)
    Route::delete('delete/{id}', [ApplicantController::class, 'destroy'])->name('delete');

    // Kelola detail (view statis)
    Route::get('manage', fn () => view('admin.keloladetailcalonsiswa'))->name('manage');

    // Pengumuman Admin
    Route::get('announcements', [AdminPengumumanController::class, 'index'])->name('announcements');
    Route::post('announcements', [AdminPengumumanController::class, 'store'])->name('announcements.store');
    Route::get('announcements/{id}/edit', [AdminPengumumanController::class, 'edit'])->name('announcements.edit');
    Route::put('announcements/{id}', [AdminPengumumanController::class, 'update'])->name('announcements.update');
    Route::delete('announcements/{id}', [AdminPengumumanController::class, 'destroy'])->name('announcements.destroy');

    // Laporan
    Route::get('laporan', [AdminLaporanController::class, 'index'])->name('reports');
    Route::get('laporan/pdf', [AdminLaporanController::class, 'exportPDF'])->name('reports.pdf');
    Route::get('laporan/excel', [AdminLaporanController::class, 'exportExcel'])->name('reports.excel');
});

// ----------------- Kepala Sekolah -----------------
Route::prefix('kepala-sekolah')->name('kepala-sekolah.')->middleware(['auth','role:kepala_sekolah'])->group(function () {
    Route::get('dashboard', [\App\Http\Controllers\KepalaSekolahController::class, 'dashboard'])->name('dashboard');
    Route::get('calon-siswa', [\App\Http\Controllers\KepalaSekolahController::class, 'calonSiswa'])->name('calon-siswa');
    Route::get('calon-siswa/{id}', [\App\Http\Controllers\KepalaSekolahController::class, 'showCalonSiswa'])->name('calon-siswa.show');
    Route::get('calon-siswa/{id}/document/{type}', [\App\Http\Controllers\KepalaSekolahController::class, 'viewDocument'])->name('document.view');
    Route::get('hasil-verifikasi', [\App\Http\Controllers\KepalaSekolahController::class, 'hasilVerifikasi'])->name('hasil-verifikasi');
    
    // Laporan
    Route::get('laporan', [\App\Http\Controllers\KepalaSekolahController::class, 'laporan'])->name('laporan');
    Route::get('laporan/pdf', [\App\Http\Controllers\KepalaSekolahController::class, 'exportPDF'])->name('laporan.pdf');
    Route::get('laporan/excel', [\App\Http\Controllers\KepalaSekolahController::class, 'exportExcel'])->name('laporan.excel');
});
