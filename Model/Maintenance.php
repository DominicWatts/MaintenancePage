<?php


namespace Xigen\MaintenancePage\Model;

use Xigen\MaintenancePage\Api\Data\MaintenanceInterfaceFactory;
use Xigen\MaintenancePage\Api\Data\MaintenanceInterface;
use Magento\Framework\Api\DataObjectHelper;

/**
 * Class Maintenance
 * @package Xigen\MaintenancePage\Model
 */
class Maintenance extends \Magento\Framework\Model\AbstractModel
{
    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var MaintenanceInterfaceFactory
     */
    protected $maintenanceDataFactory;

    /**
     * @var string
     */
    protected $_eventPrefix = 'xigen_maintenancepage_maintenance';

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    private $dateTime;

    /**
     * Maintenance constructor.
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param MaintenanceInterfaceFactory $maintenanceDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param ResourceModel\Maintenance $resource
     * @param ResourceModel\Maintenance\Collection $resourceCollection
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $dateTime
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        MaintenanceInterfaceFactory $maintenanceDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Xigen\MaintenancePage\Model\ResourceModel\Maintenance $resource,
        \Xigen\MaintenancePage\Model\ResourceModel\Maintenance\Collection $resourceCollection,
        \Magento\Framework\Stdlib\DateTime\DateTime $dateTime,
        array $data = []
    ) {
        $this->maintenanceDataFactory = $maintenanceDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dateTime = $dateTime;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Before save
     */
    public function beforeSave()
    {
        $this->setUpdatedAt($this->dateTime->gmtDate());
        if ($this->isObjectNew()) {
            $this->setCreatedAt($this->dateTime->gmtDate());
        }
        return parent::beforeSave();
    }

    /**
     * Retrieve maintenance model with maintenance data
     * @return MaintenanceInterface
     */
    public function getDataModel()
    {
        $maintenanceData = $this->getData();
        
        $maintenanceDataObject = $this->maintenanceDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $maintenanceDataObject,
            $maintenanceData,
            MaintenanceInterface::class
        );
        
        return $maintenanceDataObject;
    }
}
