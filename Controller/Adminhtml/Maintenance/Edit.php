<?php

namespace Xigen\MaintenancePage\Controller\Adminhtml\Maintenance;

/**
 * Class Edit Maintenance Page controller
 */
class Edit extends \Xigen\MaintenancePage\Controller\Adminhtml\Maintenance
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Xigen\MaintenancePage\Model\MaintenanceFactory
     */
    protected $maintenanceFactory;

    /**
     * Edit constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Xigen\MaintenancePage\Model\MaintenanceFactory $maintenanceFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Xigen\MaintenancePage\Model\MaintenanceFactory $maintenanceFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->maintenanceFactory = $maintenanceFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('maintenance_id');
        $model = $this->maintenanceFactory->create();

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Maintenance no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->_coreRegistry->register('xigen_maintenancepage_maintenance', $model);

        // 3. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Maintenance Page') : __('New Maintenance Page'),
            $id ? __('Edit Maintenance Page') : __('New Maintenance Page')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Maintenance Pages'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? __('Edit Maintenance Page %1', $model->getId()) : __('New Maintenance Page'));
        return $resultPage;
    }
}
