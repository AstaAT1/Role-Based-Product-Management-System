<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn('products', 'image')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('image');
            });
        }

        if (! Schema::hasColumn('products', 'quantity')) {
            Schema::table('products', function (Blueprint $table) {
                $table->integer('quantity')->default(0);
            });
        }

        Schema::table('products', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
            $table->decimal('price', 10, 2)->change();
            $table->integer('quantity')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('description')->nullable(false)->change();
            $table->integer('price')->change();
            $table->dropColumn('quantity');
            $table->string('image')->nullable();
        });
    }
};
