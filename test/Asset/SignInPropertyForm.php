<?php

namespace Bupy7\InputFilter\Test\Asset;

use Bupy7\InputFilter\FormAbstract;

/**
 * @author Vasily Belosloodcev <https://github.com/bupy7>
 */
class SignInPropertyForm extends FormAbstract
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
                'filters' => [
                    [
                        'name' => 'StringTrim',
                    ]
                ],
            ],
        ];
    }
}
