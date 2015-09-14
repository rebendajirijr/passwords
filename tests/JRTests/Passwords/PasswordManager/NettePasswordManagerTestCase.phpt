<?php

namespace JRTests\Passwords\PasswordManager;

use Tester\Assert;
use Tester\TestCase;
use Nette\Security\Passwords;
use JR\Passwords\PasswordManager\NettePasswordManager;

require_once __DIR__ . '/../../bootstrap.php';

/**
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 */
final class NettePasswordManagerTestCase extends TestCase
{
	/** @var NettePasswordManager */
	private $passwordManager;
	
	protected function setUp()
	{
		parent::setUp();
		
		$this->passwordManager = new NettePasswordManager();
	}
	
	/**
	 * @return void
	 */
	public function testVerify()
	{
		Assert::true($this->passwordManager->verify('dg', '$2y$05$123456789012345678901uTj3G.8OMqoqrOMca1z/iBLqLNaWe6DK'));
		Assert::false($this->passwordManager->verify('dgx', '$2y$05$123456789012345678901uTj3G.8OMqoqrOMca1z/iBLqLNaWe6DK'));
	}
	
	/**
	 * @return void
	 */
	public function testHash()
	{
		$password = 'qep5e6Rm4ZvB1';
		$salt = 'PTBASkIrmtAXsZWwX5i3Cx';
		
		$expected = Passwords::hash($password, [
			'salt' => $salt,
		]);
		$actual = $this->passwordManager->hash($password, $salt);
		
		Assert::equal($expected, $actual);
	}
	
	/**
	 * @return void
	 */
	public function testGenerateThrowsInvalidArgumentException()
	{
		$passwordManager = $this->passwordManager;
		
		Assert::exception(function() use ($passwordManager) {
			$passwordManager->generate('1');
		}, 'Nette\Utils\AssertionException');
		
		Assert::exception(function() use ($passwordManager) {
			$passwordManager->generate(1.0);
		}, 'Nette\Utils\AssertionException');
		
		Assert::exception(function() use ($passwordManager) {
			$passwordManager->generate([
				'foo' => 'bar',
			]);
		}, 'Nette\Utils\AssertionException');
		
		Assert::exception(function() use ($passwordManager) {
			$passwordManager->generate(0);
		}, 'JR\Passwords\InvalidArgumentException', "Length must be greater or equal 1, value '0' given.");
		
	}
	
	/**
	 * @return void
	 */
	public function testNeedsRehash()
	{
		Assert::true($this->passwordManager->needsRehash('$2y$05$123456789012345678901uTj3G.8OMqoqrOMca1z/iBLqLNaWe6DK'));
	}
}

run(new NettePasswordManagerTestCase());
