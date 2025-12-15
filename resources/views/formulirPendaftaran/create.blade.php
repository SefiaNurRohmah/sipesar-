@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <form action="{{ route('formulirPendaftaran.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        <!-- Data Diri Siswa -->
        <div class="bg-white rounded-2xl shadow-lg p-6 form-section border border-teal-200">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Data Diri Siswa</h3>
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" placeholder="Masukkan nama lengkap"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" value="{{ old('nama_lengkap') }}" required>
                    @error('nama_lengkap')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">NIK</label>
                    <input type="text" name="nik" placeholder="Masukkan NIK"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" value="{{ old('nik') }}" required>
                    @error('nik')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" placeholder="Masukkan tempat lahir"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" value="{{ old('tempat_lahir') }}" required>
                    @error('tempat_lahir')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" value="{{ old('tanggal_lahir') }}" required>
                    @error('tanggal_lahir')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" required>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Agama</label>
                    <select name="agama" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" required>
                        <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                        <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                        <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                        <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                        <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                    </select>
                    @error('agama')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                <textarea name="alamat" rows="3" placeholder="Masukkan alamat lengkap" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" required>{{ old('alamat') }}</textarea>
                @error('alamat')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Data Orang Tua -->
        <div class="bg-white rounded-2xl shadow-lg p-6 form-section border border-teal-200">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Data Orang Tua/Wali</h3>
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Ayah</label>
                    <input type="text" name="nama_ayah" placeholder="Masukkan nama ayah" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" value="{{ old('nama_ayah') }}" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Ibu</label>
                    <input type="text" name="nama_ibu" placeholder="Masukkan nama ibu" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" value="{{ old('nama_ibu') }}" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan Orang Tua</label>
                    <input type="text" name="pekerjaan_orang_tua" placeholder="Masukkan pekerjaan orang tua" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" value="{{ old('pekerjaan_orang_tua') }}" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomor HP Orang Tua</label>
                    <input type="tel" name="no_hp_orang_tua" placeholder="08xxxxxxxxxx" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" value="{{ old('no_hp_orang_tua') }}" required>
                </div>
            </div>
        </div>

        <!-- Upload Dokumen -->
        <div class="bg-white rounded-2xl shadow-lg p-6 form-section border border-teal-200">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Upload Dokumen</h3>
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kartu Keluarga</label>
                    <input type="file" name="kk_file" class="w-full border border-gray-300 rounded-lg px-4 py-3" required>
                    @error('kk_file')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Akta Kelahiran</label>
                    <input type="file" name="akta_kelahiran_file" class="w-full border border-gray-300 rounded-lg px-4 py-3" required>
                    @error('akta_kelahiran_file')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Foto 3x4</label>
                    <input type="file" name="foto_3x4" class="w-full border border-gray-300 rounded-lg px-4 py-3" required>
                    @error('foto_3x4')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-teal-200">
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-8 py-3 rounded-lg font-semibold text-lg transition-colors">Simpan Perubahan</button>
                <button type="button" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold text-lg transition-colors">Simpan Draft</button>
                <button type="button" class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-lg font-semibold text-lg transition-colors">Batalkan</button>
            </div>
        </div>
    </form>
</div>
@endsection
