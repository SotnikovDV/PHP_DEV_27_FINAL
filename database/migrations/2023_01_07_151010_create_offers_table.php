<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('name', 100)->unique(); // имя
            $table->text('subjects', 254)->nullable(); // темы
            $table->foreignId('advertiser_id') // от кого оффер
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->text('url', 2048); // ссылка для перехода
            $table->decimal('price', 14, 2)->default(0); // стоимость перехода
            $table->boolean('active')->default(false); // Признак "Оффер активен"
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
