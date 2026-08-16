<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'uuid')) {
            Schema::table('users', function (Blueprint $table) {
                $table->uuid('uuid')->nullable()->unique();
            });
        }

        foreach (DB::table('users')->whereNull('uuid')->select('id')->cursor() as $user) {
            DB::table('users')->where('id', $user->id)->update(['uuid' => (string) Str::uuid()]);
        }

        if (! Schema::hasColumn('materials', 'category_id')) {
            Schema::table('materials', function (Blueprint $table) {
                $table->uuid('category_id')->nullable();
            });
        }
        if (Schema::hasColumn('materials', 'category')) {
            DB::statement('UPDATE materials SET category_id = category WHERE category_id IS NULL');
        }
        DB::table('materials')->whereNotIn('category_id', DB::table('categories')->select('id'))->update(['category_id' => null]);

        if (Schema::hasColumn('materials', 'category')) {
            Schema::table('materials', function (Blueprint $table) {
                $table->dropColumn('category');
            });
        }

        if (! Schema::hasColumn('emprunts', 'user_id')) {
            Schema::table('emprunts', function (Blueprint $table) {
                $table->uuid('user_id')->nullable();
            });
        }
        if (! Schema::hasColumn('emprunts', 'material_id')) {
            Schema::table('emprunts', function (Blueprint $table) {
                $table->uuid('material_id')->nullable();
            });
        }
        if (Schema::hasColumn('emprunts', 'materiel')) {
            DB::statement('UPDATE emprunts SET material_id = materiel WHERE material_id IS NULL');
        }
        if (Schema::hasColumn('emprunts', 'utilisateur')) {
            DB::statement('UPDATE emprunts e JOIN users u ON u.name = e.utilisateur SET e.user_id = u.uuid WHERE e.user_id IS NULL');
        }
        if (Schema::hasColumn('emprunts', 'materiel')) {
            Schema::table('emprunts', function (Blueprint $table) {
                $table->dropColumn('materiel');
            });
        }
        if (Schema::hasColumn('emprunts', 'utilisateur')) {
            Schema::table('emprunts', function (Blueprint $table) {
                $table->dropColumn('utilisateur');
            });
        }
        DB::table('emprunts')->whereNotIn('material_id', DB::table('materials')->select('id'))->update(['material_id' => null]);
        DB::table('emprunts')->whereNotIn('user_id', DB::table('users')->select('uuid'))->update(['user_id' => null]);

        // Les schémas historiques n'utilisent pas tous les mêmes types de clés.
        // Les relations Eloquent reposent sur ces colonnes sans imposer de contrainte SQL destructrice.
    }

    public function down(): void
    {
        Schema::table('emprunts', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'material_id']);
        });
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['uuid']);
            $table->dropColumn('uuid');
        });
    }
};
