<?php
class DivanteCommon_AdSection_Adminhtml_BlockController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout();

        return $this;
    }

    public function indexAction()
    {
        $this->_initAction()->renderLayout();
    }

    public function editAction()
    {
        Mage::register('adsection_block', $this->_getModel());
        $this->_initAction()->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function saveAction()
    {
        $row = $this->_getModel();

        if($this->getRequest()->isPost()) {

            $type = $this->getRequest()->getPost('type', 0);
            /* @var $helper DivanteCommon_AdSection_Helper_Block */
            $helper = Mage::helper('divantecommon_adsection/block');

            if(! in_array($type, array_keys($helper->getTypesList())) || ! (bool) $type) {
                $this->_getSession($this->__("Invalid object type."));
                $this->_redirectReferer();
            }

            $post = $this->getRequest()->getPost();

            $row->setData($post);
            $isActive = $this->getRequest()->getPost('is_active', null);

            $row->setIsActive($isActive === null ? 0 : 1);

            switch($type) {
                case DivanteCommon_AdSection_Model_Block::HTML_TYPE:

                    $row->setResource($this->getRequest()->getPost('resource_' . DivanteCommon_AdSection_Model_Block::HTML_TYPE));

                    break;
                case DivanteCommon_AdSection_Model_Block::IMAGE_TYPE:

                    if(count($_FILES)
                        && isset($_FILES['resource_' . DivanteCommon_AdSection_Model_Block::IMAGE_TYPE])
                        && $_FILES['resource_' . DivanteCommon_AdSection_Model_Block::IMAGE_TYPE]['size'] > 0) {

                        $toUploadDir = Mage::getBaseDir('media') . DS . '/adsection_blocks';

                        if(! is_dir($toUploadDir)) {
                            mkdir(Mage::getBaseDir('media') . DS . 'adsection_blocks');
                        }

                        $uploader = new Varien_File_Uploader('resource_' . DivanteCommon_AdSection_Model_Block::IMAGE_TYPE);
                        $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
                        $uploader->setAllowRenameFiles(false);
                        $uploader->setFilesDispersion(false);

                        $newFileName = time() . '_' . $_FILES['resource_' . DivanteCommon_AdSection_Model_Block::IMAGE_TYPE]['name'];
                        $newFileName = str_replace(' ', '_', $newFileName);

                        try {
                            $uploader->save($toUploadDir, $newFileName);
                        } catch (Exception $e) {
                            $this->_getSession()->addError($this->__('Upload file error with message: ' . $e->getMessage()));
                            $this->_redirect('*/*/');
                        }

                        $row->setResource(Mage::getBaseUrl('media') . 'adsection_blocks/' . $newFileName);
                    }

                    break;
                case DivanteCommon_AdSection_Model_Block::SWF_TYPE:
                    break;
            }

            try {
                $row->save();

                $this->_getSession()->addSuccess($this->__("Save success."));
            } catch (Exception $e) {

                $this->_getSession()->addError($this->__("Save error with message:") . $e->getMesage());
            }

        }

        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        $row = $this->_getModel();
        if($row->getId()) {
            try {
                $row->delete();
                $this->_getSession()->addSuccess($this->__("Delete success."));
            } catch (Exception $e) {
                $this->_getSession()->addError($this->__("Delete error with message: " . $e->getMessage()));
            }
        }

        $this->_redirect('*/*/');
    }

    public function activateAction()
    {
        $model = $this->_getModel();
        $model->setIsActive(true);
        $model->save();

        $this->_forward('index');
    }

    public function deactivateAction()
    {
        $model = $this->_getModel();
        $model->setIsActive(false);
        $model->save();

        $this->_forward('index');
    }

    /**
     * @return DivanteCommon_AdSection_Model_Block
     */
    protected function _getModel()
    {
        $id = $this->getRequest()->getParam('id', false);
        /* @var $model DivanteCommon_AdSection_Model_Block */
        $model = Mage::getModel('divantecommon_adsection/block');

        /** @var $row DivanteCommon_AdSection_Model_Block */
        $row = $id ? $model->load($id) : $model;

        return $row;
    }
}
