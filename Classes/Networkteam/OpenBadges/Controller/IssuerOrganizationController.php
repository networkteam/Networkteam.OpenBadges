<?php
namespace Networkteam\OpenBadges\Controller;

use Networkteam\OpenBadges\Domain\Model\IssuerOrganization;
use Networkteam\OpenBadges\Domain\Repository\IssuerOrganizationsRepositoryInterface;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\ActionController;
use TYPO3\Flow\Mvc\View\JsonView;

class IssuerOrganizationController extends ActionController {

	protected $supportedMediaTypes = array('application/json');

	protected $viewFormatToObjectNameMap = array('json' => 'TYPO3\Flow\Mvc\View\JsonView');

	/**
	 * @Flow\Inject
	 * @var IssuerOrganizationsRepositoryInterface
	 */
	protected $issuerOrganizationsRepository;

	/**
	 * Show an issuer organization
	 *
	 * @param IssuerOrganization $issuerOrganization
	 */
	public function showAction(IssuerOrganization $issuerOrganization) {
		/** @var \Networkteam\OpenBadges\Domain\Model\IssuerOrganization $issuerOrganization */
		$issuerOrganization->setBaseUriForDefaultUrl($this->request->getHttpRequest()->getBaseUri());

		if ($this->view instanceof JsonView) {
			$this->view->setConfiguration(array(
				'value' => array(
	 				'_exclude' => array('identifier')
				)
			));
		}

		$this->view->assign('value', $issuerOrganization);
	}

}