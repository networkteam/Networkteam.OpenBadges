<?php
namespace Networkteam\OpenBadges\Controller;

use Networkteam\OpenBadges\Domain\Model\BadgeAssertion;
use Networkteam\OpenBadges\Domain\Model\BadgeClass;
use Networkteam\OpenBadges\Domain\Repository\BadgeAssertionRepository;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\ActionController;

class BadgeAssertionController extends ActionController {

	protected $supportedMediaTypes = array('application/json');

	/**
	 * @Flow\Inject
	 * @var BadgeAssertionRepository
	 */
	protected $badgeAssertionRepository;

	/**
	 * Show a badge assertion
	 *
	 * @param BadgeAssertion $badgeAssertion
	 */
	public function showAction(BadgeAssertion $badgeAssertion) {
		$this->view->assign('value', $badgeAssertion);
	}

	public function initializeCreateAction() {
		$configuration = $this->arguments->getArgument('tokens')->getPropertyMappingConfiguration();
		$configuration->allowAllProperties();
	}

	/**
	 * @param BadgeClass $badgeClass
	 * @param string $recipientEmail
	 * @param array<string> $tokens
	 */
	public function createAction(BadgeClass $badgeClass, $recipientEmail, array $tokens) {
		// TODO Check if tokens exist in assertion step store and get the step identifiers
		// TODO Check if all step identifiers for the badge class are completed

		$badgeAssertion = new BadgeAssertion();
		$badgeAssertion->setBadgeClass($badgeClass);
		$badgeAssertion->setIssuedOn(new \DateTime());
		$badgeAssertion->setRecipientEmail($recipientEmail);

		$this->badgeAssertionRepository->add($badgeAssertion);

		$this->view->assign('value', $badgeAssertion);

		$this->response->setStatus(201);
	}

}