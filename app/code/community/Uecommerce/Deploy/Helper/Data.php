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
class Uecommerce_Deploy_Helper_Data extends Mage_Core_Helper_Abstract 
{
    
    protected $_logFilesDefaultNames = array(
        'bitbucket' => 'Bitbucket_Deploy.log',
        'error' => 'Deploy_Error.log'
    );
    
    /**
     * Get the name of the file (bitbucket) deploy log
     * 
     * @return string
     */
    public function getDeployFile($service = null) {
        $logFile = Mage::getStoreConfig('uecommerce_deploy/'.$service.'/logfile');
        
        if(!isset($logFile) || $logFile == ''){
            if(!is_null($service)){
                $logFile = $this->_logFilesDefaultNames[$service];
            }else{
                $logFile = 'Uecommerce_Deploy.log';
            }
        }
        
        return $logFile;
    }
    
    /**
     * Generate log for services
     * 
     * @param string $message
     * @param string $service
     * @return boolean
     */
    public function logService($message = '', $service = null){
        if(is_null($service) || $message == ''){
           return false; 
        }
        Mage::log($message,null, $this->getDeployFile($service));
        return true;
        
    }
    
    
    /**
     * Generate log for errors
     * 
     * @param string $message
     * @return boolean
     */
    public function logError($message = '', $displayIp = false){
        if($message == ''){
            return false;
        }
        
        Mage::log($message, null ,$this->getDeployFile('error'));
        
        if($displayIp){
            Mage::log($this->logVisitorInformations(), null, $this->getDeployFile('error'));
        }
        return true;
    }
    
    /**
     * Return visitor informations
     */
    public function logVisitorInformations(){
        return array(
            'Remote Addr' => Mage::helper('core/http')->getRemoteAddr(),
            'Server Addr' =>  Mage::helper('core/http')->getServerAddr(),
            'Http Host' =>  Mage::helper('core/http')->getHttpHost(),
            'Http User Agent' =>  Mage::helper('core/http')->getHttpUserAgent(),
            'Accept Language' => Mage::helper('core/http')->getHttpAcceptLanguage(),
            'Http Referer' => Mage::helper('core/http')->getHttpReferer(),
            'Request URI' => Mage::helper('core/http')->getRequestUri(),
        );
        
    }
    
    /**
     * Check if native method enabled 
     * @param string $function Native function name
     * @return bollean
     */
    public function isMethodEnabled($function){
        $disabled = explode(',', ini_get('disable_functions'));
        return !in_array($function, $disabled);
    }

}
