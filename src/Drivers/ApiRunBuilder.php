<?php

namespace Styde\Enlighten\Drivers;

use Styde\Enlighten\ExampleGroupBuilder;
use Styde\Enlighten\RunBuilder;

class ApiRunBuilder implements RunBuilder
{
    public function newExampleGroup(): ExampleGroupBuilder
    {
        return new ApiExampleGroupBuilder($this);
    }

    public function reset(): void
    {
        // TODO: Implement reset() method.
    }

    public function save()
    {
        // TODO: Implement save() method.
    }
}