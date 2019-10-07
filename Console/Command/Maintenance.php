<?php


namespace Xigen\MaintenancePage\Console\Command;

use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Xigen\MaintenancePage\Helper\Page;

/**
 * Maintenance class
 */
class Maintenance extends Command
{
    const TOGGLE_ARGUMENT = 'toggle';
    const STORE_OPTION = 'store';

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var \Magento\Framework\App\State
     */
    protected $state;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $dateTime;

    /**
     * @var \Magento\Config\Model\ResourceModel\Config
     */
    protected $resourceConfig;
    
    /**
     * @var \Magento\Framework\Event\ManagerInterface
     */
    protected $cacheManager;

    /**
     * @var \Magento\Framework\Event\ManagerInterface
     */
    protected $eventManager;

    /**
     * Maintenance constructor.
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\App\State $state
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $dateTime
     * @param \Xigen\Faker\Helper\Product $productHelper
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\App\State $state,
        \Magento\Framework\Stdlib\DateTime\DateTime $dateTime,
        \Magento\Config\Model\ResourceModel\Config $resourceConfig,
        \Magento\Framework\App\Cache\Manager $cacheManager,
        \Magento\Framework\Event\ManagerInterface $eventManager
    ) {
        $this->logger = $logger;
        $this->state = $state;
        $this->dateTime = $dateTime;
        $this->resourceConfig = $resourceConfig;
        $this->cacheManager = $cacheManager;
        $this->eventManager = $eventManager;
        parent::__construct();
    }
    
    /**
     * {@inheritdoc}
     * xigen:maintenancepage:toggle [-s|--store STORE] [--] <toggle>
     * php bin/magento xigen:maintenancepage:toggle enable
     * php bin/magento xigen:maintenancepage:toggle disable
     * php bin/magento xigen:maintenancepage:toggle enable -s 1
     * php bin/magento xigen:maintenancepage:toggle disable -s 1
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        $this->input = $input;
        $this->output = $output;
        $this->state->setAreaCode(\Magento\Framework\App\Area::AREA_GLOBAL);

        $toggle = $input->getArgument(self::TOGGLE_ARGUMENT) ?: false;
        $storeId = $this->input->getOption(self::STORE_OPTION) ?: 0;
        $cacheTypes = ['block_html', 'full_page', 'layout', 'config'];

        if ($toggle) {
            if ($toggle == 'enable') {
                $this->output->writeln((string) (__("Enabling maintenance page %1", $storeId > 0 ? "for store ID " . $storeId : null)));
                $this->resourceConfig->saveConfig(
                    Page::XML_PATH_MAINTENANCE_ENABLED,
                    1,
                    $storeId > 0 ? 'website' : 'default',
                    $storeId
                );
                $this->eventManager->dispatch('adminhtml_cache_flush_system');
                $this->cacheManager->clean($cacheTypes);
                return Cli::RETURN_SUCCESS;
            }
            if ($toggle == 'disable') {
                $this->output->writeln((string) (__("Disabling maintenance page %1", $storeId > 0 ? "for store ID " . $storeId : null)));
                $this->resourceConfig->saveConfig(
                    Page::XML_PATH_MAINTENANCE_ENABLED,
                    0,
                    $storeId > 0 ? 'website' : 'default',
                    $storeId
                );
                $this->eventManager->dispatch('adminhtml_cache_flush_system');
                $this->cacheManager->clean($cacheTypes);
                return Cli::RETURN_SUCCESS;
            }
            return Cli::RETURN_FAILURE;
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName("xigen:maintenancepage:toggle");
        $this->setDescription("Toggle maintenance page");
        $this->setDefinition([
            new InputArgument(self::TOGGLE_ARGUMENT, InputArgument::REQUIRED, 'Toggle'),
            new InputOption(self::STORE_OPTION, '-s', InputOption::VALUE_REQUIRED, 'Store Id'),
        ]);
        parent::configure();
    }
}
