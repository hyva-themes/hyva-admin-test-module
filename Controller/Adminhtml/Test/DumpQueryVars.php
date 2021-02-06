<?php declare(strict_types=1);

namespace Hyva\AdminTest\Controller\Adminhtml\Test;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\View\Result\PageFactory;

class DumpQueryVars extends Action implements HttpPostActionInterface, HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Hyva_AdminTest::test';

    private $request;

    private $jsonFactory;

    private $pageFactory;

    public function __construct(Context $context, RequestInterface $request, JsonFactory $jsonFactory, PageFactory $pageFactory)
    {
        parent::__construct($context);
        $this->request = $request;
        $this->jsonFactory = $jsonFactory;
        $this->pageFactory = $pageFactory;
    }

    public function execute()
    {
        return $this->pageFactory->create();
    }
}
