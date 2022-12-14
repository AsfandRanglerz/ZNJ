<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryColoumnsToEntertainerDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entertainer_details', function (Blueprint $table) {
            $table->string('name')->after('location')->nullable();
            $table->string('dob')->after('image')->nullable();
            $table->string('contact')->after('image')->nullable();
            $table->string('country')->after('image')->nullable();
            $table->string('city')->after('image')->nullable();
            $table->string('gender')->after('image')->nullable();
            $table->string('nationality')->after('image')->nullable();
            $table->string('awards')->after('image')->nullable();
            $table->string('height')->after('image')->nullable();
            $table->string('weight')->after('image')->nullable();
            $table->string('waist')->after('image')->nullable();
            $table->string('shoe_size')->after('image')->nullable();
            $table->string('own_equipment')->after('image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entertainer_details', function (Blueprint $table) {
            //
        });
    }
}
