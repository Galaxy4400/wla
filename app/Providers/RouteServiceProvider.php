<?php

namespace App\Providers;

use App\Models\MenuItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
	/**
	 * The path to the "home" route for your application.
	 *
	 * This is used by Laravel authentication to redirect users after login.
	 *
	 * @var string
	 */
	public const HOME = '/';
	public const ADMIN = '/admin';

	/**
	 * The controller namespace for the application.
	 *
	 * When present, controller route declarations will automatically be prefixed with this namespace.
	 *
	 * @var string|null
	 */
	protected $namespace = 'App\\Http\\Controllers';

	/**
	 * Define your route model bindings, pattern filters, etc.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->configureRateLimiting();

		$this->routeBindings();

		$this->routes(function () {
			Route::middleware('admin')
				->prefix('admin')
				->name('admin.')
				->namespace($this->namespace . '\\Admin')
				->group(base_path('routes/admin.php'));
				
			Route::middleware('web')
				->namespace($this->namespace . '\\Web')
				->group(base_path('routes/web.php'));

		});
	}

	/**
	 * Configure the rate limiters for the application.
	 *
	 * @return void
	 */
	protected function configureRateLimiting()
	{
		RateLimiter::for('api', function (Request $request) {
			return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
		});
	}

	/**
	 * Configure the custom route bindings.
	 *
	 * @return void
	 */
	protected function routeBindings()
	{
		$this->idOrSlugBind('admin', 'Admin', 'login');
		$this->idOrSlugBind('page');
		$this->idOrSlugBind('menu');
		$this->idOrSlugBind('page_parent', 'Page');

		Route::model('menu_item', MenuItem::class);
	}

	/**
	 * Model binding resolution logic id or slug
	 *
	 * @param  string  $parameter
	 * @param  string  $model
	 * @param  string  $slugField
	 * @return \Illuminate\Http\Response
	 */
	protected function idOrSlugBind(string $parameter, string $model = null, string $slugField = 'slug'): void
	{
		$fullModelName = '\\App\\Models\\'.($model ?? Str::headline($parameter));

		Route::bind($parameter, function ($value) use ($fullModelName, $slugField) {
			return $fullModelName::query()
				->where('id', $value)
				->orWhere($slugField, $value)
				->first();
		});
	}
}
