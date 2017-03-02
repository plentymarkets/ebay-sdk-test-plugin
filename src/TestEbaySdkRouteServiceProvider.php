<?php

namespace TestEbaySdk;

use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\ApiRouter;

/**
 * Class TestEbaySdkRouteServiceProvider
 */
class TestEbaySdkRouteServiceProvider extends RouteServiceProvider
{
	/**
	 * @param ApiRouter $api
	 */
	public function map(ApiRouter $api)
	{
		$api->version(['v1'], ['middleware' => ['oauth']], function ($router)
		{
			$router->get('markets/ebay/test/get-fulfillment-policies-by-marketplace', [
				'uses' => 'TestEbaySdk\Controllers\TestAccountController@getFulfillmentPoliciesByMarketplace'
			]);

			$router->post('markets/ebay/test/create-a-return-policy', [
				'uses' => 'TestEbaySdk\Controllers\TestAccountController@createReturnPolicy'
			]);

			$router->get('markets/ebay/test/get-a-fulfillment-policy-by-id', [
				'uses' => 'TestEbaySdk\Controllers\TestAccountController@getFulfillmentPolicyById'
			]);
		});
	}
}
