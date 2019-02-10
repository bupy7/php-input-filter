<?php

namespace Bupy7\InputFilter;

use Zend\InputFilter\BaseInputFilter;
use Bupy7\InputFilter\InputFilter\InputFilter;
use Bupy7\InputFilter\Exception\InvalidCallException;
use Bupy7\InputFilter\Exception\UnknownPropertyException;
use Bupy7\InputFilter\InputFilter\ErrorMessageInterface;
use Bupy7\InputFilter\Exception\NotSupportedException;

/**
 * @author Vasily Belosloodcev <https://github.com/bupy7>
 */
abstract class FormAbstract
{
    /**
     * Default scenario for inputs.
     */
    const SCENARIO_DEFAULT = 'default';

    /**
     * @var BaseInputFilter
     */
    protected $inputFilter;
    /**
     * @var int|string The current scenario for inputs.
     */
    protected $scenario = self::SCENARIO_DEFAULT;

    /**
     * @param BaseInputFilter $inputFilter
     * @return static
     */
    public function setInputFilter(BaseInputFilter $inputFilter)
    {
        $this->inputFilter = $inputFilter;
        $this->attachInputs();
        return $this;
    }

    /**
     * @return BaseInputFilter
     */
    public function getInputFilter()
    {
        if ($this->inputFilter === null) {
            $this->setInputFilter(new InputFilter);
        }
        return $this->inputFilter;
    }

    /**
     * Validate inputs.
     * @param string|array|null $name
     * @return boolean
     */
    public function isValid($name = null)
    {
        $this->resetInputFilter()
            ->getInputFilter()
            ->setData($this->getValues());

        $names = $this->findScenario();
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
     * @return static
     */
    public function setValues($values)
    {
        foreach ($this->findScenario() as $name) {
            if (array_key_exists($name, $values)) {
                $this->$name = $values[$name];
            }
        }
        return $this;
    }

    /**
     * Returns values from the input filter.
     * @return array
     */
    public function getValues()
    {
        $values = [];
        foreach ($this->findScenario() as $name) {
            $values[$name] = $this->$name;
        }
        return $values;
    }

    /**
     * Set error message for the input.
     * @param string $name
     * @param string $error
     * @return static
     * @throws NotSupportedException
     */
    public function setError($name, $error)
    {
        if (!$this->getInputFilter() instanceof ErrorMessageInterface) {
            throw new NotSupportedException(sprintf(
                'Method %s::%s() is not supported.',
                get_class($this->getInputFilter()),
                __FUNCTION__
            ));
        }
        $this->getInputFilter()->setMessage($name, $error);
        return $this;
    }

    /**
     * List of errors where a key is name of field and value is array messages.
     * @return array
     */
    public function getErrors()
    {
        return $this->getInputFilter()->getMessages();
    }

    /**
     * Alert has errors about.
     * @return bool
     */
    public function hasErrors()
    {
        return !empty($this->getInputFilter()->getInvalidInput());
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
     * @param int|string $scenario
     * @return static
     */
    public function setScenario($scenario)
    {
        $this->scenario = $scenario;
        return $this;
    }

    /**
     * @return int|string
     */
    public function getScenario()
    {
        return $this->scenario;
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
     * @see \Zend\InputFilter\InputInterface
     */
    protected function inputs()
    {
        return [];
    }

    /**
     * Attaching declaring inputs into input filter.
     * @return static
     */
    protected function attachInputs()
    {
        foreach ($this->inputs() as $input) {
            $this->getInputFilter()->add($input);
        }
        return $this;
    }

    /**
     * Collection of scenarios input names.
     * Each an element of a scenario should be like follow:
     * [
     *      self::SCENARIO_EXAMPLE_1 => ['email', 'password'],
     *      self::SCENARIO_EXAMPLE_2 => ['person', 'email', 'password'],
     * ]
     * By default uses input names from declared inputs as SCENARIO_DEFAULT.
     * @return array
     */
    protected function scenarios()
    {
        $scenarios = [self::SCENARIO_DEFAULT => []];
        foreach ($this->getInputFilter()->getInputs() as $input) {
            $scenarios[self::SCENARIO_DEFAULT][] = $input->getName();
        }
        return $scenarios;
    }

    /**
     * Return current scenario input names.
     * @param int|string $scenario
     * @return array
     */
    protected function findScenario($scenario = null)
    {
        $scenarios = $this->scenarios();
        if ($scenario === null) {
            $scenario = $this->getScenario();
        }
        return isset($scenarios[$scenario]) ? $scenarios[$scenario] : [];
    }

    /**
     * @return static
     */
    protected function resetInputFilter()
    {
        foreach ($this->getInputFilter()->getInputs() as $input) {
            $this->getInputFilter()->remove($input->getName());
        }
        $this->attachInputs();
        return $this;
    }
}
