php-input-filter
===

[![Stable Version](https://poser.pugx.org/bupy7/php-input-filter/v/stable)](https://packagist.org/packages/bupy7/php-input-filter)
[![Build status](https://github.com/bupy7/php-input-filter/actions/workflows/build.yml/badge.svg)](https://github.com/bupy7/php-input-filter/actions/workflows/build.yml)
[![Coverage Status](https://coveralls.io/repos/github/bupy7/php-input-filter/badge.svg?branch=master)](https://coveralls.io/github/bupy7/php-input-filter?branch=master)
[![Total Downloads](https://poser.pugx.org/bupy7/php-input-filter/downloads)](https://packagist.org/packages/bupy7/php-input-filter)
[![License](https://poser.pugx.org/bupy7/php-input-filter/license)](https://packagist.org/packages/bupy7/php-input-filter)

A simple and powerful input filter for any PHP application. It's alike a form, but not the same. ;)

Supporting PHP from 7.4 up to 8.1.

Installation
---

The preferred way to install this extension is through composer:

```
$ composer require bupy7/php-input-filter
```

or add

```
"bupy7/php-input-filter": "*"
```

to the `require` section of your composer.json file.

Usage
---

Form:

```php
// module/Application/src/Form/SignInForm.php

use Bupy7\InputFilter\FormAbstract;

class SignInForm extends FormAbstract
{
    /**
     * @var string|mixed
     */
    public $email;
    /**
     * @var string|mixed
     */
    public $password;

    protected function inputs(): array
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

Links
-----

The `php-input-filter` was based on `laminas/laminas-inputfilter`, `laminas/laminas-validator`
and `laminas/laminas-filter`.

- [Documentation of `laminas/laminas-inputfilter`](https://docs.laminas.dev/laminas-inputfilter/);
- [Documentation of `laminas/laminas-validator`](https://docs.laminas.dev/laminas-validator/);
- [Documentation of `laminas/laminas-filter`](https://docs.laminas.dev/laminas-filter/).

License
-------

`php-input-filter` is released under the BSD-3-Clause License.
