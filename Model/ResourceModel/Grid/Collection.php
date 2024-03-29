<?php
 
namespace Coreway\Productslider\Model\ResourceModel\Grid;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';
   
    protected function _construct()
    {
        $this->_init('Coreway\Productslider\Model\Grid', 'Coreway\Productslider\Model\ResourceModel\Grid');
    }
}
