<?php declare(strict_types=1);

namespace Hyva\AdminTest\Model;

use Hyva\Admin\Api\HyvaGridArrayProviderInterface;

class LargeArrayProvider implements HyvaGridArrayProviderInterface
{
    /**
     * @var string[]
     */
    private $chars;

    public function __construct()
    {
        $this->chars = range('a', 'z');
    }

    private function randomChar(): string
    {
        return $this->chars[array_rand($this->chars)];
    }

    private function randomString(int $min = null, int $max = null): string
    {
        $length = random_int($min ?? 6, $max ?? 24);
        return implode('', array_map([$this, 'randomChar'], range(1, $length)));
    }

    public function getHyvaGridData(): array
    {
        $rows = range(1, 1000);
        return array_map(function (int $a, int $b): array {
            return ['first' => $a, 'second' => -$b + 1, 'third' => $this->randomString()];
        }, $rows, $rows);
    }
}
