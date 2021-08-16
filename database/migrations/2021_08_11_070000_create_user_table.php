<?php

use App\Constants\UserConstants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('api_token');
            $table->enum('user_type', UserConstants::USER_TYPES);
            $table->timestamps();
            $table->softDeletes();
        });

        // seed Admin user on migration
        $aDefaultAdminData = [
            'name'      => 'Admin',
            'username'  => 'admin',
            'password'  => '$2y$10$XtVdBAIcdTrc0nI6x5iD1uhi9jEEBtR3.TYqDPnvs/ED.eg/OhICy', // admin
            'user_type' => 'admin',
            'api_token' => Str::random(32),
        ];


        \App\Models\User::create($aDefaultAdminData);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
