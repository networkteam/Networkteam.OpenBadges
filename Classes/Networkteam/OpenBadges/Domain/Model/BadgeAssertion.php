<?php
namespace Networkteam\OpenBadges\Domain\Model;

use Doctrine\ORM\Mapping as ORM;
use TYPO3\Flow\Annotations as Flow;

/**
 * @Flow\Entity
 */
class BadgeAssertion {

	/**
	 * Email address for the recipient identity (hashed)
	 *
	 * @var string
	 */
	protected $recipientEmailHash;

	/**
	 * The type of badge being awarded
	 *
	 * @ORM\ManyToOne
	 * @var BadgeClass
	 */
	protected $badgeClass;

	/**
	 * Date that the achievement was awarded
	 *
	 * @var \DateTime
	 */
	protected $issuedOn;

	/**
	 * @param \Networkteam\OpenBadges\Domain\Model\BadgeClass $badgeClass
	 */
	public function setBadgeClass($badgeClass) {
		$this->badgeClass = $badgeClass;
	}

	/**
	 * @return \Networkteam\OpenBadges\Domain\Model\BadgeClass
	 */
	public function getBadgeClass() {
		return $this->badgeClass;
	}

	/**
	 * @param \DateTime $issuedOn
	 */
	public function setIssuedOn($issuedOn) {
		$this->issuedOn = $issuedOn;
	}

	/**
	 * @return \DateTime
	 */
	public function getIssuedOn() {
		return $this->issuedOn;
	}

	/**
	 * Set the recipient identity object from an email (hashed)
	 *
	 * @param string $recipientEmail
	 */
	public function setRecipientEmail($recipientEmail) {
		$this->recipientEmailHash = 'sha256$' . hash('sha256', $recipientEmail);
	}

	/**
	 * @return IdentityObject
	 */
	public function getIdentityObject() {
		return new IdentityObject('email', $this->recipientEmailHash, TRUE);
	}

}