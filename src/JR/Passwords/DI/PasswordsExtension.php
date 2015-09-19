<?php

namespace JR\Passwords\DI;

use Nette\DI\CompilerExtension;

/**
 * Description of PasswordsExtension.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 */
class PasswordsExtension extends CompilerExtension
{
	/*
	 * @inheritdoc
	 */
	public function loadConfiguration()
	{
		parent::loadConfiguration();
		
		$containerBuilder = $this->getContainerBuilder();
		
		$containerBuilder->addDefinition($this->prefix('passwordManager'))
			->setClass('JR\Passwords\PasswordManager\NettePasswordManager');
	}
}
