<?php

declare(strict_types=1);

namespace Spiral\Tests;

use Spiral\RoadRunner\Environment;
use Spiral\RoadRunner\EnvironmentInterface;
use Spiral\RoadRunnerBridge\RoadRunnerMode;

final class RoadRunnerModeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->getContainer()->removeBinding(RoadRunnerMode::class);
    }

    /**
     * @dataProvider roadRunnerModes
     */
    public function testDetectMode(string $mode, RoadRunnerMode $expected): void
    {
        $this->getContainer()->bind(EnvironmentInterface::class, static fn () => new Environment([
            'RR_MODE' => $mode,
        ]));

        $this->assertSame($expected, $this->getContainer()->get(RoadRunnerMode::class));
    }

    public function roadRunnerModes()
    {
        return [
            'http' => ['http', RoadRunnerMode::Http],
            'tcp' => ['tcp', RoadRunnerMode::Tcp],
            'grpc' => ['grpc', RoadRunnerMode::Grpc],
            'temporal' => ['temporal', RoadRunnerMode::Temporal],
            'jobs' => ['jobs', RoadRunnerMode::Jobs],
            'test' => ['test', RoadRunnerMode::Unknown],
        ];
    }
}
