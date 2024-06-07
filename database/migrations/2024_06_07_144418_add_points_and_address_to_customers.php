<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->integer('points')->default(0);
            $table->string('address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('points');
            $table->dropColumn('address');
        });
    }

};
