<?php

namespace Bupy7\InputFilter\InputFilter;

/**
 * @author Vasily Belosloodcev <https://github.com/bupy7>
 */
interface ErrorMessageInterface
{
    /**
     * Set error message for an input and mark an input as invalid.
     * @param string $name
     * @param string $message
     * @return static
     */
    public function setMessage($name, $message);
}
