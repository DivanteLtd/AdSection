<?php
class DivanteCommon_AdSection_Block_Section extends DivanteCommon_AdSection_Block_Section_Abstract
{

    protected function _toHtml()
    {
        if($this->_template) {
            return parent::_toHtml();
        }
        $block = $this->getBlockIdentifier() ?
            $this->getSection()->getActiveBlockByAdditionalIdentifier($this->getBlockIdentifier())
            : $this->getSection()->getMostImportantActiveBlock();

        switch($block->getType()) {
            case $block::HTML_TYPE:
                return $block->getResource(true);
            case $block::IMAGE_TYPE:
                return $this->renderImageTypeHtml($block);
            case $block::SWF_TYPE:
            default:
                return '';
        }
    }


}
