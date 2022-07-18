<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('session_id')->nullable();
            $table->string('day')->nullable();
            $table->unsignedBigInteger('course_id')->nullable();
            $table->string('course_code')->nullable();
            $table->double('per_credit')->nullable();
            $table->double('remaning_credit')->nullable();
            $table->double('total_credit')->nullable();
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->string('teacherS_name')->nullable();
            $table->unsignedBigInteger('section_id')->nullable();
            $table->string('section')->nullable();
            $table->string('semister')->nullable();
            $table->unsignedBigInteger('room_id')->nullable();
            $table->string('room_no')->nullable();
            $table->string('room_status')->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('routines');
    }
}
