<?php

namespace Xigen\MaintenancePage\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * InstallSchema class for MaintenancePage Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $table_xigen_maintenancepage_maintenance = $setup->getConnection()
            ->newTable($setup->getTable('xigen_maintenancepage_maintenance'));

        $table_xigen_maintenancepage_maintenance->addColumn(
            'maintenance_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true,'nullable' => false,'primary' => true,'unsigned' => true],
            'Entity ID'
        );

        $table_xigen_maintenancepage_maintenance->addColumn(
            'name',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            [],
            'Name'
        );

        $table_xigen_maintenancepage_maintenance->addColumn(
            'content',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            2048,
            [],
            'Content'
        );

        $table_xigen_maintenancepage_maintenance->addColumn(
            'css',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            2048,
            [],
            'CSS Styles'
        );

        $table_xigen_maintenancepage_maintenance->addColumn(
            'created_at',
            \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
            null,
            [],
            'Created At'
        );

        $table_xigen_maintenancepage_maintenance->addColumn(
            'updated_at',
            \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
            null,
            [],
            'Updated At'
        );

        $setup->getConnection()->createTable($table_xigen_maintenancepage_maintenance);
    }
}
