<?php

declare(strict_types=1);

namespace Bupy7\InputFilter;

/**
 * @since 2.0.0
 */
interface FormInterface
{
    /**
     * @param string|array|null $name
     * @return boolean
     */
    public function isValid($name = null): bool;

    public function setValues(array $values): void;

    public function getValues(): array;

    public function getErrors(): array;
}
