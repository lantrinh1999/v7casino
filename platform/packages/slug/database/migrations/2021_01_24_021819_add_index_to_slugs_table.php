<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToSlugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slugs', function (Blueprint $table) {
            $table->index(['key', 'reference_id', 'reference_type'], 'k_rid_rtype');
            $table->index(['key', 'reference_id', 'reference_type', 'prefix'], 'k_rid_rtype_pre');
            $table->index(['key', 'prefix'], 'k_pre');
            $table->index(['key'], 'key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slugs', function (Blueprint $table) {
            $table->dropIndex('k_rid_rtype');
            $table->dropIndex('k_rid_rtype_pre');
            $table->dropIndex('k_pre');
            $table->dropIndex('key');
        });
    }
}
