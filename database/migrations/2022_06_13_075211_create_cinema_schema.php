<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinemaSchema extends Migration
{
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->datetime('duration');
            $table->string('language');
            $table->datetime('released_date');
            $table->string('country');
            $table->timestamps();
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('state');
            $table->string('zipcode');
            $table->timestamps();
        });

        Schema::create('cinemas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('total_cinema_halls');
            $table->bigInteger('city_id')->unsigned();
            $table->foreign('city_id')->references('id')->on('cities')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        
        Schema::create('cinema_halls', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('total_seats');
            $table->bigInteger('cinema_id')->unsigned();
            $table->foreign('cinema_id')->references('id')->on('cinemas')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('cinema_seats', function (Blueprint $table) {
            $table->id();
            $table->integer('seat_number');
            $table->integer('type');
            $table->bigInteger('cinema_hall_id')->unsigned();
            $table->foreign('cinema_hall_id')->references('id')->on('cinema_halls')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('shows', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->datetime('start_time');
            $table->datetime('end_time');
            $table->bigInteger('cinema_hall_id')->unsigned();
            $table->bigInteger('movie_id')->unsigned();
            $table->foreign('cinema_hall_id')->references('id')->on('cinema_halls')->constrained()->onDelete('cascade');
            $table->foreign('movie_id')->references('id')->on('movies')->constrained()->onDelete('cascade');
            $table->timestamps();
        });



        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('number_of_seats');
            $table->datetime('timestamp');
            $table->integer('status');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('show_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->constrained()->onDelete('cascade');
            $table->foreign('show_id')->references('id')->on('shows')->constrained()->onDelete('cascade');
            $table->timestamps();
        });


        Schema::create('show_seats', function (Blueprint $table) {
            $table->id();
            $table->integer('status');
            $table->integer('price');
            $table->bigInteger('cinema_seat_id')->unsigned();
            $table->bigInteger('show_id')->unsigned();
            $table->bigInteger('booking_id')->unsigned();
            $table->foreign('cinema_seat_id')->references('id')->on('cinema_seats')->constrained()->onDelete('cascade');
            $table->foreign('show_id')->references('id')->on('shows')->constrained()->onDelete('cascade');
            $table->foreign('booking_id')->references('id')->on('bookings')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('amount');
            $table->datetime('timestamp');
            $table->integer('discount_coupon_id');
            $table->integer('remote_transaction_id');
            $table->integer('payment_method');
            $table->bigInteger('booking_id')->unsigned();
            $table->foreign('booking_id')->references('id')->on('bookings')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('movies');
        Schema::dropIfExists('shows');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('cinemas');
        Schema::dropIfExists('cinema_halls');
        Schema::dropIfExists('cinema_seats');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('show_seats');
        Schema::dropIfExists('payments');
    }
}
