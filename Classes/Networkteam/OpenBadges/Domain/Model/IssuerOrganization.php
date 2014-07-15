<?php
namespace Networkteam\OpenBadges\Domain\Model;

use TYPO3\Flow\Annotations as Flow;

class IssuerOrganization {

	/**
	 * @Flow\Identity
	 * @var string
	 */
	protected $identifier;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $url;

	/**
	 * @var string
	 */
	protected $description;

	/**
	 * @var string
	 */
	protected $image;

	/**
	 * @var string
	 */
	protected $email;

	/**
	 * @param string $identifier
	 */
	public function setIdentifier($identifier) {
		$this->identifier = $identifier;
	}

	/**
	 * @return string
	 */
	public function getIdentifier() {
		return $this->identifier;
	}

	/**
	 * @param string $description
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param string $email
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * @return string
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @param string $image
	 */
	public function setImage($image) {
		$this->image = $image;
	}

	/**
	 * @return string
	 */
	public function getImage() {
		return $this->image;
	}

	/**
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param string $url
	 */
	public function setUrl($url) {
		$this->url = $url;
	}

	/**
	 * @return string
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
	 * Set the base URI of the current request and use it for the url if none is configured
	 *
	 * @param \TYPO3\Flow\Http\Uri $baseUri
	 */
	public function setBaseUriForDefaultUrl(\TYPO3\Flow\Http\Uri $baseUri) {
		if ((string)$this->url === '') {
			$this->url = (string)$baseUri;
		}
	}
}
