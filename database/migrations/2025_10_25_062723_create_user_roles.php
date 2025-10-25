<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Role::findOrCreate('Admin');
        Role::findOrCreate('User');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
