<?php

namespace Xigen\MaintenancePage\Api;

/**
 * Interface MaintenanceRepositoryInterface
 */
interface MaintenanceRepositoryInterface
{

    /**
     * Save Maintenance Page
     * @param \Xigen\MaintenancePage\Api\Data\MaintenanceInterface $maintenance
     * @return \Xigen\MaintenancePage\Api\Data\MaintenanceInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Xigen\MaintenancePage\Api\Data\MaintenanceInterface $maintenance
    );

    /**
     * Retrieve Maintenance Page
     * @param string $maintenanceId
     * @return \Xigen\MaintenancePage\Api\Data\MaintenanceInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($maintenanceId);

    /**
     * Retrieve Maintenance Page matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Xigen\MaintenancePage\Api\Data\MaintenanceSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Maintenance Page
     * @param \Xigen\MaintenancePage\Api\Data\MaintenanceInterface $maintenance
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Xigen\MaintenancePage\Api\Data\MaintenanceInterface $maintenance
    );

    /**
     * Delete Maintenance Page by ID
     * @param string $maintenanceId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($maintenanceId);
}
