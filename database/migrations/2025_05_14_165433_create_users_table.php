// database/migrations/2025_05_14_165433_create_users_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username', 255)->unique();
            $table->string('email', 255)->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255);
            $table->string('google_id', 255)->unique()->nullable();
            $table->string('faculty', 255)->nullable();
            $table->string('profile_picture', 255)->nullable();
            $table->string('cover_picture', 255)->nullable();
            $table->string('major', 255)->nullable(); 
            $table->string('university', 255)->nullable(); 
            $table->text('bio')->nullable();
            $table->unsignedBigInteger('role_id')->default(1);
            $table->unsignedBigInteger('followers_count')->default(0);
            $table->unsignedBigInteger('followings_count')->default(0);
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}