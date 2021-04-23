<?php declare(strict_types=1);

namespace Hyva\AdminTest\HyvaGridProcessor;

use Hyva\Admin\Model\GridSource\AbstractGridSourceProcessor;
use Magento\Catalog\Api\Data\ProductAttributeInterface as CatalogProduct;
use Magento\Eav\Model\Config as EavConfig;
use Magento\Framework\Api\Filter;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\DB\Select;

use function array_filter as filter;
use function array_map as map;
use function array_merge as merge;
use function array_reduce as reduce;
use function array_values as values;

class ProductGridQueryProcessor extends AbstractGridSourceProcessor
{
    private const GRID_ATTRIBUTES = ['name', 'thumbnail', 'visibility', 'status', 'price'];

    /**
     * @var EavConfig
     */
    private $eavConfig;

    public function __construct(EavConfig $eavConfig)
    {
        $this->eavConfig = $eavConfig;
    }

    private function addAttributeIdBindings(Select $select): void
    {
        $bindings = reduce(self::GRID_ATTRIBUTES, function (array $bindings, string $code): array {
            $id = $this->eavConfig->getAttribute(CatalogProduct::ENTITY_TYPE_CODE, $code)->getId();
            return merge($bindings, [':' . $code . '_id' => $id]);
        }, []);

        $select->bind($bindings);
    }

    /**
     * @param Select $select
     * @param SearchCriteriaInterface $searchCriteria
     * @param string $gridName
     */
    public function beforeLoad($select, SearchCriteriaInterface $searchCriteria, string $gridName): void
    {
        $this->addAttributeIdBindings($select);

        $this->applyWebsiteFilter($searchCriteria, $select);
    }

    private function getWebsiteFilter(SearchCriteriaInterface $searchCriteria): ?Filter
    {
        // return first filter for website or null if there is no matching filter
        $allFilters = merge(...values(map(function (FilterGroup $filterGroup): array {
            return $filterGroup->getFilters();
        }, $searchCriteria->getFilterGroups())));

        $websiteFilters = values(filter($allFilters, function (Filter $filter): bool {
            return $filter->getField() === 'website_ids';
        }));

        return $websiteFilters[0] ?? null;
    }

    private function applyWebsiteFilter(SearchCriteriaInterface $searchCriteria, Select $select): void
    {
        if ($websiteFilter = $this->getWebsiteFilter($searchCriteria)) {
            $this->applyWebsiteFilterToWebsiteJoinCondition($select, $websiteFilter->getValue());
            $this->removeSelectWebsiteFromWhereCondition($select);
        }
    }

    private function applyWebsiteFilterToWebsiteJoinCondition(Select $select, $websiteFilterValue): void
    {
        $from              = $select->getPart(Select::FROM);
        $websiteJoin       = $from['t_website'] ?? [];
        $condition         = 't_website.website_id=' . ((int) $websiteFilterValue);
        $replacement       = [
            'joinType'      => Select::INNER_JOIN,
            'joinCondition' => $websiteJoin['joinCondition'] . ' AND ' . $condition,
        ];
        $from['t_website'] = merge($from['t_website'], $replacement);
        $select->setPart(Select::FROM, $from);
    }

    private function removeSelectWebsiteFromWhereCondition(Select $select): void
    {
        $where = filter($select->getPart(Select::WHERE), function ($condition): bool {
            return strpos((string) $condition, 'website_ids') === false;
        });
        $select->setPart(Select::WHERE, $where);
    }
}
