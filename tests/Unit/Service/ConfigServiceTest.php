<?php

declare(strict_types=1);

namespace Tests\Unit\Service;

use PHPUnit\Framework\TestCase;
use PromotionalDiscount\Service\ConfigService;

class ConfigServiceTest extends TestCase
{
    protected array $config;

    protected ConfigService $configService;

    protected function setUp(): void
    {
        $this->config = include BASE_DIR . '/config/parameters.php';
        $this->configService = new ConfigService($this->config);
    }

    public function testGetProductDataSourceFile(): void
    {
        $employeeDataSourceFile = $this->configService->getProductDataSourceFile();
        $expectedEmployeeDataSourceFile = BASE_DIR
            . '/' . $this->config['data_source']['directory']
            . '/' . $this->config['data_source']['file_name'];

        $this->assertSame($expectedEmployeeDataSourceFile, $employeeDataSourceFile);
    }

    public function testGetErrorLogFile(): void
    {
        $logFile = $this->configService->getErrorLogFile();
        $expectedLogFile = BASE_DIR
            . '/' . $this->config['error_log']['directory']
            . '/' . $this->config['error_log']['file_name'];

        $this->assertSame($expectedLogFile, $logFile);
    }
}
