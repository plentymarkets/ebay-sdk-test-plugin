<?php

namespace TestEbaySdk\Controllers;

use EbaySdk\Api\Account\Enums\MarketplaceIdEnum;
use EbaySdk\Api\Account\Enums\RefundMethodEnum;
use EbaySdk\Api\Account\Enums\ReturnShippingCostPayerEnum;
use EbaySdk\Api\Account\Enums\TimeDurationUnitEnum;
use EbaySdk\Api\Account\Services\AccountService;
use EbaySdk\Api\Account\Types\CreateAReturnPolicyRestRequest;
use EbaySdk\Api\Account\Types\GetAFulfillmentPolicyByIDRestRequest;
use EbaySdk\Api\Account\Types\GetFulfillmentPoliciesByMarketplaceRestRequest;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Controller;
use Plenty\Plugin\Http\Request;

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
	 *
	 * @return array
	 */
	public function getFulfillmentPoliciesByMarketplace()
	{
		/** @var AccountService $accountService */
		$accountService = pluginApp(AccountService::class, [
			'config' => [
				'accessToken'  => $this->config->get('TestEbaySdk.accessToken'),
				'refreshToken' => $this->config->get('TestEbaySdk.refreshToken'),
			],
		]);

		/** @var GetFulfillmentPoliciesByMarketplaceRestRequest $getFulfillmentPoliciesByMarketplaceRestRequest */
		$getFulfillmentPoliciesByMarketplaceRestRequest = pluginApp(GetFulfillmentPoliciesByMarketplaceRestRequest::class, [
			'values' => [
				'marketplace_id' => MarketplaceIdEnum::C_EBAY_DE
			],
		]);

		$response = $accountService->getFulfillmentPoliciesByMarketplace($getFulfillmentPoliciesByMarketplaceRestRequest);

		$list = [];

		foreach($response->fulfillmentPolicies as $fulfillmentPolicy)
		{
			$list[ $fulfillmentPolicy->fulfillmentPolicyId ] = $fulfillmentPolicy->name;
		}

		return $list;
	}

	/**
	 * Create a Return Policy.
	 *
	 * @return string
	 */
	public function createReturnPolicy()
	{
		/** @var AccountService $accountService */
		$accountService = pluginApp(AccountService::class, [
			'config' => [
				'accessToken'  => $this->config->get('TestEbaySdk.accessToken'),
				'refreshToken' => $this->config->get('TestEbaySdk.refreshToken'),
			],
		]);

		/** @var CreateAReturnPolicyRestRequest $createAReturnPolicyRestRequest */
		$createAReturnPolicyRestRequest = pluginApp(CreateAReturnPolicyRestRequest::class, [
			'values' => [
				'marketplaceId'           => MarketplaceIdEnum::C_EBAY_DE,
				'name'                    => 'Test Return Policy REST',
				'description'             => 'This is a test return policy',
				'refundMethod'            => RefundMethodEnum::C_MONEY_BACK,
				'restockingFeePercentage' => '10',
				'returnInstructions'      => 'This are my return instructions',
				'returnPeriod'            => [
					'unit'  => TimeDurationUnitEnum::C_DAY,
					'value' => 14,
				],
				'returnsAccepted'         => true,
				'returnShippingCostPayer' => ReturnShippingCostPayerEnum::C_BUYER,
			],
		]);


		$response = $accountService->createAReturnPolicy($createAReturnPolicyRestRequest);

		return $response;
	}

	/**
	 * Get a Fulfillment Policy by ID.
	 *
	 * @param Request $request
	 *
	 * @return string
	 */
	public function getFulfillmentPolicyById(Request $request)
	{
		/** @var AccountService $accountService */
		$accountService = pluginApp(AccountService::class, [
			'config' => [
				'credentialsId' => $request->get('credentialsId'),
			],
		]);

		/** @var GetAFulfillmentPolicyByIDRestRequest $getAFulfillmentPolicyByIDRestRequest */
		$getAFulfillmentPolicyByIDRestRequest = pluginApp(GetAFulfillmentPolicyByIDRestRequest::class, [
			'values' => [
				'fulfillmentPolicyId' => $request->get('id'),
			],
		]);

		$response = $accountService->getAFulfillmentPolicyByID($getAFulfillmentPolicyByIDRestRequest);

		return $response;
	}
}