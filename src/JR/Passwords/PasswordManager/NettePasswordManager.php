<?php

namespace JR\Passwords\PasswordManager;

use Nette\Object;
use Nette\Security\Passwords;
use Nette\Utils\Random;
use Nette\Utils\Validators;
use JR\Passwords\InvalidArgumentException;
use JR\Passwords\IPasswordManager;

/**
 * Nette-driven password manager.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 */
class NettePasswordManager extends Object implements IPasswordManager
{
	/*
	 * @inheritdocss
	 */
	public function verify($password, $hash)
	{
		return Passwords::verify($password, $hash);
	}
	
	/*
	 * @inheritdoc
	 */
	public function generate($length = self::DEFAULT_LENGTH, $charlist = self::DEFAULT_CHARLIST)
	{
		Validators::assert($length, 'integer', 'length');
		if ($length < 1) {
			throw new InvalidArgumentException("Length must be greater or equal 1, value '$length' given.");
		}
		return Random::generate($length, $charlist);
	}
	
	/*
	 * @inheritdoc
	 */
	public function hash($password, $salt = NULL)
	{
		return Passwords::hash($password, [
			'salt' => $salt,
		]);
	}
	
	/*
	 * @inheritdoc
	 */
	public function needsRehash($hash)
	{
		return Passwords::needsRehash($hash);
	}
}
