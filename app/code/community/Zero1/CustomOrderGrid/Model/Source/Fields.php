<?php
class Zero1_CustomOrderGrid_Model_Source_Fields
{
    /**
     * Retrieve options array
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = array();

        $options[] = array(
            'label' => 'Products Ordered',
            'value' => 'products_ordered',
        );

        $options[] = array(
            'label' => 'Customer Email',
            'value' => 'customer_email',
        );

        return $options;
    }
}
