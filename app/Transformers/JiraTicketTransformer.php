<?php namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class JiraTicketTransformer extends TransformerAbstract
{
	public function transform($issue)
	{	
		return [
			'assignee'  =>  $issue->assignee,
			'ticket_id'	=>	$issue->key,
			'ticket_no'	=>	$issue->id
		];
	}
}