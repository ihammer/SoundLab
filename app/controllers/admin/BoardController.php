<?php namespace Admin;

use View;

class BoardController extends \AdminController {

	public function getIndex()
	{
		return View::make('backend.board.index');
	}

	public function getLogin()
	{
		return View::make('backend.board.login');
	}

	// 后台登陆
	public function postLogin()
	{
		// 
	}
}
