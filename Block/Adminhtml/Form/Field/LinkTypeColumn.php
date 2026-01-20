<?php

/**
 * @author Magebit <info@magebit.com>
 * @copyright Copyright (c) Magebit, Ltd. (https://magebit.com)
 * @license https://magebit.com/code-license
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Block\Adminhtml\Form\Field;

use Magento\Framework\View\Element\Html\Select;

/**
 * Link Type Column for Session Links Configuration
 */
class LinkTypeColumn extends Select
{
    /**
     * Set input name
     *
     * @param string $value
     * @return self
     */
    public function setInputName(string $value): self
    {
        return $this->setName($value);
    }

    /**
     * Set input id
     *
     * @param string $value
     * @return self
     */
    public function setInputId(string $value): self
    {
        return $this->setId($value);
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    public function _toHtml(): string
    {
        if (!$this->getOptions()) {
            $this->setOptions($this->getSourceOptions());
        }
        return parent::_toHtml();
    }

    /**
     * Get source options
     *
     * @return array<int, array{label: string, value: string}>
     */
    private function getSourceOptions(): array
    {
        return [
            ['label' => 'Privacy Policy', 'value' => 'privacy_policy'],
            ['label' => 'Terms of Service', 'value' => 'terms_of_service'],
            ['label' => 'Refund Policy', 'value' => 'refund_policy'],
            ['label' => 'Shipping Policy', 'value' => 'shipping_policy'],
            ['label' => 'FAQ', 'value' => 'faq'],
        ];
    }
}
