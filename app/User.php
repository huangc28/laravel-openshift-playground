<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	/**
	 * A user has many JiraTickets.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function jiraTicket()
	{
		return $this->hasMany('App\JiraTicket', 'assignee_jira_id', 'mig_id');
	}

	/**
	 * Check if jira user exists.
	 *
	 * @todo should be written in trait.
	 * @param string $user
	 * @return boolean
	 */
	public function hasJiraUser($jiraUser)
	{
		return $this->where('mig_id', $jiraUser)->exists();
	}

	/**
	 * Find user by Jira id 
	 *
	 * @param string $jiraId
	 */
	public function getByJiraId($jiraId)
	{
		return $this->where('mig_id', $jiraId)->first();
	}
}
