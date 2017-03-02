<?php

namespace TestEbaySdk;

use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\ApiRouter;
use Plenty\Plugin\Routing\Router as WebRouter;

/**
 * Class TestEbaySdkRouteServiceProvider
 */
class TestEbaySdkRouteServiceProvider extends RouteServiceProvider
{
	/**
	 * @param ApiRouter $api
	 * @param WebRouter $webRouter
	 */
	public function map(ApiRouter $api, WebRouter $webRouter)
	{
		$api->version(['v1'], ['middleware' => []], function ($router)
		{
			$router->get('markets/ebay/test/get-fulfillment-policies-by-marketplace', [
				'uses' => 'TestEbaySdk\Controllers\TestAccountController@getFulfillmentPoliciesByMarketplace'
			]);
		});
	}
}
