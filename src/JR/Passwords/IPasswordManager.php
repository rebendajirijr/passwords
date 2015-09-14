<?php

namespace JR\Passwords;

use Nette\Utils\AssertionException;
use JR\Passwords\InvalidArgumentException;

/**
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 */
interface IPasswordManager
{
	/** @var int */
	const DEFAULT_LENGTH = 10;
	
	/** @var string */
	const DEFAULT_CHARLIST = '0-9a-z';
	
	/**
	 * Verifies that a password matches a hash.
	 * 
	 * @param string Original password
	 * @param string Hashed password
	 * @return bool
	 */
	function verify($password, $hash);
	
	/**
	 * Generates random password.
	 * 
	 * @param int
	 * @return string
	 * @throws AssertionException
	 * @throws InvalidArgumentException
	 */
	function generate($length = self::DEFAULT_LENGTH, $charlist = self::DEFAULT_CHARLIST);
	
	/**
	 * Computes salted password hash.
	 * 
	 * @param string
	 * @param string|NULL NULL means random salt
	 * @return string
	 */
	function hash($password, $salt = NULL);
	
	/**
	 * Checks if the given hash need to be rehashed.
	 * 
	 * @param string Hashed password
	 * @return bool
	 */
	function needsRehash($hash);
}
