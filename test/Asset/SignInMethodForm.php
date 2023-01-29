<?php

declare(strict_types=1);

namespace Bupy7\InputFilter\Test\Asset;

use Bupy7\InputFilter\FormAbstract;

final class SignInMethodForm extends FormAbstract
{
    /**
     * @var string|mixed
     */
    private $email;
    /**
     * @var string|mixed
     */
    private $password;

    public function setEmail($email): SignInMethodForm
    {
        $this->email = (string)$email;
        return $this;
    }

    public function getEmail(): string
    {
        return (string)$this->email;
    }

    /**
     * @param string $password
     * @return static
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function getPassword(): string
    {
        return (string)$this->password;
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
                    ]
                ],
            ],
        ];
    }
}
