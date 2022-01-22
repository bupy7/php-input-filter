php-input-filter
================

[![Latest Stable Version](https://poser.pugx.org/bupy7/php-input-filter/v/stable)](https://packagist.org/packages/bupy7/php-input-filter)
[![Total Downloads](https://poser.pugx.org/bupy7/php-input-filter/downloads)](https://packagist.org/packages/bupy7/php-input-filter)
[![Latest Unstable Version](https://poser.pugx.org/bupy7/php-input-filter/v/unstable)](https://packagist.org/packages/bupy7/php-input-filter)
[![License](https://poser.pugx.org/bupy7/php-input-filter/license)](https://packagist.org/packages/bupy7/php-input-filter)
[![Build Status](https://travis-ci.org/bupy7/php-input-filter.svg?branch=master)](https://travis-ci.org/bupy7/php-input-filter)
[![Coverage Status](https://coveralls.io/repos/github/bupy7/php-input-filter/badge.svg?branch=master)](https://coveralls.io/github/bupy7/php-input-filter?branch=master)

A simple and powerful input filter for any PHP application. It's like a form, but not the same. ;)

Supporting PHP from 5.6 up to 8.1.

Installation
------------

The preferred way to install this extension is through composer:

```
$ composer require bupy7/php-input-filter "*"
```

or add

```
"bupy7/php-input-filter": "*"
```

to the require section of your composer.json file.

Usage
-----

Form:

```php
// module/Application/src/Form/SignInForm.php

use Bupy7\InputFilter\FormAbstract;

class SignInForm extends FormAbstract
{
    /**
     * @var string 
     */
    public $email;
    /**
     * @var string 
     */
    public $password;

    protected function inputs()
    {
        return [
            [
                'name' => 'email',
                'required' => true,
                'validators' => [
                    [
                        'name' => 'EmailAddress',
                    ],
                ],
            ],
            [
                'name' => 'password',
                'required' => true,
            ],
        ];
    }
}
```

Action:

```php
// module/Application/src/Action/AuthAction.php

use Application/Form/SignInForm;

$signInForm = new SignInForm();
if ($this->getRequest()->isPost()) {
    $signInForm->setValues($this->getRequest()->getPost());
    if ($signInForm->isValid()) {
        // authentication...
        // $auth->setLogin($signInForm->email)
        // $auth->setPassword($signInForm->password);
        // $result = $auth->authenticate();
        if ($result->isValid()) {
            // some actions
        }
    }
}

// to do something next
```

Using scenarios
--------------

By default using `FormAbstract::DEFAULT_SCENARIO` but you can use your customs one:

```php
// module/Application/src/Form/SignInForm.php

use Bupy7\InputFilter\FormAbstract;

class SignInForm extends FormAbstract
{
    const SCENARIO_PASSWORD = 'password';

    /**
     * @var string
     */
    public $email;
    /**
     * @var string
     */
    public $password;

    protected function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_PASSWORD] = [
            'password',
        ];
        return $scenarios;
    }

    protected function inputs()
    {
        return [
            [
                'name' => 'email',
                'required' => true,
                'validators' => [
                    [
                        'name' => 'EmailAddress',
                    ],
                ],
            ],
            [
                'name' => 'password',
                'required' => true,
                'filters' => [
                    [
                        'name' => 'StringTrim',
                    ]
                ],
            ],
        ];
    }
}
```

Action:

```php
// DEFAULT scenario
$signInForm = new SignInForm();
$signInForm->email = 'test@gmail.com';
$signInForm->password = '12q34e56t78';
if ($signInForm->isValid()) {
    // do something
}

// or PASSWORD scenario
$signInForm = new SignInForm();
$signInForm->setScenario(SignInForm::SCENARIO_PASSWORD);
$signInForm->password = '12q34e56t78';
if ($signInForm->isValid()) {
    // do something
}
```

Links
-----

The `php-input-filter` was based on `Zend Input Filter`, `Zend Validator` and `Zend Filters`.

- [Documentation of `zendframework/zend-inputfilter`](https://zendframework.github.io/zend-inputfilter/);
- [Documentation of `zendframework/zend-validator`](https://zendframework.github.io/zend-validator/);
- [Documentation of `zendframework/zend-filter`](https://zendframework.github.io/zend-filter/).

License
-------

php-input-filter is released under the BSD 3-Clause License.
