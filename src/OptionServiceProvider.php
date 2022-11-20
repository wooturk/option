<?php

namespace Wooturk;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
class OptionServiceProvider extends ServiceProvider
{
	/**
	 * Register services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Bootstrap services.
	 *
	 * @return void
	 */
	public function boot()
	{
		Route::get('/option', [OptionController::class, 'index'])->name('option-index');
		Route::get('/options', [OptionController::class, 'list'])->name('option-list');
		Route::get('/option/{id}', [OptionController::class, 'get'])->name('option-get');
		Route::get('/option/{id}/values', [OptionController::class, 'list_value'])->name('option-values-list');
		Route::get('/option/{id}/value/{value_id}', [OptionController::class, 'get_value'])->name('option-value-get');
		Route::group(['middleware' => ['auth:sanctum','wooturk.gateway']], function(){
			Route::post('/option', [OptionController::class, 'post'])->name('option-create');
			Route::post('/option', [OptionController::class, 'post'])->name('option-create');
			Route::put('/option/{id}', [OptionController::class, 'put'])->name('option-update');
			Route::delete('/option/{id}', [OptionController::class, 'delete'])->name('option-delete');
			Route::post('/option/{id}/value', [OptionController::class, 'post_value'])->name('option-value-create');
		});
	}
}
