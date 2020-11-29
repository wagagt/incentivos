<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->decimal('amount', 15, 2)->nullable();
            $table->longText('description')->nullable();
            $table->date('date')->nullable();
            $table->string('qr_code')->nullable();
            $table->string('verification')->nullable();
            $table->string('tracking_code')->unique();
            $table->longText('comments')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
