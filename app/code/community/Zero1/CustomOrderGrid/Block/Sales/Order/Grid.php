<?php
class Zero1_CustomOrderGrid_Block_Sales_Order_Grid extends Mage_Adminhtml_Block_Sales_Order_Grid
{
    protected function _prepareColumns()
    {
        // Draw the default columns
        parent::_prepareColumns();

        // Add the selected columns if they are enabled
        $enabled_options = Mage::getStoreConfig('zero1_customordergrid/options/columns_to_show');
        $enabled_options = explode(',', $enabled_options);

        if(in_array('products_ordered', $enabled_options)) {
            $this->addColumnAfter('products_ordered', array(
                'header' => Mage::helper('sales')->__('Products Ordered'),
                'index' => 'products_ordered',
                'renderer'  => 'zero1_customordergrid/sales_order_grid_renderer_product',
                'type' => 'textarea',
                'width' => '500px',
            ), 'status');
        }

        if(in_array('customer_email', $enabled_options)) {
            $this->addColumnAfter('customer_email', array(
                'header' => Mage::helper('sales')->__('Customer Email'),
                'index' => 'customer_email',
                'type' => 'textarea',
            ), 'status');
        }

        $this->sortColumnsByOrder();

        return $this;
    }
}
