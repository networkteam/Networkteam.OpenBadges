<?php
namespace Networkteam\OpenBadges\View\IssuerOrganization;

use Networkteam\OpenBadges\Domain\Model\IssuerOrganization;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\View\AbstractView;

class ShowJson extends AbstractView {

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Resource\ResourceManager
	 */
	protected $resourceManager;

	/**
	 * {@inheritdoc}
	 */
	public function render() {
		$this->controllerContext->getResponse()->setHeader('Content-Type', 'application/json');
		if (!isset($this->variables['value']) || !$this->variables['value'] instanceof IssuerOrganization) {
			throw new \InvalidArgumentException('ShowJson view expects an IssuerOrganization instance in the "value" variable', 1405612706);
		}
		/** @var IssuerOrganization $issuerOrganization */
		$issuerOrganization = $this->variables['value'];
		$array = $this->issuerOrganizationToArray($issuerOrganization);
		return json_encode($array);
	}

	/**
	 * @param IssuerOrganization $issuerOrganization
	 * @return array
	 */
	public function issuerOrganizationToArray(IssuerOrganization $issuerOrganization) {
		if ((string)$issuerOrganization->getImage() !== '') {
			if (strpos($issuerOrganization->getImage(), 'resource://') === 0) {
				$resourceViewHelper = new \TYPO3\Fluid\ViewHelpers\Uri\ResourceViewHelper();
				$renderingContext = new \TYPO3\Fluid\Core\Rendering\RenderingContext();
				$renderingContext->setControllerContext($this->controllerContext);
				$resourceViewHelper->setRenderingContext($renderingContext);
				$imageUri = $resourceViewHelper->render($issuerOrganization->getImage());
			} else {
				$imageUri = $issuerOrganization->getImage();
			}
		} else {
			$imageUri = NULL;
		}

		$result = array(
			'name' => $issuerOrganization->getName(),
			'description' => $issuerOrganization->getDescription(),
			'email' => $issuerOrganization->getEmail(),
			'url' => $issuerOrganization->getUrl()
		);
		if ($imageUri !== NULL) {
			$result['image'] = $imageUri;
		}
		return $result;
	}
}