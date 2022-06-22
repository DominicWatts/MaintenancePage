<?php

namespace Xigen\MaintenancePage\Api\Data;

/**
 * Interface MaintenanceSearchResultsInterface
 */
interface MaintenanceSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Maintenance list.
     * @return \Xigen\MaintenancePage\Api\Data\MaintenanceInterface[]
     */
    public function getItems();

    /**
     * Set content list.
     * @param \Xigen\MaintenancePage\Api\Data\MaintenanceInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
