<?php 
namespace Vanguarda\RdStation\Setup;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface{

    public function install(SchemaSetupInterface $setup,ModuleContextInterface $context){
        $installer = $setup;
        $installer->startSetup();
		if (!$installer->tableExists('vangi_rdstation')) {
			$table = $installer->getConnection()->newTable( $installer->getTable('vangi_rdstation'))
			->addColumn('vangi_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null,
				[ 'identity' => true, 'nullable' => false, 'primary'  => true, 'unsigned' => true ], 'Vangi ID')
			->addColumn('token', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, ['nullable => false'], 'Token')
			->addColumn( 'monitor', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, [], 'Monitor')
			->addColumn( 'status', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, ['nullable' => false, 'unsigned' => true], 'Status')
			->addColumn('created_at', \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP, null,
				['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT], 'Created At')
            ->addColumn('updated_at', \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP, null,
				['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE], 'Updated At')
			->setComment('rdStation Table');
			$installer->getConnection()->createTable($table);

			$installer->getConnection()->addIndex(
				$installer->getTable('vangi_rdstation'),
				$setup->getIdxName(
					$installer->getTable('vangi_rdstation'), ['token','monitor'],
					\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
				),
				['token','monitor'],
				\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
			);
		}
		$installer->endSetup();
    }
}
 ?>