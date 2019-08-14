<?php
class Zero1_CustomOrderGrid_Model_Observer
{
    public function salesOrderGridCollectionLoadBefore(Varien_Event_Observer $observer)
    {
        $collection = $observer->getEvent()->getOrderGridCollection();

        $select = $collection->getSelect();

        // Add the selected columns if they are enabled
        $enabled_options = Mage::getStoreConfig('zero1_customordergrid/options/columns_to_show');
        $enabled_options = explode(',', $enabled_options);

        if(in_array('products_ordered', $enabled_options)) {
            $table_sales_flat_order_item = Mage::getSingleton('core/resource')->getTableName('sales/order_item');
            $select->joinLeft(
                $table_sales_flat_order_item,
                'main_table.entity_id = '.$table_sales_flat_order_item.'.order_id',
                array('products_ordered' => 'GROUP_CONCAT(ROUND(qty_ordered), " x ", name, " (", sku, ")" SEPARATOR "'.PHP_EOL.'")')
            );
            $select->group('main_table.entity_id');
        }

        if(in_array('customer_email', $enabled_options)) {
            $table_sales_flat_order = Mage::getSingleton('core/resource')->getTableName('sales/order');
            $select->joinLeft(
                $table_sales_flat_order,
                'main_table.entity_id = '.$table_sales_flat_order.'.entity_id',
                array('customer_email')
            );
        }
    }
}
