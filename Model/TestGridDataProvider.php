<?php declare(strict_types=1);

namespace Hyva\AdminTest\Model;

use Hyva\Admin\Api\HyvaGridArrayProviderInterface;

class TestGridDataProvider implements HyvaGridArrayProviderInterface
{
    public function getHyvaGridData(): array
    {
        return [
            ['name' => 'Louis', 'age' => 51, 'weight' => 5.32, 'family' => 'royals'],
            ['name' => 'Wilma', 'age' => 42, 'weight' => 2.1, 'family' => 'royals'],
            ['name' => 'Niza', 'age' => 18, 'weight' => 1.87, 'family' => 'royals'],
            ['name' => 'Bob', 'age' => 30, 'weight' => 2.6, 'family' => 'fub'],
            ['name' => 'Geal', 'age' => 32, 'weight' => 2.1, 'family' => 'lala'],
            ['name' => 'Snaz', 'age' => 87, 'weight' => 4, 'family' => 'lala'],
            ['name' => 'Pete', 'age' => 28, 'weight' => 3.9, 'family' => 'fub-lala'],
        ];
    }
}
