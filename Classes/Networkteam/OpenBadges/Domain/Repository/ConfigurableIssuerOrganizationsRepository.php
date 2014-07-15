<?php
namespace Networkteam\OpenBadges\Domain\Repository;

use Networkteam\OpenBadges\Domain\Model\IssuerOrganization;
use TYPO3\Flow\Annotations as Flow;

class ConfigurableIssuerOrganizationsRepository implements IssuerOrganizationsRepositoryInterface {

	/**
	 * @Flow\Inject(setting="issuerOrganizations", package="Networkteam.OpenBadges")
	 * @var array
	 */
	protected $issuerOrganizationConfiguration;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Property\PropertyMapper
	 */
	protected $propertyMapper;

	/**
	 * {@inheritdoc}
	 */
	public function findAll() {
		$issuerOrganizations = array();
		if (!is_array($this->issuerOrganizationConfiguration)) {
			throw new \TYPO3\Flow\Configuration\Exception\InvalidConfigurationException('Expected array for setting "Networkteam.OpenBadges.issuerOrganizations"');
		}
		foreach ($this->issuerOrganizationConfiguration as $identifier => $issuerOrganizationConfiguration) {
			$issuerOrganization = $this->getIssuerOrganizationFromConfiguration($identifier, $issuerOrganizationConfiguration);
			$issuerOrganizations[] = $issuerOrganization;
		}
		return $issuerOrganizations;
	}

	/**
	 * @param string $identifier
	 * @return \Networkteam\OpenBadges\Domain\Model\IssuerOrganization
	 */
	public function findByIdentifier($identifier) {
		if (!isset($this->issuerOrganizationConfiguration[$identifier])) {
			throw new \TYPO3\Flow\Property\Exception\TargetNotFoundException('IssueOrganization with identifier "' . $identifier . '" not found', 1405267581);
		}

		return $this->getIssuerOrganizationFromConfiguration($identifier, $this->issuerOrganizationConfiguration[$identifier]);
	}

	/**
	 * @param string $identifier
	 * @param array $issuerOrganizationConfiguration
	 * @return IssuerOrganization
	 */
	protected function getIssuerOrganizationFromConfiguration($identifier, $issuerOrganizationConfiguration) {
		/** @var IssuerOrganization $issuerOrganization */
		$issuerOrganization = $this->propertyMapper->convert($issuerOrganizationConfiguration, 'Networkteam\OpenBadges\Domain\Model\IssuerOrganization');
		$issuerOrganization->setIdentifier($identifier);
		return $issuerOrganization;
	}
}