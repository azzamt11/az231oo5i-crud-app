<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('post_body');
            $table->integer('post_type')->default(0);
            $table->integer('post_user')->default(1);
            $table->integer('post_id')->default(1);
            $table->integer('post_atribute_1')->default(1);
            $table->string('post_atribute_2')->nullable();
            $table->string('post_atribute_3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
