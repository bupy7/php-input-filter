<?php declare(strict_types=1);

namespace Bupy7\InputFilter\Test\Asset;

use Bupy7\InputFilter\FormAbstract;

final class NullForm extends FormAbstract
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
                'required' => false,
                'filters' => [
                    [
                        'name' => 'ToNull',
                    ],
                ],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'max' => 6,
                        ],
                    ],
                ],
            ],
        ];
    }
}
