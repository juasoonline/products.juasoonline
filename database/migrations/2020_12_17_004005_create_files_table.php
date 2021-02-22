<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'files', function ( Blueprint $table )
        {
            $table -> bigIncrements('id' );
            $table -> uuid( 'resource_id' ) -> unique() -> nullable( false );

            $table -> unsignedBigInteger( 'product_id' );

            $table -> string( 'title' ) -> nullable( true );
            $table -> mediumText( 'description' );
            $table -> string( 'file' ) -> nullable( false );

            $table -> timestamps();

            $table -> softDeletes();

            $table -> foreign('product_id' ) -> references('id' ) -> on ('products' ) -> onDelete('cascade' );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
