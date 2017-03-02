<?php

namespace TestEbaySdk\Controllers;

use EbaySdk\Api\Account\Enums\MarketplaceIdEnum;
use EbaySdk\Api\Account\Services\AccountService;
use EbaySdk\Api\Account\Types\GetFulfillmentPoliciesByMarketplaceRestRequest;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Controller;

/**
 * Class TestAccountController
 */
class TestAccountController extends Controller
{
	/**
	 * @var ConfigRepository
	 */
	private $config;

	/**
	 * @param ConfigRepository $config
	 */
	public function __construct(ConfigRepository $config)
	{
		$this->config = $config;
	}

	/**
	 * Get Fulfillment Policies by Marketplace.
	 */
	public function getFulfillmentPoliciesByMarketplace()
	{
		/** @var AccountService $service */
		$service = pluginApp(AccountService::class, [
			'config' => [
				'sandbox' => true,
				'accessToken' => $this->config->get('TestEbaySdk.accessToken'),
				'refreshToken' => $this->config->get('TestEbaySdk.refreshToken'),
			]
		]);

		/** @var GetFulfillmentPoliciesByMarketplaceRestRequest $request */
		$request = pluginApp(GetFulfillmentPoliciesByMarketplaceRestRequest::class);


		$request->marketplace_id = MarketplaceIdEnum::C_EBAY_DE;

		$response = $service->getFulfillmentPoliciesByMarketplace($request);

		$list = [];

		foreach($response->fulfillmentPolicies as $fulfillmentPolicy)
		{
			$list[$fulfillmentPolicy->fulfillmentPolicyId] = $fulfillmentPolicy->name;
		}

		return $list;
	}
}