<?php

namespace Bupy7\InputFilter\Test\Asset;

use Zend\InputFilter\InputFilter;

/**
 * @author Vasily Belosloodcev <https://github.com/bupy7>
 */
class SignInFilter extends InputFilter
{
    public function __construct()
    {
        $this->add([
            'name' => 'email',
            'required' => true,
            'validators' => [
                [
                    'name' => 'EmailAddress',
                ],
            ],
        ]);
        $this->add([
            'name' => 'password',
            'required' => true,
            'filters' => [
                [
                    'name' => 'StringTrim',
                ],
            ],
        ]);
    }
}
