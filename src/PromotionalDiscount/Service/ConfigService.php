<?php

declare(strict_types=1);

namespace PromotionalDiscount\Service;

readonly class ConfigService implements ConfigServiceInterface
{
    public function __construct(private array $config)
    {
    }

    public function getProductDataSourceFile(): string
    {
        return BASE_DIR
            . '/' . $this->config['data_source']['directory']
            . '/' . $this->config['data_source']['file_name'];
    }

    /**
     * @return string
     */
    public function getErrorLogFile(): string
    {
        return BASE_DIR
            . '/' . $this->config['error_log']['directory']
            . '/' . $this->config['error_log']['file_name'];
    }
}
