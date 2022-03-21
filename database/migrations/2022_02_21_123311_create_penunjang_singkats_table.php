<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePenunjangSingkatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penunjang_singkats', function (Blueprint $table) {
            $table->id();
            $table->text('teks')->nullable(false);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('penunjang_singkats')->insert(
            array(
                [
                    'teks' => "Teks Penunjang Singkat Teks Teks Teks Teks Teks TeksTeks Teks Teks Teksv Teks Teks",
                ]
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
        Schema::dropIfExists('penunjang_singkats');
    }
}
