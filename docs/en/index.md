# Quickstart

Lightweight Nette-powered password generation and hashing.

## Installation

1. Install the package using [Composer](http://getcomposer.org/):

   ```sh
   $ composer require jr/passwords
   ```

2. Register the extension via standard [neon config](https://github.com/nette/neon):

   ```yml
   extensions:
		themed: JR\Passwords\DI\PasswordsExtension
   ```

3. Use `JR\Passwords\IPasswordManager` interface in your services:
   ```php
   use Nette\Application\UI\Presenter;
   use JR\Passwords\IPasswordManager;

   class MyPresenter extends Presenter
   {
       /** @var IPasswordManager */
       private $passwordManager;

       public function __construct(IPasswordManager $passwordManager)
       {
           $this->passwordManager = $passwordManager;
       }

       /**
        * IPasswordManager example usage.
        *
        * @return void
        */
       private function foo()
       {
           // generate some random password
           $length = 8; // defaults to 10
           $charlist = 'a-zA-Z0-9'; // defaults to 0-9a-z
           $password = $this->passwordManager->generate($length, $charlist);

           // hash password
           $salt = 'abcd1234'; // defaults to NULL
           $hashedPassword = $this->passwordManager->hash($password, $salt);

           // verify password
           $inputPassword = 'pass1234';
           $matches = $this->passwordManager->verify($inputPassword, $hashedPassword);
           var_dump($matches); // FALSE
       }
   }
   ```