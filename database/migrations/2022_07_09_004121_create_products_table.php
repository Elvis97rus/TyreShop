<?php

use App\Models\User;
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
            $table->id();
            $table->string('title', 2000)->index();
            $table->string('slug', 2000);
            $table->string('image', 2000)->nullable();
            $table->string('image_mime')->nullable();
            $table->integer('image_size')->nullable();
            $table->longText('description')->nullable();
            $table->longText('meta_description')->nullable();
            $table->longText('meta_title')->nullable();
            $table->decimal('price', 10, 2)->index();
            $table->foreignIdFor(User::class, 'created_by')->nullable();
            $table->foreignIdFor(User::class, 'updated_by')->nullable();
            $table->softDeletes();
            $table->foreignIdFor(User::class, 'deleted_by')->nullable();
            $table->foreignId('category_id')->nullable()->references('id')->on('categories')->onDelete('cascade');


            $table->decimal('price_opt', 10, 2)->nullable();
            $table->decimal('price_rozn', 10, 2)->nullable();
            $table->string('rest')->nullable();
            $table->string('code', 100)->nullable()->index();
            $table->string('product_type', 100)->nullable()->index();
            $table->string('season')->nullable()->index();
            $table->boolean('thorn')->nullable()->index();
            $table->string('type')->nullable()->index();
            $table->string('marka', 100)->nullable()->index();
            $table->string('model', 100)->nullable()->index();
            $table->string('img_big_my', 2000)->nullable();
            $table->string('img_big_pish', 2000)->nullable();
            $table->string('img_small', 2000)->nullable();
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
        Schema::dropIfExists('products');
    }
};
