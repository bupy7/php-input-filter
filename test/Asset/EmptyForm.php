<?php

declare(strict_types=1);

namespace Bupy7\InputFilter\Test\Asset;

use Bupy7\InputFilter\FormAbstract;

final class EmptyForm extends FormAbstract
{
    protected function inputs(): array
    {
        return [];
    }
}
