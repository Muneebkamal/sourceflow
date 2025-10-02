<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->date('publish_date')->nullable();
            $table->text('image')->nullable();
            $table->string('type')->default('normal');
            $table->longText('tags')->nullable();
            $table->longText('product_title')->nullable();

            $table->string('asin')->nullable()->index();
            $table->string('supplier')->nullable();
            $table->string('brand')->nullable();

            $table->decimal('cost', 10, 2)->default(0);
            $table->decimal('sale_price', 10, 2)->default(0);
            $table->decimal('net_profit', 10, 2)->default(0);
            $table->decimal('roi', 5, 2)->default(0); // percentage ROI

            $table->integer('bsr_90_d_avg')->nullable();
            $table->string('category')->nullable();

            $table->boolean('promo')->default(false);
            $table->string('coupon_code')->nullable();

            $table->text('lead_note')->nullable();
            $table->integer('new_offers')->nullable();
            $table->decimal('rating', 3, 2)->nullable(); // e.g. 4.75

            $table->integer('bsr_current')->nullable();
            $table->string('lead_source')->nullable();

            $table->text('variations')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->string('created_from')->default('system');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
