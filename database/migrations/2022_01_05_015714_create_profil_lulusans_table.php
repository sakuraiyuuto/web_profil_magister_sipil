<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateProfilLulusansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profil_lulusans', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255)->nullable(false);
            $table->string('nim', 15)->nullable(false);
            $table->decimal('ipk', 3, 2)->nullable(false);
            $table->unsignedInteger('angkatan')->nullable(false);
            $table->unsignedInteger('tahun_lulus')->nullable(false);
            $table->string('nomor_ijazah', 100)->nullable(false);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('profil_lulusans')->insert(
            array(
                [
                    'nama' => "Profil Lulusan 1",
                    'nim' => "D1111111111",
                    'ipk' => 3.10,
                    'angkatan' => "2001",
                    'tahun_lulus' => "2002",
                    'nomor_ijazah' => "NOMOR/IJAZAH/PROFIL_LULUSAN_1"
                ],
                [
                    'nama' => "Profil Lulusan 2",
                    'nim' => "D2222222222",
                    'ipk' => 3.20,
                    'angkatan' => "2003",
                    'tahun_lulus' => "2004",
                    'nomor_ijazah' => "NOMOR/IJAZAH/PROFIL_LULUSAN_2"
                ],
                [
                    'nama' => "Profil Lulusan 3",
                    'nim' => "D3333333333",
                    'ipk' => 3.30,
                    'angkatan' => "2005",
                    'tahun_lulus' => "2006",
                    'nomor_ijazah' => "NOMOR/IJAZAH/PROFIL_LULUSAN_3"
                ],
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profil_lulusans');
    }
}
