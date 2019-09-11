<?php

namespace Coreway\Productslider\Controller\Adminhtml\Index;

use Magento\Framework\Controller\Result\JsonFactory;
 
class Valuelist extends \Magento\Backend\App\Action
{
      	
	protected $objectManager;
	
	protected $_attributeFactory;

	protected $eavConfig;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\ObjectManagerInterface $objectManager,
		\Magento\Catalog\Model\ResourceModel\Eav\Attribute $attributeFactory,
		JsonFactory $resultJsonFactory,
		\Magento\Eav\Model\Config $eavConfig,
		array $data = []
	) {
		$this->_objectManager = $objectManager;
		$this->_attributeFactory = $attributeFactory;
		$this->resultJsonFactory = $resultJsonFactory;
		$this->eavConfig = $eavConfig;
		parent::__construct($context, $data);
	}
	
	public function execute()
	{
		$attrCode =  $this->getRequest()->getParam("attributeCode");
		$attributedata = $this->eavConfig->getAttribute('catalog_product', $attrCode);
        $attributedatamain = $attributedata->getSource()->getAllOptions();

        $drodownArray = [];
        foreach ($attributedatamain as $attribute) {
        	if ($attribute['label'] != "" && $attribute['value'] != "") {
        		$drodownArray[] = "<option value='".$attribute['value']."'>".$attribute['label']."</option>";
        	}
        }

		$Response=Array(
			'success' => "true",
			'value' => $drodownArray
		);

		$result  = $this->resultJsonFactory->create();

		return $result->setData($Response);	
	}
}
