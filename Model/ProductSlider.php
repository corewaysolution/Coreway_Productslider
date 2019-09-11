<?php

namespace Coreway\Productslider\Model;

class ProductSlider extends \Magento\Framework\Model\AbstractModel
{    
    const STATUS_ENABLED = 1;

    const STATUS_DISABLED = 0;

    const PRODUCTSLIDER_ID = 'id';

    const PRODUCTSLIDER_NAME = 'coreway_product_slider_name';

    protected function _construct()
    {
        $this->_init('Coreway\Productslider\Model\ResourceModel\Grid');
    }

    protected static $statusOptions = [
        self::STATUS_ENABLED => 'Enabled',
        self::STATUS_DISABLED => 'Disabled',
    ];

    public static function getStatusArray()
    {
        return self::$statusOptions;
    }


    public static function getProductsliderId()
    {
        return self::PRODUCTSLIDER_ID;
    }

    public static function getProductSliderName()
    {
        return self::PRODUCTSLIDER_NAME;
    }    
}
