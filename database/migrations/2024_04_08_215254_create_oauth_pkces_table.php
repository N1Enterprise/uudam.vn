<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOauthPkcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauth_pkces', function (Blueprint $table) {
            $table->id();
            $table->string('oauth_provider_code');
            $table->string('code_challenge');
            $table->string('code_verifier');
            $table->timestamps();

            $table->index(['oauth_provider_code', 'code_challenge'], 'oauth_provider_code_code_challenge_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oauth_pkces');
    }
}
