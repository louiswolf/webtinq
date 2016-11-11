<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeSiteIdAndStudentIdMulticolumnPrimary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_student', function ($table) {
            $table->primary(array('site_id', 'student_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('site_student', function ($table) {
            $table->dropPrimary();
        });
    }
}
