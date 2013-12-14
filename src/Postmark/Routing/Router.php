<?php
namespace Postmark\Routing;

// Illuminate
use Illuminate\Routing\Router as DefaultRouter;

// Facades
use Redirect;



class Router extends DefaultRouter {

	/**
	 *	@var array $namedRouteObjects
	 */
	protected $namedRouteObjects = [];

	/**
	 *	createRoute
	 *
	 *	Additions to default routing class method createRoute.
	 *
	 *	@param string $method
	 *	@param string $pattern
	 *	@param callable $action
	 *
	 *	@return array
	 */
	protected function createRoute($method, $pattern, $action) {

		if(is_array($action) === true && array_key_exists('as', $action) === true) {

			$alias = $action['as'];

			$callback = $action['uses'];

		} else {

			$alias = null;

			$callback = $action;

		}

		$this->namedRouteObjects[$pattern] = (object) [
			'alias' => $alias,
			'method' => $method,
			'callback' => $callback
		];

		return parent::createRoute($method, $pattern, $action);

	}

	/**
	 *	alias
	 *
	 *	Creates an alias for an already defined route.
	 *
	 *	@param string $aliasRoute
	 *	@param string $targetRoute
	 *
	 *	@return array
	 */
	public function alias($aliasRoute, $targetRoute) {

		if(array_key_exists($targetRoute, $this->namedRouteObjects) === true) {

			$route = $this->namedRouteObjects[$targetRoute];

			if(is_string($route->alias) === true) {

				$route->alias .= '.redirect';

			}

			return $this->createRoute($route->method, $aliasRoute, $route->callback);

		}

	}

	/**
	 *	redirect
	 *
	 *	Creates a redirect route alias.
	 *
	 *	@param string $aliasRoute
	 *	@param string $targetRoute
	 *	@param int $statusCode
	 *
	 *	@return void
	 */
	public function redirect($aliasRoute, $targetRoute, $statusCode = 301) {

		if(array_key_exists($targetRoute, $this->namedRouteObjects) === true) {

			return $this->any($aliasRoute, function() use ($targetRoute, $statusCode) {

				return Redirect::to($targetRoute, $statusCode);

			});

		}

	}

}