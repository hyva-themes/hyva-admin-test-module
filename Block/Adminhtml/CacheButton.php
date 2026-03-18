<?php
namespace Hyva\AdminTest\Block\Adminhtml;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\AuthorizationInterface;

class CacheButton extends Template
{
    /**
     * @var AuthorizationInterface
     */
    protected $authorization;

    /**
     * @param Context $context
     * @param AuthorizationInterface $authorization
     * @param array $data
     */
    public function __construct(
        Context $context,
        AuthorizationInterface $authorization,
        array $data = []
    ) {
        $this->authorization = $authorization;
        parent::__construct($context, $data);
    }

    /**
     * Get flush cache URL
     *
     * @return string
     */
    public function getFlushCacheUrl()
    {
        return $this->getUrl('adminhtml/cache/flushSystem');
    }

    /**
     * Check if user has permission to flush cache
     *
     * @return bool
     */
    public function canFlushCache()
    {
        return $this->authorization->isAllowed('Magento_Backend::cache');
    }

    /**
     * Check if user has permission for specific resource
     *
     * @param string $resource
     * @return bool
     */
    public function isAllowed($resource)
    {
        return $this->authorization->isAllowed($resource);
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (!$this->canFlushCache()) {
            return '';
        }
        return parent::_toHtml();
    }
}