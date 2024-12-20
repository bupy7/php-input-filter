<?php

declare(strict_types=1);

namespace Bupy7\InputFilter\Test\Asset;

use Bupy7\InputFilter\FormAbstract;

final class SignInPropertyForm extends FormAbstract
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
                'filters' => [
                    [
                        'name' => 'StringTrim',
                    ],
                ],
            ],
        ];
    }
}
