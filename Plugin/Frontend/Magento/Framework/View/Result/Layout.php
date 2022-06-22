<?php

namespace Xigen\MaintenancePage\Plugin\Frontend\Magento\Framework\View\Result;

/**
 * Class Layout for MaintenancePage Plugin
 */
class Layout
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
     * @param \Magento\Framework\View\Result\Layout $subject
     * @return \Magento\Framework\View\Result\Layout
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function afterAddDefaultHandle(
        \Magento\Framework\View\Result\Layout $subject
    ) {
        $storeId = $this->storeManager->getStore()->getId();
        if ($this->pageHelper->isEnabled($storeId) && !$this->pageHelper->isDevAllowed($storeId)) {
            $subject->addHandle('maintenance_page_mode');
        }
        return $subject;
    }
}
