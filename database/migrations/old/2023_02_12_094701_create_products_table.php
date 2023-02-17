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
        Schema::create('products', function (Blueprint $table) {
            // Default
            $table->id();
            $table->string('name');
            $table->mediumText('excerpt');
            $table->longText('description');
            $table->binary('thumbnail');
            
            // Filters
            $table->string('brand');
            $table->string('price');
            $table->bigInteger('stock');
            $table->year('year');
            $table->foreignId('idBrand')->nullable();
            $table->foreignId('idColor')->nullable();
            $table->foreignId('idCat')->nullable();
            
            // Timestamps and foreign key
            $table->timestamps();
            $table->foreign('idBrand')->references('id')->on('brands')->onDelete('set null');
            $table->foreign('idColor')->references('id')->on('colors')->onDelete('set null');
            $table->foreign('idCat')->references('id')->on('categories')->onDelete('set null');
        });
        $sql = 'alter table products change thumbnail thumbnail longblob';
        DB::statement($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
