<?php

namespace Xigen\MaintenancePage\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;
use Xigen\MaintenancePage\Api\Data\MaintenanceInterfaceFactory;
use Xigen\MaintenancePage\Api\Data\MaintenanceSearchResultsInterfaceFactory;
use Xigen\MaintenancePage\Api\MaintenanceRepositoryInterface;
use Xigen\MaintenancePage\Model\ResourceModel\Maintenance as ResourceMaintenance;
use Xigen\MaintenancePage\Model\ResourceModel\Maintenance\CollectionFactory as MaintenanceCollectionFactory;

/**
 * Class MaintenanceRepository
 */
class MaintenanceRepository implements MaintenanceRepositoryInterface
{
    /**
     * @var MaintenanceFactory
     */
    protected $maintenanceFactory;

    /**
     * @var MaintenanceCollectionFactory
     */
    protected $maintenanceCollectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var ExtensibleDataObjectConverter
     */
    protected $extensibleDataObjectConverter;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var JoinProcessorInterface
     */
    protected $extensionAttributesJoinProcessor;

    /**
     * @var MaintenanceInterfaceFactory
     */
    protected $dataMaintenanceFactory;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var ResourceMaintenance
     */
    protected $resource;

    /**
     * @var MaintenanceSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @param ResourceMaintenance $resource
     * @param MaintenanceFactory $maintenanceFactory
     * @param MaintenanceInterfaceFactory $dataMaintenanceFactory
     * @param MaintenanceCollectionFactory $maintenanceCollectionFactory
     * @param MaintenanceSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceMaintenance $resource,
        MaintenanceFactory $maintenanceFactory,
        MaintenanceInterfaceFactory $dataMaintenanceFactory,
        MaintenanceCollectionFactory $maintenanceCollectionFactory,
        MaintenanceSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->maintenanceFactory = $maintenanceFactory;
        $this->maintenanceCollectionFactory = $maintenanceCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataMaintenanceFactory = $dataMaintenanceFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \Xigen\MaintenancePage\Api\Data\MaintenanceInterface $maintenance
    ) {
        /* if (empty($maintenance->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $maintenance->setStoreId($storeId);
        } */

        $maintenanceData = $this->extensibleDataObjectConverter->toNestedArray(
            $maintenance,
            [],
            \Xigen\MaintenancePage\Api\Data\MaintenanceInterface::class
        );

        $maintenanceModel = $this->maintenanceFactory->create()->setData($maintenanceData);

        try {
            $this->resource->save($maintenanceModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the maintenance: %1',
                $exception->getMessage()
            ));
        }
        return $maintenanceModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getById($maintenanceId)
    {
        $maintenance = $this->maintenanceFactory->create();
        $this->resource->load($maintenance, $maintenanceId);
        if (!$maintenance->getId()) {
            throw new NoSuchEntityException(__('Maintenance with id "%1" does not exist.', $maintenanceId));
        }
        return $maintenance->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->maintenanceCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Xigen\MaintenancePage\Api\Data\MaintenanceInterface::class
        );

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \Xigen\MaintenancePage\Api\Data\MaintenanceInterface $maintenance
    ) {
        try {
            $maintenanceModel = $this->maintenanceFactory->create();
            $this->resource->load($maintenanceModel, $maintenance->getMaintenanceId());
            $this->resource->delete($maintenanceModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Maintenance Page: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($maintenanceId)
    {
        return $this->delete($this->getById($maintenanceId));
    }
}
