<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Crear taula roles
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });
	//Trucar seeder
        Artisan::call('db:seed', [
            '--class' => 'RoleSeeder',
            '--force' => true // <--- add this line
        ]);

   	//Actualizar tabla users
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')
                  ->nullable()
                  ->default(Role::AUTHOR);
            $table->foreign('role_id') //Clau foranea
                  ->references('id')->on('roles')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
        });

        // Actualizar antics usuaris amb el rol per defecte
        DB::update(
            "UPDATE users
             SET role_id = " . Role::AUTHOR . "
             WHERE role_id IS NULL",
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });

        Schema::dropIfExists('roles');
    }
};
