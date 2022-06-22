<?php

namespace Xigen\MaintenancePage\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Class Page for MaintenancePage Helper
 */
class Page extends AbstractHelper
{
    const XML_PATH_MAINTENANCE_ENABLED = 'dev/maintenancepage/enabled';
    const XML_PATH_MAINTENANCE_ALLOW_IPS = 'dev/maintenancepage/allow_ips';
    const XML_PATH_MAINTENANCE_PAGE = 'dev/maintenancepage/page';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress
     */
    protected $remoteAddress;

    /**
     * @var \Magento\Framework\HTTP\Header
     */
    protected $httpHeader;

    /**
     * @var \Psr\Log\LoggerInterfaces
     */
    protected $logger;

    /**
     * @var \Xigen\MaintenancePage\Api\MaintenanceRepositoryInterface
     */
    protected $maintenanceRepositoryInterface;

    /**
     * Page constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress $remoteAddress
     * @param \Magento\Framework\HTTP\Header $httpHeader
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Xigen\MaintenancePage\Api\MaintenanceRepositoryInterface $maintenanceRepositoryInterface
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress $remoteAddress,
        \Magento\Framework\HTTP\Header $httpHeader,
        \Psr\Log\LoggerInterface $logger,
        \Xigen\MaintenancePage\Api\MaintenanceRepositoryInterface $maintenanceRepositoryInterface
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->remoteAddress = $remoteAddress;
        $this->httpHeader = $httpHeader;
        $this->maintenanceRepositoryInterface = $maintenanceRepositoryInterface;
        parent::__construct($context);
    }

    /**
     * Maintenance page
     * @param null $storeId
     * @return mixed
     */
    public function isEnabled($storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_MAINTENANCE_ENABLED,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Check if the client remote address is allowed developer ip
     * @param string|null $storeId
     * @return bool
     */
    public function isDevAllowed($storeId = null)
    {
        $allow = true;

        $allowedIps = $this->scopeConfig->getValue(
            self::XML_PATH_MAINTENANCE_ALLOW_IPS,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeId
        );
        $remoteAddr = $this->remoteAddress->getRemoteAddress();
        if (!empty($allowedIps) && !empty($remoteAddr)) {
            $allowedIps = preg_split('#\s*,\s*#', $allowedIps, null, PREG_SPLIT_NO_EMPTY);
            if (array_search($remoteAddr, $allowedIps) === false
                && array_search($this->httpHeader->getHttpHost(), $allowedIps) === false
            ) {
                $allow = false;
            }
        } else {
            $allow = false;
        }

        return $allow;
    }

    /**
     * Get mainteance configured page
     * @param null $storeId
     * @return bool|\Xigen\MaintenancePage\Api\Data\MaintenanceInterface
     */
    public function getMaintenacePage($storeId = null)
    {
        $maintenancePageId = $this->scopeConfig->getValue(
            self::XML_PATH_MAINTENANCE_PAGE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeId
        );

        try {
            return $this->maintenanceRepositoryInterface->getById($maintenancePageId);
        } catch (\Exception $e) {
            $this->logger->critical($e);
        }
        return false;
    }
}
