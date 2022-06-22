<?php

namespace Xigen\MaintenancePage\Model\ResourceModel;

/**
 * Class Maintenance for MaintenancePage Model ResourceModel
 */
class Maintenance extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Define resource model
     * @return void
     */
    protected function _construct()
    {
        $this->_init('xigen_maintenancepage_maintenance', 'maintenance_id');
    }
}
