<?php
namespace Networkteam\OpenBadges\Domain\Model;

use TYPO3\Flow\Annotations as Flow;

class IdentityObject implements \JsonSerializable {

	/**
	 * Either the hash of the identity or the plaintext value
	 *
	 * The identity hash is a hash string preceded by a dollar sign ("$") and the algorithm used to generate the hash.
	 *
	 * @var string
	 */
	protected $identity;

	/**
	 * The type of identity
	 *
	 * @var string
	 */
	protected $type;

	/**
	 * Whether or not the identity value is hashed
	 *
	 * @var boolean
	 */
	protected $hashed;

	/**
	 * If the recipient is hashed, this should contain the string used to salt the hash
	 *
	 * @var string
	 */
	protected $salt;

	/**
	 * @param string $type
	 * @param string $identity
	 * @param boolean $hashed
	 * @param string $salt
	 */
	public function __construct($type, $identity, $hashed, $salt = NULL) {
		$this->type = $type;
		$this->identity = $identity;
		$this->hashed = $hashed;
		$this->salt = $salt;
	}

	/**
	 * @return boolean
	 */
	public function getHashed() {
		return $this->hashed;
	}

	/**
	 * @return string
	 */
	public function getIdentity() {
		return $this->identity;
	}

	/**
	 * @return string
	 */
	public function getSalt() {
		return $this->salt;
	}

	/**
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * {@inheritdoc}
	 */
	public function jsonSerialize() {
		$data = array(
			'type' => $this->type,
			'identity' => $this->identity,
			'hashed' => $this->hashed
		);
		if ((string)$this->salt !== '') {
			$data['salt'] = $this->salt;
		}
		return $data;
	}
}
