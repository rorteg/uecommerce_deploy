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
abstract class Uecommerce_Deploy_Model_Abstract {

    /**
     * @var string Name of the service to deploy
     */
    protected $_service;

    /**
     *
     * @var array commands for execute.
     */
    private $_gitCommands = array();

    /**
     * Branch default to deploy 
     */
    const BRANCH_DEFAULT_TO_DEPLOY = 'master';

    /**
     *
     * @var string branch to deploy
     */
    protected $_branch;

    /**
     *
     * @var string repository
     */
    protected $_repo;

    public function __construct() {
        if (!$this->getConfig('config/active')) {
            return false;
        }
        $this->_branch = $this->getBranchToDeploy();
        $this->prepareDefaultCommands();
    }

    /**
     * 
     * @return \Uecommerce_Deploy_Model_Abstract
     */
    protected function prepareDefaultCommands() {
        $this->addGitCommand('git reset --hard HEAD', 'Reseting repository...')
                ->addGitCommand('git pull origin ' . $this->_branch, 'Pulling in changes...')
                ->addGitCommand('chmod -R og-rx .git', 'Securing .git directory...');
        return $this;
    }

    /**
     * Set service to deploy
     * @param string $service Name of the service to deploy
     */
    public function setService($service) {
        $this->_service = $service;
    }

    /**
     * Get service to deploy
     * @return string
     */
//    public function getServiceName() {
//        return $this->_service;
//    }

    /**
     * 
     * @param string $path
     * @param mixed $store
     * @return mixed
     */
    public function getConfig($path, $store = null) {
        return Mage::getStoreConfig('uecommerce_deploy/' . $path, $store);
    }

    /**
     * 
     * @param string $flag
     * @param mixed $store
     * @return mixed
     */
    public function getConfigFlag($flag, $store = null) {
        return $this->getConfig($this->getServiceName() . '/' . $flag, $store);
    }

    /**
     * 
     * @return Uecommerce_Deploy_Helper_Data
     */
    public function getHelper() {
        return Mage::helper('uecommerce_deploy');
    }

    /**
     * 
     * @param string $message
     * @return \Uecommerce_Deploy_Model_Abstract
     */
    public function logService($message) {
        $this->getHelper()->logService($message, $this->getServiceName());
        return $this;
    }

    /**
     * 
     * @param string $message
     * @param boolean $displayIp
     * @return \Uecommerce_Deploy_Model_Abstract
     */
    public function logError($message, $displayIp = false) {
        $this->getHelper()->logError($message, $displayIp);
        return $this;
    }

    /**
     * 
     * @param string $command
     * @return \Uecommerce_Deploy_Model_Abstract
     */
    public function addGitCommand($command, $message = '') {
        if (strpos($command, 'git') !== false) {
            $newCommand = new Varien_Object();
            $newCommand->setData('command', $command);
            $newCommand->setData('message', $message);
            $this->_gitCommands[] = $newCommand;
        }
        return $this;
    }

    /**
     * Get all git commands
     * 
     * @return array
     */
    public function getGitCommands() {
        return $this->_gitCommands;
    }

    /**
     * Execute all git commands to deploy
     * 
     * @return \Uecommerce_Deploy_Model_Abstract
     */
    public function execute($payload = null) {
        try {

            if (!$this->getConfig('config/active')) {
                return false;
            }

            chdir(Mage::getBaseDir());

            $gitCommands = $this->getGitCommands();
            $messages = '';
            $output = '';
            foreach ($gitCommands as $command) {
                exec($command->getCommand(), $output);
                $command->setOutput($output);
                $messages .= PHP_EOL . '* ===============*COMMANDS*=============== *' . PHP_EOL;
                $messages .= $this->formatMessages($command, $payload);
                $messages .= PHP_EOL . '* ========================================= *' . PHP_EOL;
            }
            
            $this->logService($messages);

            return $this;
        } catch (Exception $e) {
            Mage::logException($e);
            $this->logError($e);
        }
    }

    /**
     * Format messages output
     * 
     * @param Varien_Object $command
     * @return string Message
     */
    protected function formatMessages(Varien_Object $command, $payload = null) {
        $messages = '';
        
        $messages .= PHP_EOL . ' - ' . $command->getMessage() . PHP_EOL;
        $messages .= 'INPUT: ' . $command->getCommand() . PHP_EOL;
        $messages .= 'OUTPUT: ' . print_r($command->getOutput()) . PHP_EOL . PHP_EOL;
        
        if(!is_null($payload)){
            $this->logService(json_decode($payload));
        }
        
        return $messages;
    }

}
