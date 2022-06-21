<?php

declare(strict_types=1);

namespace Thingston\Tests\Http\Exception\Handler;

use PHPUnit\Framework\TestCase;
use Thingston\Http\Exception\Handler\ExceptionHandlerSettings;

final class ExceptionHandlerSettingsTest extends TestCase
{
    public function testSettings(): void
    {
        $settings = new ExceptionHandlerSettings();

        $this->assertFalse($settings->get(ExceptionHandlerSettings::DEBUG));
        $this->assertTrue($settings->get(ExceptionHandlerSettings::LOG_ERRORS));
        $this->assertFalse($settings->get(ExceptionHandlerSettings::LOG_DETAILS));
    }
}
