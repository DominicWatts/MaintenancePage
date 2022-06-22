<?php

namespace Xigen\MaintenancePage\Plugin\Frontend\Magento\Framework\View\Result;

/**
 * Class Page for MaintenancePage Plugin
 */
class Page
{
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Xigen\MaintenancePage\Helper\Page
     */
    protected $pageHelper;

    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Xigen\MaintenancePage\Helper\Page $pageHelper
    ) {
        $this->storeManager = $storeManager;
        $this->pageHelper = $pageHelper;
    }

    /**
     * @param \Magento\Framework\View\Result\Page $subject
     * @return \Magento\Framework\View\Result\Page
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function afterAddPageLayoutHandles(
        \Magento\Framework\View\Result\Page $subject
    ) {
        $storeId = $this->storeManager->getStore()->getId();
        if ($this->pageHelper->isEnabled($storeId) && !$this->pageHelper->isDevAllowed($storeId)) {
            $subject->addHandle('maintenance_page_mode');
        }
        return $subject;
    }
}
