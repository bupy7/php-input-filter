<?php

declare(strict_types=1);

namespace Bupy7\InputFilter\Test\Asset;

use Bupy7\InputFilter\FormAbstract;

final class ProfileForm extends FormAbstract
{
    /**
     * @var int|mixed
     */
    public $age;

    protected function inputs(): array
    {
        return [
            [
                'name' => 'age',
                'validators' => [
                    [
                        'name' => 'Digits',
                    ],
                    [
                       'name' => 'Between',
                       'options' => [
                            'min' => 1,
                            'max' => 100,
                       ],
                    ],
                ],
            ],
        ];
    }
}
