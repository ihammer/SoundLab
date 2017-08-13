<?php

class BaseController extends Controller {
	/**
	 * Message bag.
	 *
	 * @var Illuminate\Support\MessageBag
	 */
	protected $messageBag = null;

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}
	
	public function __construct()
	{
            
		$this->messageBag = new Illuminate\Support\MessageBag;
	}


	// redirect
	public function redirect($url = null)
	{
		// $location = $this->getRedirectURL();
		// if ( !isset($location) ) 
		// {
		// 	$location = isset($url) ? $url : $this->getURL();
		// }
		// clear data 
		// do redirect
	}
}
