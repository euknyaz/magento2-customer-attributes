<?php
namespace Euknyaz\CustomerAttributes\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Magento\Customer\Model\Customer;
/**
 * @codeCoverageIgnore
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var CustomerSetupFactory
     */
    private $customerSetupFactory;
    /**
     * @var AttributeSetFactory
     */
    private $attributeSetFactory;
    /**
     * UpgradeData constructor.
     * @param CustomerSetupFactory $customerSetupFactory
     * @param AttributeSetFactory $attributeSetFactory
     */
    public function __construct(
        CustomerSetupFactory $customerSetupFactory,
        AttributeSetFactory $attributeSetFactory
    )
    {
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
    }
    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
	error_log("Euknyaz\CustomerAttributes\Setup");
        $setup->startSetup();
        
        /** @var \Magento\Customer\Setup\CustomerSetup $customerSetup */
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);
        $customerEntity = $customerSetup->getEavConfig()->getEntityType(Customer::ENTITY);
        $attributeSetId = $customerEntity->getDefaultAttributeSetId();
        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

        $attributesToAdd = [];



        /********* BEGIN: Add CHECKBOX attribute ********* */
	/*
        $attrCode = 'my_checkbox_attribute';
        $customerSetup->addAttribute(Customer::ENTITY, $attrCode, [
            'type' => 'int',
            'label' => 'My Checkbox Attribute',
            'input' => 'boolean',
            'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
            'position' => 100,
            'required' => false,
            'default' => false,
            'system' => false
        ]);
        $attributesToAdd[] = $attrCode;
	*/
        /********* END ********* */




        /********* BEGIN: Add SELECT/DROPDOWN attribute ********* */
	/*
        $attrCode = 'my_select_attribute';
        $customerSetup->addAttribute(Customer::ENTITY, $attrCode, [
            'type' => 'varchar',
            'label' => 'My Select Attribute',
            'input' => 'select',
            'source' => \Magento\Eav\Model\Entity\Attribute\Source\Table::class,
            'option' => [
                'values' => [ 'A', 'B', 'C' ]
            ],
            'position' => 101,
            'required' => false,
            'default' => false,
            'system' => false
        ]);
        $attributesToAdd[] = $attrCode;
	*/
        /********* END ********* */




        /********* BEGIN: Add TEXT attribute ********* */
	/*
        $attrCode = 'my_text_attribute';
        $customerSetup->addAttribute(Customer::ENTITY, $attrCode, [
            'type' => 'varchar',
            'label' => 'My Text Attribute',
            'input' => 'text',
            'position' => 101,
            'required' => false,
            'default' => "",
            'system' => false
        ]);
        $attributesToAdd[] = $attrCode;
	*/
        /********* END ********* */




        /********* BEGIN: Add TEXTAREA attribute ********* */
	/*
        $attrCode = 'my_textarea_attribute';
        $customerSetup->addAttribute(Customer::ENTITY, $attrCode, [
            'type' => 'text',
            'label' => 'My Textarea Attribute',
            'input' => 'textarea',
            'position' => 101,
            'required' => false,
            'default' => "",
            'system' => false
        ]);
        $attributesToAdd[] = $attrCode;
	*/
        /********* END ********* */
	error_log("Euknyaz\CustomerAttributes\Setup 1");
        $attrCode = 'avatar_url';
	$customerSetup->removeAttribute(Customer::ENTITY, $attrCode); // Probably don't need to remove every time
        $customerSetup->addAttribute(Customer::ENTITY, $attrCode, [
            'type' => 'varchar',
	    'backend'  => '',
            'frontend' => '',
            'label' => 'Avatar Url',
            'input' => 'text',
  	    'source' => '',
            'position' => 100,
            'visible' => true,
            'required' => false,
            'default' => '',
            'unique' => false,
            'note' => '',
            'system' => false
        ]);
        $attributesToAdd[] = $attrCode;

        /** Add the attributes to the attribute set and the common forms */

	error_log("Euknyaz\CustomerAttributes\Setup 2");
        $attrCode = 'avatar_image';
	$customerSetup->removeAttribute(Customer::ENTITY, $attrCode); // Probably don't need to remove every time
        $customerSetup->addAttribute(Customer::ENTITY, $attrCode, [
            'type' => 'varchar',
	    'backend'  => '',
            'frontend' => '',
            'label' => 'Avatar Image',
            'input' => 'image',
  	    'source' => '',
            'position' => 101,
            'visible' => true,
            'required' => false,
            'default' => '',
            'unique' => false,
            'note' => '',
            'system' => false
        ]);
        $attributesToAdd[] = $attrCode;

	error_log("Euknyaz\CustomerAttributes\Setup 3");
        /** Add the attributes to the attribute set and the common forms */
        foreach ($attributesToAdd as $code) {
	    error_log("Euknyaz\CustomerAttributes\Setup add ".$code);
            $attribute = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, $code);
            $attribute->setData([
                'attribute_set_id' => $attributeSetId,
                'attribute_group_id' => $attributeGroupId,
                'used_in_forms' => ['adminhtml_customer','customer_account_create','customer_account_edit'/*,'checkout_register','adminhtml_checkout'*/],
		// Additional set of properties (probably not necessary)
		'is_used_for_customer_segment' => true,
		'is_system' => 0,
		'is_user_defined' => 1,
 		'is_visible' => 1,
		'sort_order' => 100,
            ]);
            $attribute->save();
        }


        $setup->startSetup();
        error_log("Euknyaz\CustomerAttributes\Setup setupStart");
    }

}
