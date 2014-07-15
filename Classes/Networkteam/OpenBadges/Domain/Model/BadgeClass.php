<?php
namespace Networkteam\OpenBadges\Domain\Model;

use Doctrine\ORM\Mapping as ORM;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Media\Domain\Model\Image;

/**
 * @Flow\Entity
 */
class BadgeClass {

	/**
	 * The name of the achievement
	 *
	 * @var string
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $name;

	/**
	 * A short description of the achievement
	 *
	 * @var string
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $description;

	/**
	 * An image representing the achievement (the badge)
	 *
	 * @ORM\ManyToOne(cascade={"persist", "remove"})
	 * @var Image
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $image;

	/**
	 * URL of the criteria for earning the achievement
	 *
	 * TODO Could / should be a reference to a node
	 *
	 * @var string
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $criteria = '';

	/**
	 * The identifier of the issuer organization
	 *
	 * @var string
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $issuerIdentifier;

	/**
	 * List of tags that describe the type of achievement
	 *
	 * @ORM\Column(type="json_array")
	 * @var array<string>
	 */
	protected $tags = array();

	/**
	 * @param string $criteria
	 */
	public function setCriteria($criteria) {
		$this->criteria = $criteria;
	}

	/**
	 * @return string
	 */
	public function getCriteria() {
		return $this->criteria;
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
	 * @param \TYPO3\Media\Domain\Model\Image $image
	 */
	public function setImage($image) {
		$this->image = $image;
	}

	/**
	 * @return \TYPO3\Media\Domain\Model\Image
	 */
	public function getImage() {
		return $this->image;
	}

	/**
	 * @param string $issuerIdentifier
	 */
	public function setIssuerIdentifier($issuerIdentifier) {
		$this->issuerIdentifier = $issuerIdentifier;
	}

	/**
	 * @return string
	 */
	public function getIssuerIdentifier() {
		return $this->issuerIdentifier;
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
	 * @param array $tags
	 */
	public function setTags($tags) {
		$this->tags = $tags;
	}

	/**
	 * @return array
	 */
	public function getTags() {
		return $this->tags;
	}

	/**
	 * @return string
	 */
	public function getTagsString() {
		return implode(', ', $this->tags);
	}

	/**
	 * @param string $tagsString
	 */
	public function setTagsString($tagsString) {
		$this->tags = \TYPO3\Flow\Utility\Arrays::trimExplode(',', $tagsString, TRUE);
	}

}
