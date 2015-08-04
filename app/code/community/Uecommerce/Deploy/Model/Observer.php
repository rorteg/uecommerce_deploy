<?php
/**
 * Uecommerce
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Uecommerce EULA.
 * It is also available through the world-wide-web at this URL:
 * http://www.uecommerce.com.br/
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the extension
 * to newer versions in the future. If you wish to customize the extension
 * for your needs please refer to http://www.uecommerce.com.br/ for more information
 *
 * @category   Uecommerce
 * @package    Uecommerce_Deploy
 * @copyright  Copyright (c) 2012 Uecommerce (http://www.uecommerce.com.br/)
 * @license    http://www.uecommerce.com.br/
 */

/**
 * Deploy
 *
 * @category   Uecommerce
 * @package    Uecommerce_Deploy
 * @author     Uecommerce Dev Team
 */

class Uecommerce_Deploy_Model_Observer
{
    public function handle_adminSystemConfigChanged($observer){
        /**
         * @var $helper Uecommerce_Deploy_Helper_Data
         */
        $helper = Mage::helper('uecommerce_deploy');
        
        if(!$helper->isMethodEnabled('exec') && !$helper->isMethodEnabled('shell_exec')){
            Mage::getSingleton('core/session')->addError($helper->__('The method "exec" and "shell_exec" of php is disabled or not exists, the module will not function correctly.'));
        
            return false;
        }
        
        if(strpos(shell_exec('git --version'), 'git version') === false){
            Mage::getSingleton('core/session')->addError($helper->__('Git is not installed on this server'));
            return false;
        }
        
        
        
    }
    
    
}
