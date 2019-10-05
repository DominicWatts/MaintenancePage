<?php


namespace Xigen\MaintenancePage\Api\Data;

/**
 * Interface MaintenanceInterface
 * @package Xigen\MaintenancePage\Api\Data
 */
interface MaintenanceInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    const CONTENT = 'content';
    const CSS = 'css';
    const NAME = 'name';
    const CREATED_AT = 'created_at';
    const MAINTENANCE_ID = 'maintenance_id';
    const UPDATED_AT = 'updated_at';

    /**
     * Get maintenance_id
     * @return string|null
     */
    public function getMaintenanceId();

    /**
     * Set maintenance_id
     * @param string $maintenanceId
     * @return \Xigen\MaintenancePage\Api\Data\MaintenanceInterface
     */
    public function setMaintenanceId($maintenanceId);

    /**
     * Get name
     * @return string|null
     */
    public function getName();

    /**
     * Set name
     * @param string $name
     * @return \Xigen\MaintenancePage\Api\Data\MaintenanceInterface
     */
    public function setName($name);

    /**
     * Get content
     * @return string|null
     */
    public function getContent();

    /**
     * Set content
     * @param string $content
     * @return \Xigen\MaintenancePage\Api\Data\MaintenanceInterface
     */
    public function setContent($content);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Xigen\MaintenancePage\Api\Data\MaintenanceExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Xigen\MaintenancePage\Api\Data\MaintenanceExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Xigen\MaintenancePage\Api\Data\MaintenanceExtensionInterface $extensionAttributes
    );

    /**
     * Get css
     * @return string|null
     */
    public function getCss();

    /**
     * Set css
     * @param string $css
     * @return \Xigen\MaintenancePage\Api\Data\MaintenanceInterface
     */
    public function setCss($css);

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created_at
     * @param string $createdAt
     * @return \Xigen\MaintenancePage\Api\Data\MaintenanceInterface
     */
    public function setCreatedAt($createdAt);

    /**
     * Get updated_at
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * Set updated_at
     * @param string $updatedAt
     * @return \Xigen\MaintenancePage\Api\Data\MaintenanceInterface
     */
    public function setUpdatedAt($updatedAt);
}
