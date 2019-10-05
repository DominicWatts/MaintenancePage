<?php


namespace Xigen\MaintenancePage\Controller\Adminhtml\Maintenance;

/**
 * Class InlineEdit
 * @package Xigen\MaintenancePage\Controller\Adminhtml\Maintenance
 */
class InlineEdit extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;

    /**
     * @var \Xigen\MaintenancePage\Model\MaintenanceFactory
     */
    protected $maintenanceFactory;

    /**
     * InlineEdit constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     * @param \Xigen\MaintenancePage\Model\MaintenanceFactory $maintenanceFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Xigen\MaintenancePage\Model\MaintenanceFactory $maintenanceFactory
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->maintenanceFactory = $maintenanceFactory;
    }

    /**
     * Inline edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];
        
        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $modelId) {
                    /** @var \Xigen\MaintenancePage\Model\Maintenance $model */
                    $model = $$this->maintenanceFactory->create()->load($modelId);
                    try {
                        $model->setData($postItems[$modelId] + $model->getData());
                        $model->save();
                    } catch (\Exception $e) {
                        $messages[] = "[Maintenance Page ID: {$modelId}]  {$e->getMessage()}";
                        $error = true;
                    }
                }
            }
        }
        
        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}
