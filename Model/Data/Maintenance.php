<?php

namespace Xigen\MaintenancePage\Model\Data;

use Xigen\MaintenancePage\Api\Data\MaintenanceInterface;

/**
 * Class Maintenance
 */
class Maintenance extends \Magento\Framework\Api\AbstractExtensibleObject implements MaintenanceInterface
{
    /**
     * Get maintenance_id
     * @return string|null
     */
    public function getMaintenanceId()
    {
        return $this->_get(self::MAINTENANCE_ID);
    }

    /**
     * Set maintenance_id
     * @param string $maintenanceId
     * @return \Xigen\MaintenancePage\Api\Data\MaintenanceInterface
     */
    public function setMaintenanceId($maintenanceId)
    {
        return $this->setData(self::MAINTENANCE_ID, $maintenanceId);
    }

    /**
     * Get name
     * @return string|null
     */
    public function getName()
    {
        return $this->_get(self::NAME);
    }

    /**
     * Set name
     * @param string $name
     * @return \Xigen\MaintenancePage\Api\Data\MaintenanceInterface
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Get content
     * @return string|null
     */
    public function getContent()
    {
        return $this->_get(self::CONTENT);
    }

    /**
     * Set content
     * @param string $content
     * @return \Xigen\MaintenancePage\Api\Data\MaintenanceInterface
     */
    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Xigen\MaintenancePage\Api\Data\MaintenanceExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Xigen\MaintenancePage\Api\Data\MaintenanceExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Xigen\MaintenancePage\Api\Data\MaintenanceExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get css
     * @return string|null
     */
    public function getCss()
    {
        return $this->_get(self::CSS);
    }

    /**
     * Set css
     * @param string $css
     * @return \Xigen\MaintenancePage\Api\Data\MaintenanceInterface
     */
    public function setCss($css)
    {
        return $this->setData(self::CSS, $css);
    }

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt()
    {
        return $this->_get(self::CREATED_AT);
    }

    /**
     * Set created_at
     * @param string $createdAt
     * @return \Xigen\MaintenancePage\Api\Data\MaintenanceInterface
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Get updated_at
     * @return string|null
     */
    public function getUpdatedAt()
    {
        return $this->_get(self::UPDATED_AT);
    }

    /**
     * Set updated_at
     * @param string $updatedAt
     * @return \Xigen\MaintenancePage\Api\Data\MaintenanceInterface
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}
