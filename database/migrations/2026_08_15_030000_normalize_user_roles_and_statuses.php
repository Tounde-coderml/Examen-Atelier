<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')->where('role', 'agent')->update(['role' => 'Employé']);
        DB::table('users')->where('role', 'admin')->update(['role' => 'Administrateur']);
        DB::table('users')->where('status', 'active')->update(['status' => 'Active']);
        DB::table('users')->where('status', 'inactive')->update(['status' => 'Inactive']);
    }

    public function down(): void
    {
        // Cette normalisation ne doit pas réintroduire les anciennes valeurs.
    }
};
