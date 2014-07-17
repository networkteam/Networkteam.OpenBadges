<?php
namespace Networkteam\OpenBadges\View\BadgeAssertion;

use Networkteam\OpenBadges\Domain\Model\BadgeAssertion;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\View\AbstractView;

class ShowJson extends AbstractView {

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Persistence\PersistenceManagerInterface
	 */
	protected $persistenceManager;

	/**
	 * {@inheritdoc}
	 */
	public function render() {
		$this->controllerContext->getResponse()->setHeader('Content-Type', 'application/json');
		if (!isset($this->variables['value']) || !$this->variables['value'] instanceof BadgeAssertion) {
			throw new \InvalidArgumentException('ShowJson view expects a BadgeAssertion instance in the "value" variable', 1405343744);
		}
		/** @var BadgeAssertion $badgeAssertion */
		$badgeAssertion = $this->variables['value'];
		$array = $this->badgeAssertionToArray($badgeAssertion);
		return json_encode($array);
	}

	/**
	 * @param BadgeAssertion $badgeAssertion
	 * @return array
	 */
	public function badgeAssertionToArray(BadgeAssertion $badgeAssertion) {
		$badgeClassUri = $this->controllerContext->getUriBuilder()
			->reset()
			->setCreateAbsoluteUri(TRUE)
			->setFormat('json')
			->uriFor('show', array('badgeClass' => $badgeAssertion->getBadgeClass()), 'BadgeClass');
		$badgeAssertionUri = $this->controllerContext->getUriBuilder()
			->reset()
			->setCreateAbsoluteUri(TRUE)
			->setFormat('json')
			->uriFor('show', array('badgeAssertion' => $badgeAssertion), 'BadgeAssertion');

		$badgeAssertionIdentifier = $this->persistenceManager->getIdentifierByObject($badgeAssertion);

		return array(
			'uid' => $badgeAssertionIdentifier,
			'recipient' => $badgeAssertion->getIdentityObject(),
			'badge' => $badgeClassUri,
			'verify' => array(
				'type' => 'hosted',
				'url' => $badgeAssertionUri
			),
			'issuedOn' => $badgeAssertion->getIssuedOn()->format('c')
		);
	}
}