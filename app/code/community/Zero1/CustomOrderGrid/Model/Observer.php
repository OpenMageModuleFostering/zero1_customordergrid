<?php
class Zero1_CustomOrderGrid_Model_Observer
{
	public function zero1CustomOrderGridAddColumns(Varien_Event_Observer $observer){
		/* @var $grid Zero1_CustomOrderGrid_Block_Sales_Order_Grid */
		$grid = $observer->getEvent()->getGrid();

		// Add the selected columns if they are enabled
		$enabled_options = Mage::getStoreConfig('zero1_customordergrid/options/columns_to_show');
		$enabled_options = explode(',', $enabled_options);

		if(in_array('products_ordered', $enabled_options)) {
			$grid->addColumnAfter('products_ordered', array(
				'header' => Mage::helper('sales')->__('Products Ordered'),
				'index' => 'products_ordered',
				'renderer'  => 'zero1_customordergrid/sales_order_grid_renderer_product',
				'type' => 'textarea',
				'width' => '500px',
			), 'status');
		}

		if(in_array('customer_email', $enabled_options)) {
			$grid->addColumnAfter('customer_email', array(
				'header' => Mage::helper('sales')->__('Customer Email'),
				'index' => 'customer_email',
				'type' => 'textarea',
			), 'status');
		}
	}

	public function zero1CustomOrderGridPrepareCollection(Varien_Event_Observer $observer){
		/* @var $collection Mage_Sales_Model_Resource_Order_Grid_Collection */
		$collection = $observer->getEvent()->getCollection();
		$select = $collection->getSelect();

		// Add the selected columns if they are enabled
		$enabled_options = Mage::getStoreConfig('zero1_customordergrid/options/columns_to_show');
		$enabled_options = explode(',', $enabled_options);

		if(in_array('products_ordered', $enabled_options)) {
			$table_sales_flat_order_item = Mage::getSingleton('core/resource')->getTableName('sales/order_item');
			$collection->addFilterToMap('products_ordered', $table_sales_flat_order_item.'.products_ordered');
			$select->joinLeft(
				$table_sales_flat_order_item,
				'main_table.entity_id = '.$table_sales_flat_order_item.'.order_id',
				array('products_ordered' => 'GROUP_CONCAT(ROUND(qty_ordered), " x ", name, " (", sku, ")" SEPARATOR "'.PHP_EOL.'")')
			);
			$select->group('main_table.entity_id');
		}

		if(in_array('customer_email', $enabled_options)) {
			$table_sales_flat_order = Mage::getSingleton('core/resource')->getTableName('sales/order');
			$collection->addFilterToMap('customer_email', $table_sales_flat_order.'.customer_email');

			$select->joinLeft(
				$table_sales_flat_order,
				'main_table.entity_id = '.$table_sales_flat_order.'.entity_id',
				array('customer_email AS customer_email')
			);
		}
	}
}
