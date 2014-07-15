<?php
namespace Networkteam\OpenBadges\Domain\Model;

use TYPO3\Flow\Annotations as Flow;

/**
 * An assertion step to get a badge assertion
 *
 * Can be used to have multiple "elements" that need to be "solved" to "earn" a badge (create an assertion).
 * Each action that solves a step needs to emit an AssertionStep using ... to prevent client side fraud of
 * badges (e.g. copying a link to get a badge assertion).
 */
class AssertionStep {

	/**
	 * @var string
	 */
	protected $identifier;

	/**
	 * @var string
	 */
	protected $token;

	/**
	 * @var BadgeClass
	 */
	protected $badgeClass;

	/**
	 * @param BadgeClass $badgeClass The badge class where this step is needed for an assertion
	 * @param string $identifier An identifier for this step (unique per badge class), used to reference steps client- and server-side
	 */
	public function __construct(BadgeClass $badgeClass, $identifier) {
		$this->badgeClass = $badgeClass;
		$this->identifier = $identifier;
		$this->token = \TYPO3\Flow\Utility\Algorithms::generateUUID();
	}

	/**
	 * @return string
	 */
	public function getIdentifier() {
		return $this->identifier;
	}

	/**
	 * A per-user token that is used to claim this step of a badge assertion
	 *
	 * @return string
	 */
	public function getToken() {
		return $this->token;
	}

	/**
	 * @return \Networkteam\OpenBadges\Domain\Model\BadgeClass
	 */
	public function getBadgeClass() {
		return $this->badgeClass;
	}

}
