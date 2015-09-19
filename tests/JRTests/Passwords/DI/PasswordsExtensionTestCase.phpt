<?php

namespace JRTests\Passwords\DI;

use Tester\Assert;
use Tester\TestCase;
use Nette\Configurator;
use Nette\DI\Compiler;
use Nette\Utils\Strings;
use JR\Passwords\DI\PasswordsExtension;

require_once __DIR__ . '/../../bootstrap.php';

/**
 * Description of PasswordsExtensionTestCase.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 */
final class PasswordsExtensionTestCase extends TestCase
{
	/**
	 * @return Configurator
	 */
	private function createConfigurator()
	{
		$configurator = new Configurator();
		$configurator->setTempDirectory(TEMP_DIR);
		$configurator->addParameters([
			'container' => [
				'class' => 'SystemContainer_' . Strings::random(),
			],
		]);
		
		$configurator->onCompile[] = function (Configurator $configurator, Compiler $compiler) {
			$passwordsExtension = new PasswordsExtension();
			$compiler->addExtension('passwords', $passwordsExtension);
			
			$extensions = $compiler->getExtensions('Nette\Bridges\ApplicationDI\ApplicationExtension');
			$applicationExtension = array_shift($extensions);
			if ($applicationExtension !== NULL) {
				$applicationExtension->defaults['scanDirs'] = FALSE;
			}
		};
		return $configurator;
	}
	
	/**
	 * @return void
	 */
	public function testConfiguration()
	{
		$configurator = $this->createConfigurator();
		$container = $configurator->createContainer();
		
		/* @var $passwordManager NettePasswordManager */
		$passwordManager = $container->getService('passwords.passwordManager');
		
		Assert::type('JR\Passwords\PasswordManager\NettePasswordManager', $passwordManager);
	}
}

run(new PasswordsExtensionTestCase());
