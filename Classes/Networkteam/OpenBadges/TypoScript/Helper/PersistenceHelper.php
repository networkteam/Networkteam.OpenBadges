<?php
namespace Networkteam\OpenBadges\TypoScript\Helper;

use TYPO3\Flow\Annotations as Flow;

class PersistenceHelper implements \TYPO3\Eel\ProtectedContextAwareInterface {

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Persistence\PersistenceManagerInterface
	 */
	protected $persistenceManager;

	/**
	 * @param object $object
	 * @return string
	 */
	public function identifier($object) {
		return is_object($object) ? $this->persistenceManager->getIdentifierByObject($object) : NULL;
	}

	/**
	 * {@inheritdoc}
	 */
	public function allowsCallOfMethod($methodName) {
		return TRUE;
	}
}
