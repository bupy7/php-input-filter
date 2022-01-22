<?php declare(strict_types=1);

namespace Bupy7\InputFilter\Test\Asset;

final class ProfileFilter extends BaseFilter
{
    public function __construct()
    {
        parent::__construct([[
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
        ]]);
    }
}
