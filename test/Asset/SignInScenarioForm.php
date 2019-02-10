<?php

namespace Bupy7\InputFilter\Test\Asset;

use Bupy7\InputFilter\FormAbstract;

/**
 * @author Vasily Belosloodcev <https://github.com/bupy7>
 */
class SignInScenarioForm extends FormAbstract
{
    const SCENARIO_PASSWORD = 2;

    /**
     * @var string
     */
    public $email;
    /**
     * @var string
     */
    public $password;

    protected function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_PASSWORD] = [
            'password',
        ];
        return $scenarios;
    }

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
