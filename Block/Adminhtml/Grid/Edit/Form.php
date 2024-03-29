<?php
 
namespace Coreway\Productslider\Block\Adminhtml\Grid\Edit;

use Magento\Backend\Block\Widget\Form\Generic;
 
class Form extends Generic
{

    protected function _prepareForm()
    {
    	
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id'    => 'edit_form',
                    'action' => $this->getData('action'),
					'enctype' => 'multipart/form-data', 
                    'method' => 'post'
                ],
            ]
        );

        $form->setUseContainer(true);
        $this->setForm($form);
 
        return parent::_prepareForm();
    }

}
