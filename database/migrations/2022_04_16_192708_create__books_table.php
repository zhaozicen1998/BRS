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
        Schema::create('Books', function (Blueprint $table) {
            $table->id();
            $table->string("title",255);
            $table->string("authors",255);
            $table->integer("genre_id");
            $table->text("description")->nullable();
            $table->date("released_at");
            $table->string("cover_image",255)->nullable()->default("/image/book/No_Image.png");
            $table->integer("pages");
            $table->string("language_code",3)->default("hu");
            $table->string("isbn",13)->unique();
            $table->integer("in_stock");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Books');
    }
};
