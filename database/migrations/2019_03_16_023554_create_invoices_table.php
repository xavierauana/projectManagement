<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('billable');
            $table->date('due_date');
            $table->text('internal_note')->nullable();
            $table->text('note')->nullable();
            $table->string('status')->default(\App\Enums\ProjectStatus::Active()
                                                                      ->getValue());
            $table->string('invoice_number')->unique()
                  ->default(\Illuminate\Support\Str::uuid());
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('invoices');
    }
}
