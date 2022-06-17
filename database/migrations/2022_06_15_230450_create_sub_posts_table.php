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
        Schema::create('sub_posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('subpost_body')->nullable();
            $table->integer('subpost_type')->default(0);
            $table->integer('subpost_user')->default(1);
            $table->integer('subpost_parent')->default(1);
            $table->integer('subpost_atribute_1')->default(1);
            $table->string('subpost_atribute_2')->nullable();
            $table->string('subpost_atribute_3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_posts');
    }
};
