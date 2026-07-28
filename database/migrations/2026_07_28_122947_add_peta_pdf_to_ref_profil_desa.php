<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPetaPdfToRefProfilDesa extends Migration
{
    public function up(): void
    {
        Schema::table('ref_profil_desa', function (Blueprint $table) {
            $table->string('peta_pdf')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('ref_profil_desa', function (Blueprint $table) {
            $table->dropColumn('peta_pdf');
        });
    }
}
