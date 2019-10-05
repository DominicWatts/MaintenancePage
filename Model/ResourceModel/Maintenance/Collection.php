<?php


namespace Xigen\MaintenancePage\Model\ResourceModel\Maintenance;

/**
 * Class Collection
 * @package Xigen\MaintenancePage\Model\ResourceModel\Maintenance
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'maintenance_id';

    /**
     * Define resource model
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Xigen\MaintenancePage\Model\Maintenance::class,
            \Xigen\MaintenancePage\Model\ResourceModel\Maintenance::class
        );
    }
}
