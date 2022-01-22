<?php declare(strict_types=1);

namespace Bupy7\InputFilter\Test\Asset;

use Bupy7\InputFilter\InputFilter\ErrorMessageInterface;
use Bupy7\InputFilter\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterInterface;

abstract class BaseFilter implements InputFilterInterface, ErrorMessageInterface
{
    private InputFilter $inputFilter;

    public function __construct(array $inputs)
    {
        $this->inputFilter = new InputFilter();
        foreach ($inputs as $input) {
            $this->inputFilter->add($input);
        }
    }

    public function add($input, $name = null)
    {
        return $this->inputFilter->add($input, $name);
    }

    public function get($name)
    {
        return $this->inputFilter->get($name);
    }

    public function has($name)
    {
        return $this->inputFilter->has($name);
    }

    public function remove($name)
    {
        return $this->inputFilter->remove($name);
    }

    public function setData($data)
    {
        return $this->inputFilter->setData($data);
    }

    public function isValid()
    {
        return $this->inputFilter->isValid();
    }

    public function setValidationGroup($name)
    {
        return $this->inputFilter->setValidationGroup($name);
    }

    public function getInvalidInput()
    {
        return $this->inputFilter->getInvalidInput();
    }

    public function getValidInput()
    {
        return $this->inputFilter->getValidInput();
    }

    public function getValue($name)
    {
        return $this->inputFilter->getValue($name);
    }

    public function getValues()
    {
        return $this->inputFilter->getValues();
    }

    public function getRawValue($name)
    {
        return $this->inputFilter->getRawValue($name);
    }

    public function getRawValues()
    {
        return $this->inputFilter->getRawValues();
    }

    public function getMessages()
    {
        return $this->inputFilter->getMessages();
    }

    public function count(): int
    {
        return $this->inputFilter->count();
    }

    public function setMessage(string $name, string $message): ErrorMessageInterface
    {
        return $this->inputFilter->setMessage($name, $message);
    }

    /**
     * @return InputFilterInterface[]|\Laminas\InputFilter\InputInterface[]
     */
    public function getInputs()
    {
        return $this->inputFilter->getInputs();
    }
}
