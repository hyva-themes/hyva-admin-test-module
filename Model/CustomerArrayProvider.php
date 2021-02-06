<?php declare(strict_types=1);

namespace Hyva\AdminTest\Model;

use Hyva\Admin\Api\HyvaGridArrayProviderInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Reflection\DataObjectProcessor;

class CustomerArrayProvider implements HyvaGridArrayProviderInterface
{
    private $customerRepository;

    private $searchCriteriaBuilder;

    private $dataObjectProcessor;

    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        DataObjectProcessor $dataObjectProcessor
    ) {
        $this->customerRepository    = $customerRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->dataObjectProcessor   = $dataObjectProcessor;
    }

    public function getHyvaGridData(): array
    {
        $customers = $this->customerRepository->getList($this->searchCriteriaBuilder->create())->getItems();
        return array_map(function (CustomerInterface $customer): array {
            return $this->dataObjectProcessor->buildOutputDataArray($customer, CustomerInterface::class);
        }, $customers);
    }
}
