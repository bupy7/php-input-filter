<?php

declare(strict_types=1);

namespace Bupy7\InputFilter;

use Laminas\InputFilter\InputFilter as BaseInputFilter;

/**
 * @since 2.0.0
 */
final class InputFilter extends BaseInputFilter implements InputFilterInterface
{
    /**
     * @param string $name
     * @param string $message
     */
    public function setMessage(string $name, string $message): void
    {
        if (!$this->has($name)) {
            return;
        }
        $input = $this->get($name);
        $input->setErrorMessage($message);
        if (isset($this->validInputs[$name])) {
            unset($this->validInputs[$name]);
            $this->invalidInputs[$name] = $input;
        }
    }
}
