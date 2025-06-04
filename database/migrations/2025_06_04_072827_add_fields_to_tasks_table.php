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
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->text('description')->nullable()->after('name');
            $table->integer('priority')->default(1)->after('is_done'); // 1-низкий, 2-средний, 3-высокий
            $table->string('category')->nullable()->after('priority');
            $table->json('tags')->nullable()->after('category');
            $table->timestamp('start_at')->nullable()->after('tags');
            $table->timestamp('end_at')->nullable()->after('start_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn(['name', 'description', 'priority', 'category', 'tags', 'start_at', 'end_at']);
        });
    }
};
