<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Если будем удалять тип серийного номера, то у нас удалится и все записи по ней.
     * Тут по сути нужно сделать два поля уникальными (equipment_type_id и serial_number), т.е составной уникальный ключ.
     * Ибо у нас одинаковые серийные номера могут относится к разным типам компаний.
     * Но не стал это писать, ибо в тз не говорилось об этом
     */
    public function up()
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('equipment_type_id');
            $table->string('serial_number')->unique();
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('equipment_type_id')
                ->references('id')
                ->on('equipment_type')
                ->onDelete('CASCADE');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipments');
    }
};
