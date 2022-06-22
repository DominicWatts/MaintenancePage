<?php

namespace Xigen\MaintenancePage\Model\ResourceModel;

/**
 * Class Maintenance
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
