<?php

declare(strict_types=1);

namespace Bupy7\InputFilter\Test\Asset;

use Bupy7\InputFilter\FormAbstract;

final class SignInAccessForm extends FormAbstract
{
    /**
     * @var string|mixed
     */
    private $email;
    /**
     * @var string|mixed
     */
    private $password;

    public function getEmail(): string
    {
        return (string)$this->email;
    }

    /**
     * @param string|mixed $password
     * @return SignInAccessForm
     */
    public function setPassword($password): SignInAccessForm
    {
        $this->password = (string)$password;
        return $this;
    }

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
