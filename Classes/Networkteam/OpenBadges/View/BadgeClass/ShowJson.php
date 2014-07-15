<?php
namespace Networkteam\OpenBadges\View\BadgeClass;

use Networkteam\OpenBadges\Domain\Model\BadgeClass;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\View\AbstractView;

class ShowJson extends AbstractView {

	const BADGE_IMAGE_SIZE = 256;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Property\PropertyMapper
	 */
	protected $propertyMapper;

	/**
	 * {@inheritdoc}
	 */
	public function render() {
		$this->controllerContext->getResponse()->setHeader('Content-Type', 'application/json');
		if (!isset($this->variables['value']) || !$this->variables['value'] instanceof BadgeClass) {
			throw new \InvalidArgumentException('ShowJson view expects a BadgeClass instance in the "value" variable', 1405341637);
		}
		/** @var BadgeClass $badgeClass */
		$badgeClass = $this->variables['value'];
		$array = $this->badgeClassToArray($badgeClass);
		return json_encode($array);
	}

	/**
	 * @param BadgeClass $badgeClass
	 * @return array
	 */
	public function badgeClassToArray(BadgeClass $badgeClass) {
		if ($badgeClass->getImage() !== NULL) {
			$helper = new \TYPO3\Media\ViewHelpers\Uri\ImageViewHelper();
			$imageUri = $helper->render($badgeClass->getImage(), self::BADGE_IMAGE_SIZE, self::BADGE_IMAGE_SIZE, FALSE, FALSE);
		} else {
			$imageUri = NULL;
		}

		if (strpos($badgeClass->getCriteria(), 'http') === 0) {
			$criteriaUri = $badgeClass->getCriteria();
		} else {
			$criteriaNode = $this->propertyMapper->convert($badgeClass->getCriteria(), 'TYPO3\TYPO3CR\Domain\Model\NodeInterface');
			if ($criteriaNode === NULL) {
				$criteriaUri = NULL;
			} else {
				$criteriaUri = $this->controllerContext->getUriBuilder()
					->reset()
					->setCreateAbsoluteUri(TRUE)
					->setFormat('html')
					->uriFor('show', array('node' => $criteriaNode), 'Frontend\Node', 'TYPO3.Neos');
			}
		}

		$issuerUri = $this->controllerContext->getUriBuilder()
			->reset()
			->setCreateAbsoluteUri(TRUE)
			->setFormat('json')
			->uriFor('show', array('issuerOrganization' => $badgeClass->getIssuerIdentifier()), 'IssuerOrganization');


		return array(
			'name' => $badgeClass->getName(),
			'description' => $badgeClass->getDescription(),
			'image' => $imageUri,
			'criteria' => $criteriaUri,
			'issuer' => $issuerUri,
			'tags' => $badgeClass->getTags()
		);
	}
}