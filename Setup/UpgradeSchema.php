<?php
namespace Vanguarda\RdStation\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface {

	public function upgrade( SchemaSetupInterface $setup, ModuleContextInterface $context ) {
        
        $installer = $setup;
		$installer->startSetup();

		if(version_compare($context->getVersion(), '1.1.0', '<')) {
			if (!$installer->tableExists('vangi_rdstation')) {
				$table = $installer->getConnection()->newTable(
					$installer->getTable('vangi_rdstation')
				)
				->addColumn( 'vangi_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null,
                    [ 'identity' => true, 'nullable' => false, 'primary'  => true, 'unsigned' => true, ], 'Vangi ID')
                ->addColumn( 'token', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, ['nullable => false'], 'Token')
                ->addColumn('monitor', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, [], 'Monitor')
                ->addColumn('created_at', \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP, null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT], 'Created At' )
                ->addColumn('updated_at', \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP, null, 
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE], 'Updated At')
				->setComment('Post Table');
				$installer->getConnection()->createTable($table);

				$installer->getConnection()->addIndex(
					$installer->getTable('vangi_rdstation'),
					$setup->getIdxName(
						$installer->getTable('vangi_rdstation'), ['token','monitor'], \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
					),
					['token','monitor'], \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
				);
			}
		}

		$installer->endSetup();
	}
}
?>