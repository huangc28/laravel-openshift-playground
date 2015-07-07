<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\DoraemonPrize;
use App\JiraClientFactory;
use App\CpliakasJiraClientAdapter;
// use App\JiraCredentials;

class JackpotProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{

		$this->registerJiraClientInterface();
		// $this->registerDoraemonPrize($jiraClient);		
	}

	protected function registerJiraClientInterface()
	{
		$credentials = $this->app->config['services']['jira'];
		$jiraClient = JiraClientFactory::make($credentials['host'], $credentials['username'], $credentials['password']);
		$this->app->bind('App\JiraClientInterface', function() use ($jiraClient) {
			return new CpliakasJiraClientAdapter($jiraClient);
		});
	}

	/**
	 * Register DoraemonPrize instance 
	 */
	protected function registerDoraemonPrize($jiraClient)
	{
		$this->app->bind('App\JackpotInterface', function($app) use($jiraClient) {
			return new DoraemonPrize($jiraClient);
		});
	}

}
