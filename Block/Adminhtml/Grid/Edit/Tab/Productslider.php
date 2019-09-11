<?php

namespace Coreway\Productslider\Block\Adminhtml\Grid\Edit\Tab;
 
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;

class Productslider  extends Generic implements TabInterface
{    
    protected $_ProductSlider;

    protected $_attributeFactory;

    protected $_categoryCollectionFactory;

    protected $_categoryHelper;

    protected $_template = 'Coreway_Productslider::renderer/form/productslider.phtml';

    protected $_modelGridFactory;

    protected $collection;

    protected $storeManager;

    protected $eavConfig;
    
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Catalog\Model\ResourceModel\Eav\Attribute $attributeFactory,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        \Magento\Catalog\Helper\Category $categoryHelper,
        \Coreway\Productslider\Model\GridFactory $modelGridFactory,
        \Magento\Directory\Model\ResourceModel\Country\CollectionFactory $countryCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Eav\Model\Config $eavConfig,
        array $data = []
    ) {
        $this->_attributeFactory = $attributeFactory;
        $this->_categoryCollectionFactory = $categoryCollectionFactory;
        $this->_categoryHelper = $categoryHelper;
        $this->_countryCollectionFactory = $countryCollectionFactory;
        $this->_modelGridFactory = $modelGridFactory;
        $this->storeManager = $storeManager;
        $this->eavConfig = $eavConfig;
        parent::__construct($context, $registry, $formFactory, $data);
    }
 
    public function getTabLabel()
    {
        return __('Product Slider Block');
    }
    
    public function getTabTitle()
    {
        return __('Product Slider Block');
    }
 
    public function canShowTab()
    {
        return true;
    }
    
    public function isHidden()
    {
        return false;
    }
    
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {   
        $this->_element = $element;
        $html = $this->toHtml();
        return $html;
    }

    public function getId()
    {
        $merchent_id = $this->getRequest()->getParam('id');
        return $merchent_id;
    }

    public function getAllData($id)
    {
        $model = $this->_modelGridFactory->create()->getCollection()->addFieldToFilter('id',$id);

        foreach ($model as $data) {
            $option= [
                'coreway_product_slider_attribute_code' => $data->getData("coreway_product_slider_attribute_code"),
                'coreway_product_slider_attribute_value' => $data->getData("coreway_product_slider_attribute_value"),
                'coreway_product_slider_category_id' => $data->getData("coreway_product_slider_category_id"),
                'coreway_product_slider_number' => $data->getData("coreway_product_slider_number"),
            ];
        }  

        return $option;
    }

    public function imageResize($name, $w, $h)
    {
        $image=$name;
        $image_path = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA). $image;
        return $image_path;
    }

    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('row_data');
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('Productslider_');
        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Product Slider Block')]);
        
        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }

    public function getAttributeList()
    {
        $attributeInfo = $this->_attributeFactory->getCollection()->addFilter('is_user_defined', 1)->addFieldToFilter('frontend_input', array('in' => array('multiselect', 'select', 'boolean')));

        return $attributeInfo;
    }

    public function getAttributeValue($attrCode)
    {
        $attributedata = $this->eavConfig->getAttribute('catalog_product', $attrCode);
        $attributedatamain = $attributedata->getSource()->getAllOptions();
        return $attributedatamain;
    }

    public function getCategoryCollection($isActive = true, $level = false, $sortBy = false, $pageSize = false)
    {
        $collection = $this->_categoryCollectionFactory->create();
        $collection->addAttributeToSelect('*');        
        
        // select only active categories
        if ($isActive) {
            $collection->addIsActiveFilter();
        }
                
        // select categories of certain level
        if ($level) {
            $collection->addLevelFilter($level);
        }
        
        // sort categories by some value
        if ($sortBy) {
            $collection->addOrderField($sortBy);
        }
        
        // select certain number of categories
        if ($pageSize) {
            $collection->setPageSize($pageSize); 
        }    

        $collection->addAttributeToFilter('level', ['neq' => 1]);
        
        return $collection;
    }

}
