<?php
namespace Postmark;

// Illuminate
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Routing\Redirector;

// Postmark
use Postmark\Routing\Router;



class PostmarkServiceProvider extends ServiceProvider {

	public function register() {

		$app = $this->app;

		$this->registerRouter();
		$this->registerUrlGenerator();
		$this->registerRedirector();

		$app->booting(function() {

			$loader = AliasLoader::getInstance();
			$loader->alias('Route', 'Postmark\Support\Facades\Router');

		});

	}

	protected function registerRouter() {

		$this->app['router'] = $this->app->share(function($app) {

			$router = new Router($app);

			if($app['env'] === 'testing') {

				$router->disableFilters();

			}

			return $router;

		});

	}

	protected function registerUrlGenerator() {

		$this->app['url'] = $this->app->share(function($app) {

			$routes = $app['router']->getRoutes();

			return new UrlGenerator($routes, $app['request']);

		});

	}

	protected function registerRedirector() {

		$this->app['redirect'] = $this->app->share(function($app) {

			$redirector = new Redirector($app['url']);

			if(isset($app['session.store']) === true) {

				$redirector->setSession($app['session.store']);

			}

			return $redirector;

		});

	}

	public function provides() {

		return ['router'];

	}

}