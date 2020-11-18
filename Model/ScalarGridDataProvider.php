<?php declare(strict_types=1);

namespace Hyva\AdminTest\Model;

use Hyva\Admin\Api\HyvaGridArrayProviderInterface;

class ScalarGridDataProvider implements HyvaGridArrayProviderInterface
{
    public function getHyvaGridData(): array
    {
        return [
            ['name' => 'Louis', 'age' => 51, 'weight' => 5.32, 'family' => 'royals', 'friends' => []],
            ['name' => 'Wilma', 'age' => 42, 'weight' => 2.1, 'family' => 'royals', 'friends' => []],
            ['name' => 'Niza', 'age' => 18, 'weight' => 1.87, 'family' => 'royals', 'friends' => []],
            ['name' => 'Bob', 'age' => 30, 'weight' => 2.6, 'family' => 'fub', 'friends' => ['Snaz', 'Wilma']],
            ['name' => 'Geal', 'age' => 32, 'weight' => 2.1, 'family' => 'lala', 'friends' => []],
            ['name' => 'Snaz', 'age' => 87, 'weight' => 4, 'family' => 'lala', 'friends' => []],
            ['name' => 'Pete', 'age' => 28, 'weight' => 3.9, 'family' => 'fub-lala', 'friends' => []],
        ];
    }
}
