<?php

declare(strict_types=1);

namespace Bupy7\InputFilter\Test\Asset;

final class SignInFilter extends BaseFilter
{
    public function __construct()
    {
        parent::__construct([
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
        ]);
    }
}
