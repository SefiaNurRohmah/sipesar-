<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('registrations')) {
            return;
        }

        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique()->comment('referensi ke users.id');

            // Data siswa
            $table->string('nama')->nullable();
            $table->string('nik', 50)->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('jenis_kelamin', 2)->nullable();
            $table->string('agama')->nullable();
            $table->text('alamat')->nullable();

            // Data orang tua / wali
            $table->string('nama_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('pekerjaan_ortu')->nullable();
            $table->string('hp_ortu', 30)->nullable();

            // Data sekolah asal
            $table->string('nama_tk')->nullable();
            $table->text('alamat_tk')->nullable();

            // Nama file yang diupload (opsional)
            $table->string('kartu_keluarga', 255)->nullable();
            $table->string('akta_kelahiran', 255)->nullable();
            $table->string('foto_3x4', 255)->nullable();
            $table->string('ijazah', 255)->nullable();
            $table->string('ktp_ortu', 255)->nullable();
            $table->string('kartu_bantuan', 255)->nullable();

            // Path/storage untuk file
            $table->string('kartu_keluarga_path')->nullable();
            $table->string('akta_kelahiran_path')->nullable();
            $table->string('foto_3x4_path')->nullable();
            $table->string('ijazah_path')->nullable();
            $table->string('ktp_ortu_path')->nullable();
            $table->string('kartu_bantuan_path')->nullable();


            // Status & metadata
            $table->string('status')->default('menunggu keputusan')->comment('menunggu keputusan, diterima, ditolak');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->timestamp('verified_at')->nullable();

            $table->timestamps();

            // Index & foreign keys
            $table->index('user_id');
            $table->index('status');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // optional foreign key for verifier if users table exists
            $table->foreign('verified_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down()
    {
        if (!Schema::hasTable('registration')) {
            return;
        }

        Schema::table('registration', function (Blueprint $table) {
            // drop foreign keys if exist
            if (Schema::hasColumn('registration', 'verified_by')) {
                $sm = Schema::getConnection()->getDoctrineSchemaManager();
                $fkNames = [];
                // best-effort: drop by column
                try {
                    $table->dropForeign(['user_id']);
                } catch (\Throwable $e) {}
                try {
                    $table->dropForeign(['verified_by']);
                } catch (\Throwable $e) {}
            }
        });

        Schema::dropIfExists('registration');
    }
};
