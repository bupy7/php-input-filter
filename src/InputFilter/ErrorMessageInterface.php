<?php declare(strict_types=1);

namespace Bupy7\InputFilter\InputFilter;

interface ErrorMessageInterface
{
    /**
     * Set error message for an input and mark an input as invalid.
     * @param string $name
     * @param string $message
     * @return ErrorMessageInterface
     */
    public function setMessage(string $name, string $message): ErrorMessageInterface;
}
