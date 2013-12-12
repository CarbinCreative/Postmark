# Postmark

Minor improvements to Laravel 4.x Router class. Adds support for `Route::alias` and `Route::redirect`.



## Installation

Add this repository to your `composer.json`.

	"reposotories": [
		{
			"type": "git",
			"url": "https://github.com/CarbinCreative/Postmark.git"
		}
	]

And don't forget about your require, also in `composer.json`.

	"require": [
		"carbincreative/postmark": "*"
	]

As a final step you'll need to add our [ServiceProvider](http://laravel.com/api/4.1/Illuminate/Support/ServiceProvider.html) to `app/config/app.php`.

	'Postmark\PostmarkServiceProvider'



## Usage

Just add a route as you normally would, like so…

	Route::get('hello-world', 'FooController@get');
	Route::get('company/jobs', 'BarController@get');

Now it's super simple to add either an alias, or redirect.

	Route::alias('hejsan-varlden', 'hello-world');
	Route::redirect('work-with-us', 'company/jobs');