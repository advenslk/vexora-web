<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('provisioning_status')->nullable()->after('status')->index();
            $table->text('provisioning_error')->nullable()->after('provisioning_status');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['provisioning_status', 'provisioning_error']);
        });
    }
};
