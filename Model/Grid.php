<?php

namespace Coreway\Productslider\Model;

class Grid extends \Magento\Framework\Model\AbstractModel
{
    const CACHE_TAG = 'Productslider';

    protected $_cacheTag = 'Productslider';

    protected $_eventPrefix = 'Productslider';

    const PRODUCTSLIDER_ID = 'id';

    protected function _construct()
    {
        $this->_init('Coreway\Productslider\Model\ResourceModel\Grid');
    }

    public function getProductsliderId()
    {
        return $this->getData(self::PRODUCTSLIDER_ID);
    }

    public function setProductsliderId($ProductsliderId)
    {
        return $this->setData(self::PRODUCTSLIDER_ID, $ProductsliderId);
    }
}
