<?php
namespace Networkteam\OpenBadges\Domain\Service;

use Networkteam\OpenBadges\Domain\Model\AssertionStep;
use Networkteam\OpenBadges\Domain\Model\BadgeClass;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Cache\Frontend\VariableFrontend;

/**
 * @Flow\Scope("singleton")
 */
class BadgeAsserter {

	/**
	 * @var \TYPO3\Flow\Cache\Frontend\VariableFrontend
	 */
	protected $assertionStepStore;

	/**
	 * Assert that one step for a badge assertion was successful and store a time-limited proof on the server
	 *
	 * @param string $stepName A (fixed) identifier for the assertion step
	 * @return AssertionStep
	 */
	public function assertStep(BadgeClass $badgeClass, $stepIdentifier) {
		$assertionStep = new AssertionStep($badgeClass, $stepIdentifier);

		$this->assertionStepStore->set($assertionStep->getToken(), $assertionStep);

		return $assertionStep;
	}

	/**
	 * @param \TYPO3\Flow\Cache\Frontend\VariableFrontend $assertionStepStore
	 */
	public function setAssertionStepStore($assertionStepStore) {
		$this->assertionStepStore = $assertionStepStore;
	}

}
