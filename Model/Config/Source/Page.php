<?php


namespace Xigen\MaintenancePage\Model\Config\Source;

/**
 * Class Page
 * @package Xigen\MaintenancePage\Model\Config\Source
 */
class Page implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var \Xigen\MaintenancePage\Model\ResourceModel\Maintenance\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * Page constructor.
     * @param \Xigen\MaintenancePage\Model\ResourceModel\Maintenance\CollectionFactory $collectionFactory
     */
    public function __construct(
        \Xigen\MaintenancePage\Model\ResourceModel\Maintenance\CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $collection = $this->collectionFactory->create();
        $optionArray = [];
        foreach ($collection as $item) {
            $optionArray[] = [
                'value' => $item->getMaintenanceId(),
                'label' => $item->getName()
            ];
        }
        return $optionArray;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $collection = $this->collectionFactory->create();
        $array = [];
        foreach ($collection as $item) {
            $array[] = [$item->getName() => $item->getName()];
        }
        return $array;
    }
}
