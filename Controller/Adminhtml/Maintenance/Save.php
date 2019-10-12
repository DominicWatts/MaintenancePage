<?php


namespace Xigen\MaintenancePage\Controller\Adminhtml\Maintenance;

use Magento\Framework\Exception\LocalizedException;

/**
 * Save class
 */
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\App\Request\DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var
     */
    protected $maintenanceFactory;

    /**
     * Save constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     * @param \Xigen\MaintenancePage\Model\MaintenanceFactory $maintenanceFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Xigen\MaintenancePage\Model\MaintenanceFactory $maintenanceFactory
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->maintenanceFactory = $maintenanceFactory;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('maintenance_id');
        
            $model = $this->maintenanceFactory->create()->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Maintenance page no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
        
            $model->setData($data);
        
            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Maintenance page.'));
                $this->dataPersistor->clear('xigen_maintenancepage_maintenance');
        
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['maintenance_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Maintenance.'));
            }
        
            $this->dataPersistor->set('xigen_maintenancepage_maintenance', $data);
            return $resultRedirect->setPath('*/*/edit', ['maintenance_id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
