<?php

namespace Styde\Enlighten\Tests;

use Illuminate\Support\Str;
use NunoMaduro\Collision\Adapters\Phpunit\Style as CollisionStyle;
use Styde\Enlighten\TestRun;
use Throwable;

class CollisionStyleExtension extends CollisionStyle
{
    /**
     * Displays the error using Collision's writer
     * and terminates with exit code === 1.
     */
    public function writeError(Throwable $throwable): void
    {
        parent::writeError($throwable);

        if (is_array($test = $this->getTestClassAndMethod($throwable))) {
            $this->printEnlightenLink($test);
        }
    }

    private function getTestClassAndMethod(Throwable $throwable)
    {
        return collect($throwable->getTrace())
            ->reverse()
            ->skipUntil(function ($trace) {
                return $trace['class'] === 'PHPUnit\Framework\TestCase' && $trace['function'] === 'runTest';
            })
            ->skip(1)
            ->first();
    }

    private function printEnlightenLink(array $test): void
    {
        $link = TestRun::getInstance()->getFailedTestLink($test['class'].'::'.$test['function']);

        if (is_null($link)) {
            return;
        }

        $this->output->write('<fg=white;bg=black;options=bold>💡️ See in Enlighten: </>');
        $this->output->write("<fg=yellow;bg=black;options=bold>{$link}</>\n\n");
    }
}
