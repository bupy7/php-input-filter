<?php

namespace Bupy7\InputFilter\Test\Asset;

use Bupy7\InputFilter\FormAbstract;

/**
 * @author Vasily Belosloodcev <https://github.com/bupy7>
 */
class ProfileForm extends FormAbstract
{
    /**
     * @var int
     */
    public $age;

    protected function inputs()
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
