<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClosureExceptionsTable extends Migration
{
    public function up()
    {
        Schema::create('closure_exceptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->date('date'); // date de fermeture exceptionnelle
            $table->string('reason'); // raison de la fermeture
            $table->timestamps(); // created_at et updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('closure_exceptions');
    }
}

