<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJiraTicketTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		\Schema::create('jira_ticket', function(Blueprint $table){
			$table->increments('id'); // incremental id
			$table->string('ticket_id')->nullable(); // ticket specifc number
			$table->string('ticket_no')->nullable(); // jira ticket number
			$table->boolean('jackpot_hit')->default(false); // determine whether it hits 
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
		\Schema::dropIfExists('jira_ticket');
	}
}
