<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateDosensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosens', function (Blueprint $table) {
            $table->id();
            $table->text('foto')->nullable(false);
            $table->string('nama', 255)->nullable(false);
            $table->string('nip', 35)->nullable(false);
            $table->string('pangkat_golongan', 100)->nullable(false);
            $table->text('sinta')->nullable(true);
            $table->text('url')->nullable(true);
            $table->unsignedBigInteger('kelompok_keahlian_dosen_id')->nullable(false);
            $table->foreign('kelompok_keahlian_dosen_id')->references('id')->on('kelompok_keahlian_dosens')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('dosens')->insert(
            array(
                [
                    'foto' => "images/dosen/1.jpg",
                    'nama' => 'Nama 1',
                    'nip' => 'NIP111111111111111-NIDN111111',
                    'pangkat_golongan' => 'Golongan 1',
                    'sinta' => 'https://www.google.com/',
                    'url' => 'https://www.google.com/',
                    'kelompok_keahlian_dosen_id' => '1',
                ],
                [
                    'foto' => "images/dosen/2.jpg",
                    'nama' => 'Nama 2',
                    'nip' => 'NIP222222222222222-NIDN222222',
                    'pangkat_golongan' => 'Golongan 2',
                    'sinta' => 'https://www.bing.com/',
                    'url' => 'https://www.bing.com/',
                    'kelompok_keahlian_dosen_id' => '2'
                ],
                [
                    'foto' => "images/dosen/3.jpg",
                    'nama' => 'Nama 3',
                    'nip' => 'NIP333333333333333-NIDN333333',
                    'pangkat_golongan' => 'Golongan 3',
                    'sinta' => 'https://www.yahoo.com/',
                    'url' => 'https://www.yahoo.com/',
                    'kelompok_keahlian_dosen_id' => '3'
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
        Schema::dropIfExists('dosens');
    }
}
