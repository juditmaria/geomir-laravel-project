<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Visibility;

return new class extends Migration
{
    public $tables = ['posts', 'places'];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->tables as $tableName) {
            // Add new column
            Schema::table($tableName, function (Blueprint $table) {
                $table->unsignedBigInteger('visibility_id')
                      ->default(Visibility::PUBLIC);
            });
            // Update previous rows using default value
            DB::update(
                "UPDATE $tableName
                SET visibility_id = " . Visibility::PUBLIC
            );
            // Add new FK
            Schema::table($tableName, function (Blueprint $table) {
                $table->foreign('visibility_id')
                      ->references('id')->on('visibilities')
                      ->onUpdate('cascade')
                      ->onDelete('restrict');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->tables as $tableName) {
            // Drop FK and column
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropForeign(['visibility_id']);
                $table->dropColumn('visibility_id');
            });
        }
    }
};
