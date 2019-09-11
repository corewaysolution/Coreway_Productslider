<?php

namespace Coreway\Productslider\Block\Adminhtml\Grid\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;

class StoreView  extends Generic implements TabInterface
{

    protected $_storeView;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Store\Model\System\Store $store_view,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        array $data = []
    ) {
        $this->_storeView = $store_view;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    public function getTabLabel()
    {
        return __('Store View Block');
    }

    public function getTabTitle()
    {
        return __('Store View Block');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }

    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('row_data');

        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('Productslider_');

        if ($model->getProductsliderId()) {
            $fieldset = $form->addFieldset('base_fieldset',['Productslider' => __('Edit genral Information'), 'class' => 'fieldset-wide1']);
            $fieldset->addField('id', 'hidden', ['name' => 'id']);
        } else {
            $fieldset = $form->addFieldset('base_fieldset',['Productslider' => __('Add genral Information'), 'class' => 'fieldset-wide2']);
        }

        $fieldset->addField(
            'coreway_product_slider_name',
            'text',
            [
                'name' => 'coreway_product_slider_name',
                'label' => __('Slider Title'),
                'id' => 'coreway_product_slider_name',
                'title' => __('Slider Title'),
            ]
        );

        $fieldset->addField(
            'store_view',
            'select',
            [
                'name'     => 'store_view',
                'label'    => __('Store View Block'),
                'title'    => __('Store View Block'),
                'required' => true,
                'values'   => $this->_storeView->getStoreValuesForForm(false, true),
            ]
        );

        $fieldset->addField(
            'coreway_product_slider_visible_status',
            'select',
            [
                'label' => __('Status'),
                'title' => __(' Status'),
                'name' => 'coreway_product_slider_visible_status',
                'required' => true,
                'values' => [
                    '1' => [
                        'value'=> [['value'=>'0' , 'label' => 'Inactive'] , ['value'=>'1' , 'label' =>'Active']],
                        'label' => ''
                    ],
                ],
            ]           
        );
        
        $form->setValues($model->getData());

        $this->setForm($form);
        return parent::_prepareForm();
    }
    
}
