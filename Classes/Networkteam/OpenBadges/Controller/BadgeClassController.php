<?php
namespace Networkteam\OpenBadges\Controller;

use Networkteam\OpenBadges\Domain\Model\BadgeClass;
use Networkteam\OpenBadges\Domain\Repository\BadgeClassRepository;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\ActionController;

class BadgeClassController extends ActionController {

	protected $supportedMediaTypes = array('application/json');

	/**
	 * @Flow\Inject
	 * @var BadgeClassRepository
	 */
	protected $badgeClassRepository;

	/**
	 * List badge classes
	 */
	public function indexAction() {
		$badgeClasses = $this->badgeClassRepository->findAll();
		$this->view->assign('value', $badgeClasses);
	}

	/**
	 * Show a badge class
	 *
	 * @param BadgeClass $badgeClass
	 */
	public function showAction(BadgeClass $badgeClass) {
		$this->view->assign('value', $badgeClass);
	}

}