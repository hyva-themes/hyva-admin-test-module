<?php declare(strict_types=1);

namespace Hyva\AdminTest\Model\Source;

use Magento\Store\Model\System\Store as SystemStore;

class StoreWithAllViews
{
    public function __construct(
        private SystemStore $systemStore
    ) {}

    public function toOptionArray(): array
    {
        return $this->systemStore->getStoreValuesForForm(false, true);
    }
}