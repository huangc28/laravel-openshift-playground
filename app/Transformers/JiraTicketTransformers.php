<?php namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class JiraTicketTransformers extends TransformerAbstract
{
	public function transform($issue)
	{	
		return [
			'ticket_id'	=>	$issue->key,
			'ticket_no'	=>	$issue->id
		];
	}
}