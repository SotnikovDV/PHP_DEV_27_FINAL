<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRedirsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redirs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('offer_id') // оффер
                ->constrained('offers')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->foreignId('webmaster_id') // от кого из веб-мастеров пришел запрос
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->boolean('success')->default(false)->comment('переход по ссылке осуществлен');
            $table->boolean('accept')->default(false)->comment('ссылка предоставлена');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('redirs');
    }
}
