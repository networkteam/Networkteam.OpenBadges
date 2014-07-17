<?php
namespace Networkteam\OpenBadges\Domain\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Networkteam\OpenBadges\Domain\Model\BadgeClass;
use TYPO3\Flow\Annotations as Flow;

/**
 * Doctrine event listener for flushing the content cache when badge classes change
 *
 * @Flow\Scope("singleton")
 */
class BadgeClassEventListener {

	/**
	 * @Flow\Inject
	 * @var \TYPO3\TypoScript\Core\Cache\ContentCache
	 */
	protected $contentCache;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Persistence\PersistenceManagerInterface
	 */
	protected $persistenceManager;

	/**
	 * @param LifecycleEventArgs $eventArgs
	 * @return void
	 */
	public function postUpdate(LifecycleEventArgs $eventArgs) {
		if ($eventArgs->getEntity() instanceof BadgeClass) {
			$this->contentCache->flushByTag('BadgeClass_' . $this->persistenceManager->getIdentifierByObject($eventArgs->getEntity()));
		}
	}

}
