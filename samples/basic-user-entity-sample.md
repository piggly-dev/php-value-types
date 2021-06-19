## Real-world sample

Let's see the user entity:

```php
<?php

use Piggly\ValueTypes\Advanced\EmailType;
use Piggly\ValueTypes\Advanced\PasswordType;
use Piggly\ValueTypes\Advanced\UrlType;
use Piggly\ValueTypes\Common\StringType;

class UserEntity
{
	/**
	 * Name.
	 * @var StringType
	 */
	protected $name;

	/**
	 * E-mail.
	 * @var EmailType
	 */
	protected $email;

	/**
	 * Password.
	 * @var PasswordType
	 */
	protected $password;

	/**
	 * Url.
	 * @var UrlType
	 */
	protected $bioLink;

	/**
	 * Constructor.
	 * @return void
	 */
	public function __construct ()
	{
		// Create all defaults
		$this
			->setName()
			->setEmail()
			->setPassword()
			->setBioLink();
	}

	/**
	 * Get url.
	 *
	 * @since 1.0.0
	 * @return UrlType|null
	 */
	public function getBioLink () : UrlType
	{ return $this->bioLink; }

	/**
 	 * Set url.
	 *
	 * @param string $bioLink Url.
	 * @since 1.0.0
	 * @return self
	 */
	public function setBioLink ( string $bioLink = null )
	{ $this->bioLink = new UrlType($bioLink); return $this; }

	/**
	 * Get password.
	 *
	 * @since 1.0.0
	 * @return PasswordType|null
	 */
	public function getPassword () : PasswordType
	{ return $this->password; }

	/**
 	 * Set password.
	 *
	 * @param string $password Password.
	 * @since 1.0.0
	 * @return self
	 */
	public function setPassword ( string $password = null )
	{ $this->password = new PasswordType($password); return $this; }

	/**
	 * Get e-mail.
	 *
	 * @since 1.0.0
	 * @return EmailType
	 */
	public function getEmail () : EmailType
	{ return $this->email; }

	/**
 	 * Set e-mail.
	 *
	 * @param string $email E-mail.
	 * @since 1.0.0
	 * @return self
	 */
	public function setEmail ( string $email = null )
	{ $this->email = new EmailType($email, null, true); return $this; }

	/**
	 * Get name.
	 *
	 * @since 1.0.0
	 * @return StringType
	 */
	public function getName () : StringType
	{ return $this->name; }

	/**
 	 * Set name.
	 *
	 * @param string $name Name.
	 * @since 1.0.0
	 * @return self
	 */
	public function setName ( string $name = null )
	{ $this->name = new StringType($name, null, true); return $this; }
}
```

Let's undestand what was did above:

First, we defined all class attributes with its `AbstractValueType` objects. At any `set` method, we defined all standard to that object, i.e. if they are required and have a default value.

Then, at `constructor`, we initialize all attributes with a `null` value. Now, we are ready to manipulate this entity attributes. See below.

### Handling data

#### 1. I want to manipulate e-mail when it is valid:

```php
if ( $userEntity->getEmail()->validate() )
{ /** Email is valid and is set **/ }

// OR it may stop application

/** Stop if is not valid **/
$userEntity->getEmail()->assert();
/** Email is valid an is set **/
```

#### 2. I want to manipulate user bio link only if it is set and valid:

```php
if ( $userEntity->getUrl()->isNotNull() && $userEntity->getEmail()->validate() )
{ /** Url is valid and is set **/ }

// OR it may stop application

/** Stop if is not valid **/
if ( $userEntity->getUrl()->isNotNull() ) 
{ 
	$userEntity->getUrl()->assert();
	/** Url is valid an is set **/
}
```

#### 3. I want to check password:


```php
$raw = filter_input( INPUT_POST, 'password', FILTER_SANITIZE_STRING );
// ... get user entity at database ...

if ( !$userEntity->getPassword()->check($raw) )
{ /** Password is invalid **/ }

// OR it may stop application
$userEntity->getPassword()->verify($raw);
```

#### 4. Easy validating a login flow:

```php
$email  = filter_input( INPUT_POST, 'email', FILTER_SANITIZE_STRING );
$passwd = filter_input( INPUT_POST, 'passwd', FILTER_SANITIZE_STRING );
// ... get user entity at database ...

// It may stop application
$userEntity->getEmail()->assert();
$userEntity->getPassword()->verify($raw);
/** All expected is valid **/
```

#### 5. Enhanced getter behavior

You may want to not expose the value objects, instead is better returning the primitive value already validated. You can do it easelly at getters:

```php
// ...

public function getBioLink () : ?string
{ return $this->bioLink->isNull() ? null : $this->bioLink->assert()->get(); }

// ...

public function getEmail () : string
{ return $this->email->assert()->get(); }

public function getMaskedEmail () : string
{ return $this->email->assert()->masked(); }
```