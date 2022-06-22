<?php

namespace Xigen\MaintenancePage\Controller\Adminhtml\Maintenance;

/**
 * Class Delete Maintenance Page controller
 */
class Delete extends \Xigen\MaintenancePage\Controller\Adminhtml\Maintenance
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    private $resultPageFactory;

    /**
     * @var \Xigen\MaintenancePage\Model\MaintenanceFactory
     */
    private $maintenanceFactory;

    /**
     * Delete constructor.
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
     * Delete action
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('maintenance_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->maintenanceFactory->create();
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Maintenance page.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['maintenance_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Maintenance page to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
