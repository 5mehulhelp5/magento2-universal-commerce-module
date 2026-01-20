<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;
use Magento\Framework\View\Element\BlockInterface;

/**
 * Session Links Configuration Field
 */
class SessionLinks extends AbstractFieldArray
{
    /**
     * @var null|BlockInterface
     */
    private ?BlockInterface $typeRenderer = null;

    /**
     * Prepare rendering the new field by adding all the needed columns
     *
     * @return void
     */
    protected function _prepareToRender(): void
    {
        $this->addColumn('type', [
            'label' => __('Type'),
            'class' => 'required-entry',
            'renderer' => $this->getTypeRenderer()
        ]);
        $this->addColumn('url', [
            'label' => __('URL'),
            'class' => 'required-entry'
        ]);
        $this->addColumn('title', [
            'label' => __('Title (Optional)'),
            'class' => ''
        ]);
        $this->_addAfter = false;
        $this->_addButtonLabel = (string)__('Add Link');
    }

    /**
     * Prepare existing row data object
     *
     * @param DataObject $row
     * @return void
     */
    protected function _prepareArrayRow(DataObject $row): void
    {
        $options = [];
        $type = $row->getType();

        if ($type !== null) {
            $options['option_' . $this->getTypeRenderer()->calcOptionHash($type)] = 'selected="selected"';
        }

        $row->setData('option_extra_attrs', $options);
    }

    /**
     * Get type renderer
     *
     * @return BlockInterface
     */
    private function getTypeRenderer(): BlockInterface
    {
        if (!$this->typeRenderer) {
            $this->typeRenderer = $this->getLayout()->createBlock(
                LinkTypeColumn::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }

        return $this->typeRenderer;
    }
}
