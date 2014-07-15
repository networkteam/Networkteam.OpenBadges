<?php
namespace Networkteam\OpenBadges\Controller\Module;

use Networkteam\OpenBadges\Domain\Model\BadgeClass;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\ActionController;
use Networkteam\OpenBadges\Domain\Repository\BadgeClassRepository;
use Networkteam\OpenBadges\Domain\Repository\IssuerOrganizationsRepositoryInterface;

class BadgeClassController extends ActionController {

	/**
	 * @Flow\Inject
	 * @var BadgeClassRepository
	 */
	protected $badgeClassRepository;

	/**
	 * @Flow\Inject
	 * @var IssuerOrganizationsRepositoryInterface
	 */
	protected $issuerOrganizationsRepository;

	/**
	 * List badge classes
	 */
	public function indexAction() {
		$badgeClasses = $this->badgeClassRepository->findAll();
		$this->view->assign('badgeClasses', $badgeClasses);
	}

	/**
	 * Show a form to create a new badge class
	 */
	public function newAction() {
		$this->view->assign('issuerOrganizations', $this->issuerOrganizationsRepository->findAll());
	}

	/**
	 * Create a new badge class
	 *
	 * @param BadgeClass $badgeClass
	 */
	public function createAction(BadgeClass $badgeClass) {
		$this->badgeClassRepository->add($badgeClass);

		$this->addFlashMessage('The badge class was created succesfully.', 'Badge class created');

		$this->redirect('index');
	}

	/**
	 * Show a form to edit an existing badge class
	 *
	 * @param BadgeClass $badgeClass
	 * @Flow\IgnoreValidation("$badgeClass")
	 */
	public function editAction(BadgeClass $badgeClass) {
		$this->view->assign('badgeClass', $badgeClass);
		$this->view->assign('issuerOrganizations', $this->issuerOrganizationsRepository->findAll());
	}

	/**
	 * Update an existing badge class
	 *
	 * @param BadgeClass $badgeClass
	 */
	public function updateAction(BadgeClass $badgeClass) {
		$this->badgeClassRepository->update($badgeClass);

		$this->addFlashMessage('The badge class was saved succesfully.', 'Badge class saved');

		$this->redirect('index');
	}

}