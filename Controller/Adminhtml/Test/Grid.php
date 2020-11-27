<?php declare(strict_types=1);

namespace Hyva\AdminTest\Controller\Adminhtml\Test;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\View\Result\PageFactory;

class Grid extends Action implements HttpGetActionInterface, HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'Hyva_AdminTest::test';

    private $pageFactory;

    public function __construct(Context $context, PageFactory $pageFactory)
    {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
    }

    public function execute()
    {
        $page = $this->pageFactory->create();
        $page->getConfig()->getTitle()->prepend(__('Hyvä Grid Demo'));

        return $page;
    }
}
