<?php

use App\Models\Apportionment;
use App\Models\Contributor;
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
        Schema::create('apportionment_contributors', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Apportionment::class)->constrained();
            $table->foreignIdFor(Contributor::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apportionment_contributors');
    }
};
