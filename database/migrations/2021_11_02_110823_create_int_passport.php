<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntPassport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('int_passports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clientId')->constrained('clients','id');
            $table->enum('type',['T', 'S','P','D']);
            $table->date('issueDate');
            $table->date('endDate');
            $table->string('issueOrg');
            $table->string('citizenship');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('int_passport');
    }
}
