<?php 

return array( 
	
	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session',
	/**
	 * Consumers
	 */
	'consumers' => array(
		/**
		 * Douban
		 */
		'Douban' => array(
			'client_id' => '027eaf69ad6e899a077c0e3d084b9cce',
			'client_secret' => '019393291483df00',
			'scope' => array(),
		),
		
		/**
		 * QQ
		 */
		'QQ' => array(
			'client_id' => '1104016299',
			'client_secret' => 'izYPbnGjF4VzLQ0a',
			'scope' => array(),
		),
		
		/**
		 * Sina weibo
		 */
		'Sina' => array(
			'client_id' => '3582211646',
			'client_secret' => 'c3c62f3967f40e866f8c80b0560995f2',
			'scope' => array(),
		),
	)
);