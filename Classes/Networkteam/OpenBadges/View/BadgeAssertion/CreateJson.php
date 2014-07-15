<?php
namespace Networkteam\OpenBadges\View\BadgeAssertion;

use Networkteam\OpenBadges\Domain\Model\BadgeAssertion;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\View\AbstractView;

class CreateJson extends AbstractView {

	/**
	 * {@inheritdoc}
	 */
	public function render() {
		$this->controllerContext->getResponse()->setHeader('Content-Type', 'application/json');
		if (!isset($this->variables['value']) || !$this->variables['value'] instanceof BadgeAssertion) {
			throw new \InvalidArgumentException('ShowJson view expects a BadgeAssertion instance in the "value" variable', 1405435021);
		}
		/** @var BadgeAssertion $badgeAssertion */
		$badgeAssertion = $this->variables['value'];

		$assertionUri = $this->controllerContext->getUriBuilder()
			->reset()
			->setCreateAbsoluteUri(TRUE)
			->setFormat('json')
			->uriFor('show', array('badgeAssertion' => $badgeAssertion));

		return json_encode(array('location' => $assertionUri));
	}

}