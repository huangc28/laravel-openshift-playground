<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class JiraTicket extends Model {

	protected $table = 'jira_ticket';

	protected $fillable = array(
		'ticket_id'  ,
		'ticket_no'  ,
		'assignee'   , 
		'jackpot_hit',
	);

	public function user()
	{
		return $this->belongsTo('App\User', 'assignee_jira_id', 'mig_id');
	}

	/**
	 * Find ticket by Jira id.
	 *
	 * @param string $id
	 * @return stdClass
	 */
	public function findByTicketId($id)
	{
		return $this->where('ticket_id', $id)->first();
	}

	/**
	 * Check the existence of the ticket id.
	 *
	 * @param string $string
	 * @return boolean
	 */
	public function checkIdExists($id)
	{
		return $this->where('ticket_id', $id)->exists();
	}

	/**
	 * Get all open sprint jira ticket that has not been picked yet.
	 *
	 * @return Illuminate\Support\Collection
	 */
	public function getLotteryTickets()
	{
		return $this->where('jackpot_hit', FALSE)->get();
	}

	/**
	 * Mark this ticket as jackpot hitted.
	 *
	 * @param void
	 * @return $this
	 */
	public function setIsjackpotHitted()
	{
		$this->jackpot_hit = TRUE;

		return $this;
	}
}
