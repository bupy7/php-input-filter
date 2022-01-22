<?php

declare(strict_types=1);

namespace Bupy7\InputFilter;

use Laminas\InputFilter\InputFilterInterface as LaminasInputFilterInterface;
use Laminas\InputFilter\InputInterface;

/**
 * @since 2.0.0
 */
interface InputFilterInterface extends LaminasInputFilterInterface
{
    /**
     * @return InputInterface[]
     */
    public function getInputs();

    /**
     * Set error message for an input and mark an input as invalid.
     * @param string $name
     * @param string $message
     */
    public function setMessage(string $name, string $message): void;
}
