<?php
namespace Postmark\Support\Facades;

// Illuminate
use Illuminate\Support\Facades\Facade;



class Router extends Facade {

	protected static function getFacadeAccessor() {

		return 'router';

	}

}