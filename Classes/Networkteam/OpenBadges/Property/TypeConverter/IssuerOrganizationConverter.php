<?php
namespace Networkteam\OpenBadges\Property\TypeConverter;

use \TYPO3\Flow\Annotations as Flow;

class IssuerOrganizationConverter extends \TYPO3\Flow\Property\TypeConverter\AbstractTypeConverter {

	/**
	 * {@inheritdoc}
	 */
	protected $sourceTypes = array('string');

	/**
	 * {@inheritdoc}
	 */
	protected $targetType = 'Networkteam\OpenBadges\Domain\Model\IssuerOrganization';

	/**
	 * {@inheritdoc}
	 */
	protected $priority = 1;

	/**
	 * @Flow\Inject
	 * @var \Networkteam\OpenBadges\Domain\Repository\IssuerOrganizationsRepositoryInterface
	 */
	protected $issuerOrganizationsRepository;

	/**
	 * {@inheritdoc}
	 */
	public function convertFrom($source, $targetType, array $convertedChildProperties = array(), \TYPO3\Flow\Property\PropertyMappingConfigurationInterface $configuration = NULL) {
		$issuerOrganization = $this->issuerOrganizationsRepository->findByIdentifier($source);
		return $issuerOrganization;
	}

}