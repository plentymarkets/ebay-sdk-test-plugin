<?php

namespace TestEbaySdk;

use Plenty\Plugin\ServiceProvider;

/**
 * Class TestEbaySdkServiceProvider
 */
class TestEbaySdkServiceProvider extends ServiceProvider
{
	/**
	 * @return void
	 */
	public function register()
	{
		$this->getApplication()->register(TestEbaySdkRouteServiceProvider::class);
	}

	/**
	 * @return void
	 */
	public function boot()
	{
	}
}
