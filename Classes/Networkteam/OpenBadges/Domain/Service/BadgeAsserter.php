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
	 * @var VariableFrontend
	 */
	protected $assertionStepStore;

	/**
	 * Assert that one step for a badge assertion was successful and store a time-limited proof on the server
	 *
	 * @param BadgeClass $badgeClass
	 * @param string $stepIdentifier A (fixed) identifier for the assertion step
	 * @return AssertionStep
	 */
	public function assertStep(BadgeClass $badgeClass, $stepIdentifier) {
		$assertionStep = new AssertionStep($badgeClass, $stepIdentifier);

		$this->assertionStepStore->set($assertionStep->getToken(), $assertionStep);

		return $assertionStep;
	}

	/**
	 * Validate that all required assertion steps of a badge were completed and remove the stored assertion steps for all tokens
	 *
	 * @param BadgeClass $badgeClass
	 * @param array $tokens
	 * @return boolean
	 */
	public function validateAndClearAssertionSteps(BadgeClass $badgeClass, array $tokens) {
		$completedAssertionSteps = array();

		foreach ($tokens as $token) {
			$assertionStep = $this->assertionStepStore->get($token);
			if ($assertionStep instanceof AssertionStep && $assertionStep->getBadgeClass() === $badgeClass) {
				$completedAssertionSteps[$assertionStep->getIdentifier()] = $assertionStep;
			}
		}

		foreach ($badgeClass->getAssertionSteps() as $stepIdentifier) {
			if (!isset($completedAssertionSteps[$stepIdentifier])) {
				return FALSE;
			}
		}

		foreach ($tokens as $token) {
			$this->assertionStepStore->remove($token);
		}

		return TRUE;
	}

	/**
	 * @param VariableFrontend $assertionStepStore
	 */
	public function setAssertionStepStore($assertionStepStore) {
		$this->assertionStepStore = $assertionStepStore;
	}

}
