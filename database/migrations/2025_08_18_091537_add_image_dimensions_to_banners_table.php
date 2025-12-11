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
        $tableName = 'banners';

        //image_width column
        if (!Schema::hasColumn($tableName, 'image_width')) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->integer('image_width')->nullable();
            });
        }
        //image_height column
        if (!Schema::hasColumn($tableName, 'image_height')) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->integer('image_height')->nullable();
            });
        }
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tableName = 'banners';

        if (Schema::hasColumn($tableName, 'image_width')) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn('image_width');
            });
        }
        if (Schema::hasColumn($tableName, 'image_height')) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn('image_height');
            });
        }
    }
};
