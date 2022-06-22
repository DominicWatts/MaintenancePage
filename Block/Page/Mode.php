<?php

namespace Xigen\MaintenancePage\Block\Page;

/**
 * Class Mode
 */
class Mode extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Xigen\MaintenancePage\Helper\Page
     */
    protected $pageHelper;

    /**
     * Mode constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Xigen\MaintenancePage\Helper\Page $pageHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Xigen\MaintenancePage\Helper\Page $pageHelper,
        array $data = []
    ) {
        $this->pageHelper = $pageHelper;
        parent::__construct($context, $data);
    }

    public function getMaintenacePage()
    {
        return $this->pageHelper->getMaintenacePage();
    }
}
