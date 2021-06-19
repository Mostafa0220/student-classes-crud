<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //create table name 'classes'
        Schema::create('classes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('class_name');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        // Insert classes on table creation
        DB::table('classes')->insert([
                ['class_name' => 'Class 1'],
                ['class_name' => 'Class 2'],
                ['class_name' => 'Class 3'],
                ['class_name' => 'Class 4'],
                ['class_name' => 'Class 5'],
                ['class_name' => 'Class 6'],
                ['class_name' => 'Class 7'],
                ['class_name' => 'Class 8'],
                ['class_name' => 'Class 9'],
                ['class_name' => 'Class 10']
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classes');
    }
}
