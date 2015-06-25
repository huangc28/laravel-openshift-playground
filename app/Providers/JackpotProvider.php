<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\DoraemonPrize;
use App\JiraClientFactory;
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

		$credentials = $this->app->config['services']['jira'];
		$jiraClient = JiraClientFactory::make($credentials['host'], $credentials['username'], $credentials['password']);
		$this->registerDoraemonPrize($jiraClient);		
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
