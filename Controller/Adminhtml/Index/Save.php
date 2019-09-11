<?php

namespace Coreway\Productslider\Controller\Adminhtml\Index;

use Magento\Framework\App\Filesystem\DirectoryList;

class Save extends \Magento\Backend\App\Action
{
    public function execute()
    {
        if ($this->getRequest()->getPostValue()) {
            try {
                
                $model = $this->_objectManager->create('Coreway\Productslider\Model\Grid');
                $data = $this->getRequest()->getPostValue();
                $inputFilter = new \Zend_Filter_Input(
                    [],
                    [],
                    $data
                );
                $data = $inputFilter->getUnescaped();
                
                $id = $this->getRequest()->getParam('id');
                
                if ($id) {
                    $model->load($id);
                    if ($id != $model->getId()) {
                        throw new \Magento\Framework\Exception\LocalizedException(__('The wrong item is specified.'));
                    }
                }

                $dataInsert['coreway_product_slider_name']= $this->getRequest()
                ->getParam('coreway_product_slider_name');
                $dataInsert['coreway_product_slider_attribute_code']= $this->getRequest()
                ->getParam('coreway_product_slider_attribute_code');
                $dataInsert['coreway_product_slider_attribute_value']= $this->getRequest()
                ->getParam('coreway_product_slider_attribute_value');
                $dataInsert['coreway_product_slider_category_id']= $this->getRequest()
                ->getParam('coreway_product_slider_category_id');
                $dataInsert['coreway_product_slider_number']= $this->getRequest()
                ->getParam('coreway_product_slider_number');
                $dataInsert['coreway_product_slider_visible_status'] = $this->getRequest()
                ->getParam('coreway_product_slider_visible_status');

                $storeview_id =$this->getRequest()->getParam('store_view');
                $dataInsert['store_view'] = $storeview_id;
                $dataInsert['id'] = $this->getRequest()->getParam('id');
                
                $model->setData($dataInsert);
                $session = $this->_objectManager->get('Magento\Backend\Model\Session');
                $session->setPageData($model->getData());
                $model->save();

                $this->messageManager->addSuccess(__('You saved the item.'));
                $session->setPageData(false);
                
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('coreway_productslider/*/edit', ['id' => $model->getId()]);
                    return;
                }

                $this->_redirect('corewayproductslider/index/index');
                return;
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
                $id = (int)$this->getRequest()->getParam('id');
                if (!empty($id)) {
                    $this->_redirect('coreway_productslider/*/edit', ['id' => $id]);
                } else {
                    $this->_redirect('coreway_productslider/*/new');
                }
                return;
            } catch (\Exception $e) {
                $this->messageManager->addError(
                    __('Something went wrong while saving the item data. Please review the error log.')
                );
                $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
                $this->_objectManager->get('Magento\Backend\Model\Session')->setPageData($data);
                $this->_redirect('coreway_productslider/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        $this->_redirect('coreway_productslider/*/');
    }
}
