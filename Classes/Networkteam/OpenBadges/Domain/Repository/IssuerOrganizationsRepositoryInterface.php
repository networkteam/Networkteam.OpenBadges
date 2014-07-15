<?php
namespace Networkteam\OpenBadges\Domain\Repository;

use Networkteam\OpenBadges\Domain\Model\IssuerOrganization;

interface IssuerOrganizationsRepositoryInterface {

	/**
	 * @return array<IssuerOrganization> An array-like of IssuerOrganization objects
	 */
	public function findAll();

	/**
	 * @param string $identifier
	 * @return IssuerOrganization
	 */
	public function findByIdentifier($identifier);
}