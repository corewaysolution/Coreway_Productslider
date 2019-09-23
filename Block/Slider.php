<?php

namespace Coreway\Productslider\Block;

use Coreway\Productslider\Model\ProductSlider;

class Slider extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{

    const XML_PATH_PRODUCT_SLIDER_STATUS = "corewayproductslider/general/enable_productslider";

    const XML_PATH_PRODUCT_SLIDER_IMAGE = "corewayproductslider/product_attribute_settings/display_image";

    const XML_PATH_PRODUCT_SLIDER_TITLE = "corewayproductslider/product_attribute_settings/display_title";

    const XML_PATH_PRODUCT_SLIDER_PRICE = "corewayproductslider/product_attribute_settings/display_price";

    const XML_PATH_PRODUCT_SLIDER_REVIEW = "corewayproductslider/product_attribute_settings/display_review";

    const XML_PATH_PRODUCT_SLIDER_CART = "corewayproductslider/product_attribute_settings/display_cart";

    const XML_PATH_PRODUCT_SLIDER_WISHLIST = "corewayproductslider/product_attribute_settings/display_wishlist";

    const XML_PATH_PRODUCT_SLIDER_COMPARE = "corewayproductslider/product_attribute_settings/display_compare";

    const XML_PATH_PRODUCT_SLIDER_NAVIGATION = "corewayproductslider/slider_settings/navigation";

    const XML_PATH_PRODUCT_SLIDER_INFINITE = "corewayproductslider/slider_settings/infinite";

    const XML_PATH_PRODUCT_SLIDER_AUTOPLAY = "corewayproductslider/slider_settings/autoplay";

    const XML_PATH_PRODUCT_SLIDER_AUTOPLAY_SPEED = "corewayproductslider/slider_settings/autoplay_speed";

    protected $swatchesVld = false;

    protected $ajaxcartVld = false;

    protected $_template = 'Coreway_Productslider::slider.phtml';

    protected $_sliderCollectionFactory;
    
    protected $_scopeConfig;
    
    protected $_layoutConfig;
    
    protected $_coreRegistry;

    protected $_storeManager;

    protected $_productCollectionFactory;

    protected $_categoryFactory;

    protected $_abstarctProduct;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Coreway\Productslider\Model\ResourceModel\Grid\CollectionFactory $sliderCollectionFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Catalog\Block\Product\ListProduct $abstarctProduct,
        array $data = []
    ) {
        $this->_sliderCollectionFactory = $sliderCollectionFactory;
        $this->_scopeConfig = $context->getScopeConfig();
        $this->_layoutConfig = $context->getLayout();
        $this->_coreRegistry = $registry;
        $this->_storeManager = $storeManager;
        $this->_categoryFactory = $categoryFactory;
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_abstarctProduct = $abstarctProduct;
        parent::__construct($context, $data);
    }

    protected function _toHtml()
    {
        if ($this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_STATUS, \Magento\Store\Model\ScopeInterface::SCOPE_STORES)) {
            return parent::_toHtml();
        }
        return false;
    }

    public function getWidgetSliderData($sliderId)
    {
        $data = $this->_sliderCollectionFactory->create()->addFieldToFilter('id', $sliderId)->addFieldToFilter('coreway_product_slider_visible_status', 1)->addFieldToFilter('store_view', ['in' => ['0', $this->getStoreId()]])->getLastItem();
        $mainData = $data->getData();
        return $mainData;
    }
    
    public function getStoreId()
    {
        return $this->_storeManager->getStore()->getId();
    }

    public function getSliderProductData($attrCode=false, $attrValue=false, $categoryId=false, $productNumber=false)
    {
        $category = $this->_categoryFactory->create()->load($categoryId);
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addCategoryFilter($category);
        $collection->addAttributeToFilter('visibility', \Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH);
        $collection->addAttributeToFilter('status', \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED);
        $collection->addAttributeToFilter($attrCode, ['like' => '%' .$attrValue. '%']);
        $collection->setPageSize($productNumber);
        return $collection;
    }

    public function getProductPrice($product)
    {
        $priceRender = $this->getLayout()->getBlock('product.price.render.default')->setData('is_product_list', true);

        $price = '';
        if ($priceRender) {
            $price = $priceRender->render(
                \Magento\Catalog\Pricing\Price\FinalPrice::PRICE_CODE,
                $product,
                [
                    'include_container' => true,
                    'display_minimal_price' => true,
                    'zone' => \Magento\Framework\Pricing\Render::ZONE_ITEM_LIST,
                    'list_category_page' => true
                ]
            );
        }

        return $price;
    }

    public function getReviewsSummaryHtml($prdoductLoop, $templateType = false, $displayIfNoReviews = false)
    {
        return $this->_abstarctProduct->getReviewsSummaryHtml($prdoductLoop, $templateType = false, $displayIfNoReviews = false);
    }

    public function getProductConfigurationStatus()
    {
        $productConfiguration["product_image"] = $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_IMAGE, \Magento\Store\Model\ScopeInterface::SCOPE_STORES);
        $productConfiguration["product_name"] = $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_TITLE, \Magento\Store\Model\ScopeInterface::SCOPE_STORES);
        $productConfiguration["product_price"] = $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_PRICE, \Magento\Store\Model\ScopeInterface::SCOPE_STORES);
        $productConfiguration["product_review"] = $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_REVIEW, \Magento\Store\Model\ScopeInterface::SCOPE_STORES);
        $productConfiguration["product_cart"] = $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_CART, \Magento\Store\Model\ScopeInterface::SCOPE_STORES);
        $productConfiguration["product_wishlist"] = $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_WISHLIST, \Magento\Store\Model\ScopeInterface::SCOPE_STORES);
        $productConfiguration["product_compare"] = $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_COMPARE, \Magento\Store\Model\ScopeInterface::SCOPE_STORES);

        return $productConfiguration;
    }

    public function getProductSliderConfigurationStatus()
    {
        $navigation = $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_NAVIGATION, \Magento\Store\Model\ScopeInterface::SCOPE_STORES);
        $infinite = $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_INFINITE, \Magento\Store\Model\ScopeInterface::SCOPE_STORES);
        $autoplay = $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_AUTOPLAY, \Magento\Store\Model\ScopeInterface::SCOPE_STORES);
        $speed = $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_AUTOPLAY_SPEED, \Magento\Store\Model\ScopeInterface::SCOPE_STORES);

        $sliderConfiguration["navigation"] = "false";
        $sliderConfiguration["infinite"] = "false";
        $sliderConfiguration["autoplay"] = "false";
        $sliderConfiguration["speed"] = "1000";

        if (isset($navigation) && $navigation == 1) {
            $sliderConfiguration["navigation"] = "true";
        }

        if (isset($infinite) && $infinite == 1) {
            $sliderConfiguration["infinite"] = "true";
        }

        if (isset($autoplay) && $autoplay == 1) {
            $sliderConfiguration["autoplay"] = "true";
        }

        if (isset($speed) && $speed != "") {
            $sliderConfiguration["speed"] = $speed;
        }

        return $sliderConfiguration;
    }

}
