<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('emprunts', 'Date_effective_de_retour')) {
            Schema::table('emprunts', function (Blueprint $table) {
                $table->date('Date_effective_de_retour')->nullable();
            });

            return;
        }

        Schema::table('emprunts', function (Blueprint $table) {
            $table->date('Date_effective_de_retour')->nullable()->change();
        });
    }

    public function down(): void
    {
        // La colonne peut avoir existé avant cette migration : ne pas la supprimer.
    }
};
