<?php

namespace Coreway\Productslider\Block\Adminhtml\Block\Widget;

class Chooser extends \Magento\Backend\Block\Widget\Grid\Extended
{
    protected $_productsliderFactory;
    protected $_collectionFactory;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Coreway\Productslider\Model\ProductSliderFactory $productsliderFactory,
        \Coreway\Productslider\Model\ResourceModel\Grid\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->_productsliderFactory = $productsliderFactory;
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    public function prepareElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $uniqId = $this->mathRandom->getUniqueHash($element->getId());
        $sourceUrl = $this->getUrl('corewayproductslider/widget/chooser', ['uniq_id' => $uniqId]);

        $chooser = $this->getLayout()->createBlock(
            'Magento\Widget\Block\Adminhtml\Widget\Chooser'
        )->setElement(
            $element
        )->setConfig(
            $this->getConfig()
        )->setFieldsetId(
            $this->getFieldsetId()
        )->setSourceUrl(
            $sourceUrl
        )->setUniqId(
            $uniqId
        );

        if ($element->getValue()) {
            $data = $this->_collectionFactory->create()->addFieldToFilter('id', $element->getValue());
            $mainData = $data->getData();
            $sliderTitle = $mainData[0]["coreway_product_slider_name"];
            $chooser->setLabel($this->escapeHtml($sliderTitle));
        }

        $element->setData('after_element_html', $chooser->toHtml());
        
        return $element;
    }

    public function getRowClickCallback()
    {
        $chooserJsObject = $this->getId();
        $js = '
            function (grid, event) {
                var trElement = Event.findElement(event, "tr");
                var sliderId = trElement.down("td").innerHTML.replace(/^\s+|\s+$/g,"");
                var sliderTitle = trElement.down("td").next().innerHTML;
                ' .
            $chooserJsObject .
            '.setElementValue(sliderId);
                ' .
            $chooserJsObject .
            '.setElementLabel(sliderTitle);
                ' .
            $chooserJsObject .
            '.close();
            }
        ';
        return $js;
    }

    protected function _prepareCollection()
    {
        $this->setCollection($this->_collectionFactory->create());
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'id',
            [
                'header' => __('ID'),
                'align' => 'right',
                'index' => 'id',
                'value' => \Coreway\Productslider\Model\ProductSlider::getProductsliderId()
            ]
        );

        $this->addColumn(
            'coreway_product_slider_name',
            [
                'header' => __('Name'),
                'align' => 'left',
                'index' => 'coreway_product_slider_name',
                'value' => \Coreway\Productslider\Model\ProductSlider::getProductSliderName()
            ]
        );
        
        $this->addColumn(
            'coreway_product_slider_visible_status',
            [
                'header' => __('Status'),
                'index' => 'coreway_product_slider_visible_status',
                'type' => 'options',
                'options' => \Coreway\Productslider\Model\ProductSlider::getStatusArray()
            ]
        );

        return parent::_prepareColumns();
    }
}
