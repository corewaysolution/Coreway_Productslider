<?php

namespace Coreway\Productslider\Ui\Component\Listing\Grid\Column;

class Myoptions implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [['value' => 1, 'label' => __('Active')], ['value' => 0, 'label' => __('Inactive')]];
    }
}
