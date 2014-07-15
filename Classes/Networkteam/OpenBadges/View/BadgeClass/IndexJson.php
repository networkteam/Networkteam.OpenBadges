<?php
namespace Networkteam\OpenBadges\View\BadgeClass;

use Networkteam\OpenBadges\Domain\Model\BadgeClass;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\View\AbstractView;

class IndexJson extends \TYPO3\Flow\Mvc\View\JsonView {

	protected $configuration = array(
		'value' => array(
			'_descendAll' => array(
				'_only' => array('name'),
				'_exposeObjectIdentifier' => TRUE,
	 			'_exposedObjectIdentifierKey' => 'identifier'
			)
		)
	);

}