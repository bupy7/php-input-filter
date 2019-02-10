<?php

namespace Bupy7\InputFilter\Test\Asset;

use Bupy7\InputFilter\InputFilter\InputFilter;

/**
 * @author Vasily Belosloodcev <https://github.com/bupy7>
 */
class ProfileFilter extends InputFilter
{
    public function __construct()
    {
        $this->add([
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
        ]);
    }
}
