<?php declare(strict_types=1);

namespace Bupy7\InputFilter\InputFilter;

use Laminas\InputFilter\InputFilter as BaseInputFilter;

final class InputFilter extends BaseInputFilter implements ErrorMessageInterface
{
    /**
     * @param string $name
     * @param string $message
     * @return InputFilter|ErrorMessageInterface
     */
    public function setMessage(string $name, string $message): ErrorMessageInterface
    {
        if (!$this->has($name)) {
            return $this;
        }
        $input = $this->get($name);
        $input->setErrorMessage($message);
        if (isset($this->validInputs[$name])) {
            unset($this->validInputs[$name]);
            $this->invalidInputs[$name] = $input;
        }
        return $this;
    }
}
