<?php

namespace Coreway\Productslider\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;

class AddRow extends \Magento\Backend\App\Action
{

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry
    ) {
        parent::__construct($context);
        $this->_coreRegistry = $coreRegistry;
    }

    public function execute()
    {
        $rowId = (int) $this->getRequest()->getParam('id');
        $rowData = $this->_objectManager->create('Coreway\Productslider\Model\Grid');
        if ($rowId) {
            $rowData = $rowData->load($rowId);
            $rowTitle = " ".$rowData->getTitle();

            if (!$rowData->getProductsliderId()) {
                $this->messageManager->addError(__('row data no longer exist.'));
                $this->_redirect('corewayproductslider/index/index');
                return;
            }
        }

        $this->_coreRegistry->register('row_data', $rowData);
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $title = $rowId ? __('Edit Data').$rowTitle : __('Add Data');
        $resultPage->getConfig()->getTitle()->prepend($title);

        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Coreway_Productslider::add_row');
    }
}
