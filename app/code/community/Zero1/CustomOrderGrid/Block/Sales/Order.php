<?php
class Zero1_CustomOrderGrid_Block_Sales_Order extends Mage_Adminhtml_Block_Sales_Order
{
    public function __construct()
    {
        parent::__construct();

        $this->_blockGroup = 'zero1_customordergrid';
    }
}
