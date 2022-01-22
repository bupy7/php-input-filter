<?php declare(strict_types=1);

namespace Bupy7\InputFilter;

use Bupy7\InputFilter\InputFilter\InputFilter;
use Bupy7\InputFilter\Exception\InvalidCallException;
use Bupy7\InputFilter\Exception\UnknownPropertyException;
use Bupy7\InputFilter\InputFilter\ErrorMessageInterface;
use Bupy7\InputFilter\Exception\NotSupportedException;
use Laminas\InputFilter\InputFilterInterface;
use function method_exists;
use function get_class;
use function ucfirst;
use function count;
use function array_intersect;
use function array_key_exists;

abstract class FormAbstract implements FormInterface
{
    private ?InputFilterInterface $inputFilter = null;

    public function setInputFilter(InputFilterInterface $inputFilter): FormAbstract
    {
        $this->inputFilter = $inputFilter;
        $this->attachInputs();
        return $this;
    }

    public function getInputFilter(): InputFilterInterface
    {
        if ($this->inputFilter === null) {
            $this->setInputFilter(new InputFilter());
        }
        return $this->inputFilter;
    }

    /**
     * Validate inputs.
     * @param string|array|null $name
     * @return boolean
     */
    public function isValid($name = null): bool
    {
        $this->resetInputFilter();
        $this->getInputFilter()->setData($this->getValues());

        $names = $this->getInputNames();
        if ($name !== null) {
            $names = array_intersect($names, (array)$name);
        }
        $isValid = $this->getInputFilter()
            ->setValidationGroup($names)
            ->isValid();
        $this->setValues($this->getInputFilter()->getValues());

        return $isValid;
    }

    /**
     * Setting values into input filter.
     * @param array $values
     */
    public function setValues(array $values): void
    {
        foreach ($this->getInputNames() as $name) {
            if (array_key_exists($name, $values)) {
                $this->$name = $values[$name];
            }
        }
    }

    /**
     * Returns values from the input filter.
     * @return array
     */
    public function getValues(): array
    {
        $values = [];
        foreach ($this->getInputNames() as $name) {
            $values[$name] = $this->$name;
        }
        return $values;
    }

    /**
     * Set error message for the input.
     * @param string $name
     * @param string $error
     * @throws NotSupportedException
     */
    public function setError(string $name, string $error): void
    {
        if (!$this->getInputFilter() instanceof ErrorMessageInterface) {
            throw new NotSupportedException(sprintf(
                'Method %s::%s() is not supported.',
                get_class($this->getInputFilter()),
                __FUNCTION__
            ));
        }
        $this->getInputFilter()->setMessage($name, $error);
    }

    /**
     * List of errors where a key is name of field and value is array messages.
     * @return array
     */
    public function getErrors(): array
    {
        return $this->getInputFilter()->getMessages();
    }

    /**
     * Alert has errors about.
     * @return bool
     */
    public function hasErrors(): bool
    {
        return count($this->getInputFilter()->getInvalidInput()) !== 0;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @throws InvalidCallException
     * @throws UnknownPropertyException
     */
    public function __set($name, $value)
    {
        $method = 'set' . ucfirst($name);
        if (method_exists($this, $method)) {
            $this->$method($value);
        } elseif (method_exists($this, 'get' . ucfirst($name))) {
            throw new InvalidCallException('Setting read-only property: ' . get_class($this) . '::' . $name);
        } else {
            throw new UnknownPropertyException('Setting unknown property: ' . get_class($this) . '::' . $name);
        }
    }

    /**
     * @param string $name
     * @return mixed
     * @throws InvalidCallException
     * @throws UnknownPropertyException
     */
    public function __get($name)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        } elseif (method_exists($this, 'set' . ucfirst($name))) {
            throw new InvalidCallException('Getting write-only property: ' . get_class($this) . '::' . $name);
        }
        throw new UnknownPropertyException('Getting unknown property: ' . get_class($this) . '::' . $name);
    }

    /**
     * List of inputs form.
     * Each an element of an array should be like follow:
     * [
     *     'name'      => 'email',
     *     'required'  => true,
     *     'validators' => [
     *          [
     *              'name' => 'EmailAddress',
     *          ],
     *     ],
     *     // and etc
     * ]
     * @return array
     * @see \Laminas\InputFilter\InputInterface
     */
    abstract protected function inputs(): array;

    /**
     * Attaching declaring inputs into input filter.
     */
    private function attachInputs(): void
    {
        foreach ($this->inputs() as $input) {
            $this->getInputFilter()->add($input);
        }
    }

    /**
     * @since 2.0.0
     * @return array
     */
    private function getInputNames(): array
    {
        $inputNames = [];
        foreach ($this->getInputFilter()->getInputs() as $input) {
            $inputNames[] = $input->getName();
        }
        return $inputNames;
    }

    private function resetInputFilter(): void
    {
        foreach ($this->getInputFilter()->getInputs() as $input) {
            $this->getInputFilter()->remove($input->getName());
        }
        $this->attachInputs();
    }
}
