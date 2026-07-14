<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {

            if (!Schema::hasColumn('products', 'description')) {
                $table->text('description')->nullable();
            }

            if (!Schema::hasColumn('products', 'price')) {
                $table->decimal('price', 10, 2)->nullable();
            }

            if (!Schema::hasColumn('products', 'user_id')) {
                $table->foreignId('user_id')
                    ->constrained()
                    ->onDelete('cascade');
            }

            if (!Schema::hasColumn('products', 'category_id')) {
                $table->foreignId('category_id')
                    ->constrained()
                    ->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {

            if (Schema::hasColumn('products', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }

            if (Schema::hasColumn('products', 'category_id')) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            }

            if (Schema::hasColumn('products', 'description')) {
                $table->dropColumn('description');
            }

            if (Schema::hasColumn('products', 'price')) {
                $table->dropColumn('price');
            }
        });
    }
};