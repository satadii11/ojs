<?php

/**
 * @file controllers/grid/subscriptions/InstitutionalSubscriptionsGridHandler.inc.php
 *
 * Copyright (c) 2014-2018 Simon Fraser University
 * Copyright (c) 2000-2018 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class InstitutionalSubscriptionsGridHandler
 * @ingroup controllers_grid_subscriptions
 *
 * @brief Handle subscription grid requests.
 */

import('controllers.grid.subscriptions.SubscriptionsGridHandler');

import('controllers.grid.subscriptions.InstitutionalSubscriptionForm');

class InstitutionalSubscriptionsGridHandler extends SubscriptionsGridHandler {
	/**
	 * @copydoc GridHandler::initialize()
	 */
	function initialize($request, $args = null) {
		parent::initialize($request, $args);

		// Basic grid configuration.
		$this->setTitle('subscriptionManager.institutionalSubscriptions');

		//
		// Grid columns.
		//
		$cellProvider = new SubscriptionsGridCellProvider();

		$this->addColumn(
			new GridColumn(
				'name',
				'common.name',
				null,
				null,
				$cellProvider
			)
		);
		$this->addColumn(
			new GridColumn(
				'subscriptionType',
				'manager.subscriptions.subscriptionType',
				null,
				null,
				$cellProvider
			)
		);
		$this->addColumn(
			new GridColumn(
				'status',
				'manager.subscriptions.form.status',
				null,
				null,
				$cellProvider
			)
		);
		$this->addColumn(
			new GridColumn(
				'dateStart',
				'manager.subscriptions.dateStart',
				null,
				null,
				$cellProvider
			)
		);
		$this->addColumn(
			new GridColumn(
				'dateEnd',
				'manager.subscriptions.dateEnd',
				null,
				null,
				$cellProvider
			)
		);
		$this->addColumn(
			new GridColumn(
				'referenceNumber',
				'manager.subscriptions.referenceNumber',
				null,
				null,
				$cellProvider
			)
		);
	}


	//
	// Implement methods from GridHandler.
	//
	/**
	 * @copydoc GridHandler::renderFilter()
	 */
	function renderFilter($request) {
		$context = $request->getContext();

		// Import PKPUserDAO to define the SUBSCRIPTION_* constants.
		import('classes.subscription.InstitutionalSubscriptionDAO');
		$fieldOptions = array(
			SUBSCRIPTION_USER => 'common.user',
			SUBSCRIPTION_MEMBERSHIP => 'user.subscriptions.form.membership',
			SUBSCRIPTION_REFERENCE_NUMBER => 'manager.subscriptions.form.referenceNumber',
			SUBSCRIPTION_NOTES => 'manager.subscriptions.form.notes',
			SUBSCRIPTION_INSTITUTION_NAME => 'manager.subscriptions.form.institutionName',
			SUBSCRIPTION_DOMAIN => 'manager.subscriptions.form.domain',
			SUBSCRIPTION_IP_RANGE => 'manager.subscriptions.form.ipRange',
		);

		$matchOptions = array(
			'contains' => 'form.contains',
			'is' => 'form.is'
		);

		$filterData = array(
			'fieldOptions' => $fieldOptions,
			'matchOptions' => $matchOptions
		);

		return parent::renderFilter($request, $filterData);
	}

	/**
	 * @copydoc GridHandler::loadData()
	 * @param $request PKPRequest
	 * @return array Grid data.
	 */
	protected function loadData($request, $filter) {
		// Get the context.
		$journal = $request->getContext();

		$subscriptionDao = DAORegistry::getDAO('InstitutionalSubscriptionDAO');
		$rangeInfo = $this->getGridRangeInfo($request, $this->getId());
		return $subscriptionDao->getByJournalId($journal->getId(), null, $filter['searchField'], $filter['searchMatch'], $filter['search']?$filter['search']:null, null, null, null, $rangeInfo);
	}


	//
	// Public grid actions.
	//
	/**
	 * Edit an existing subscription.
	 * @param $args array
	 * @param $request PKPRequest
	 * @return JSONMessage JSON object
	 */
	function editSubscription($args, $request) {
		// Form handling.
		$subscriptionForm = new InstitutionalSubscriptionForm($request, $request->getUserVar('rowId'));
		$subscriptionForm->initData($args, $request);

		return new JSONMessage(true, $subscriptionForm->fetch($request));
	}

	/**
	 * Update an existing subscription.
	 * @param $args array
	 * @param $request PKPRequest
	 * @return JSONMessage JSON object
	 */
	function updateSubscription($args, $request) {
		$subscriptionId = (int) $request->getUserVar('subscriptionId');
		// Form handling.
		$subscriptionForm = new InstitutionalSubscriptionForm($request, $subscriptionId);
		$subscriptionForm->readInputData();

		if ($subscriptionForm->validate()) {
			$subscriptionForm->execute($args, $request);
			$notificationManager = new NotificationManager();
			$notificationManager->createTrivialNotification($request->getUser()->getId(), NOTIFICATION_TYPE_SUCCESS);
			// Prepare the grid row data.
			return DAO::getDataChangedEvent($subscriptionId);
		} else {
			return new JSONMessage(true, $subscriptionForm->fetch($request));
		}
	}

	/**
	 * Delete a subscription.
	 * @param $args array
	 * @param $request PKPRequest
	 * @return JSONMessage JSON object
	 */
	function deleteSubscription($args, $request) {
		if (!$request->checkCSRF()) return new JSONMessage(false);

		$context = $request->getContext();
		$user = $request->getUser();

		// Identify the subscription ID.
		$subscriptionId = $request->getUserVar('rowId');
		$subscriptionDao = DAORegistry::getDAO('InstitutionalSubscriptionDAO');
		$subscriptionDao->deleteById($subscriptionId, $context->getId());
		return DAO::getDataChangedEvent();
	}
}

?>