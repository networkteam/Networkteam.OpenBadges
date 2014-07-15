<?php
namespace Networkteam\OpenBadges\Aspects;

use Networkteam\OpenBadges\Domain\Model\BadgeClass;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Aop\JoinPointInterface;

/**
 * @Flow\Aspect
 */
class BadgeClassContentElementWrappingAspect {

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Persistence\PersistenceManagerInterface
	 */
	protected $persistenceManager;

	/**
	 * @Flow\Around("method(TYPO3\Neos\Service\ContentElementWrappingService->getNodeProperty())")
	 * @param JoinPointInterface $joinPoint
	 */
	public function getNodePropertyWithBadgeClass(JoinPointInterface $joinPoint) {
		$result = $joinPoint->getAdviceChain()->proceed($joinPoint);
		if ($result instanceof BadgeClass) {
			return json_encode($this->persistenceManager->getIdentifierByObject($result));
		} else {
			return $result;
		}
	}

}