<?php
class DivanteCommon_AdSection_Adminhtml_SectionController extends Mage_Adminhtml_Controller_Action
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
        Mage::register('adsection_section', $this->_getModel());
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

            try {
                /*
                Array
(
    [form_key] => rqGHQbZaJOYRPjtO
    [identifier] => home_slider
    [name] => Home Slider
    [description] => 
) 
                echo '<pre>';
                print_r($this->getRequest()->getPost());
                die;*/
                
                $row->setData($this->getRequest()->getPost())->save();
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

    /**
     * @return DivanteCommon_AdSection_Model_Section
     */
    protected function _getModel()
    {
        $id = $this->getRequest()->getParam('id', false);
        /* @var $model DivanteCommon_AdSection_Model_Section */
        $model = Mage::getModel('divantecommon_adsection/section');

        /** @var $row DivanteCommon_AdSection_Model_Section */
        $row = $id ? $model->load($id) : $model;

        return $row;
    }

}
