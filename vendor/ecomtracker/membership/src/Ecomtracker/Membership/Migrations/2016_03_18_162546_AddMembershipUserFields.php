<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMembershipUserFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table)
        {
            $table->integer('membership_plan_id');
            $table->index('membership_plan_id');
            $table->char('nmi_customer_vault_id','255');
            $table->index('nmi_customer_vault_id');
            $table->char('nmi_subscription_id','255');
            $table->longText('nmi_actions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table)
        {
            $table->dropColumn('membership_plan_id');
            $table->dropColumn('nmi_customer_vault_id');
            $table->dropColumn('nmi_subscription_id');
            $table->dropColumn('nmi_actions');

        });
    }
}
