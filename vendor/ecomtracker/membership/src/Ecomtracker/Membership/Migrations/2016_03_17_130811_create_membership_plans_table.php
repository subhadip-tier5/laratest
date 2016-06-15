<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembershipPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membership_plans', function (Blueprint $table) {
            $table->increments('id');

            $table->char('nmi_plan_id','255');
            $table->char('title','255');
            $table->char('limit_products','255');
            $table->char('limit_keywords','255');
            $table->char('limit_super_urls','255');
            $table->char('limit_email_reports','255');
            $table->char('limit_negative_reviews','255');
            $table->char('limit_active_tracking_products','255');
            $table->char('flag_onpage_analyzer','2');
            $table->char('flag_asin_api','2');
            $table->longText('description');
            $table->longText('additional_data');  // serialized
            $table->boolean('is_selectable')->default(0);
            $table->boolean('is_locked')->default(0);

            $table->decimal('recurring_price','10','2');
            $table->integer('recurring_period_days')->default(30);
            $table->integer('trial_days');

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
        Schema::drop('membership_plans');
    }
}
