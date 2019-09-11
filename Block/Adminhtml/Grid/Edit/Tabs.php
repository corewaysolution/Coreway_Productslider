<?php

namespace Coreway\Productslider\Block\Adminhtml\Grid\Edit;

use Magento\Backend\Block\Widget\Tabs as WidgetTabs;

class Tabs extends WidgetTabs
{

    protected function _construct()
    {
        parent::_construct();
        $this->setId('grid_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Coreway Product Slider'));
    }

    protected function _beforeToHtml()
    {
        $rowId = (int) $this->getRequest()->getParam('id');
        
        $this->addTab(
            'store_view',
            [
                'label' => __('Store View Block'),
                'title' => __('Store View Block'),
                'content' => $this->getLayout()->createBlock(
                    'Coreway\Productslider\Block\Adminhtml\Grid\Edit\Tab\StoreView'
                )->toHtml(),
                'active' => true
            ]
        );

        $this->addTab(
            'slider_data_block',
            [
                'label' => __('Slider Data Block'),
                'title' => __('Slider Data Block'),
                'content' => $this->getLayout()->createBlock(
                'Coreway\Productslider\Block\Adminhtml\Grid\Edit\Tab\Productslider'
                )->toHtml(),
                'active' => false
            ]
        );
        return parent::_beforeToHtml();
    }
}
