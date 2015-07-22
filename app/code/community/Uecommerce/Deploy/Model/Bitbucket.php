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

class Uecommerce_Deploy_Model_Bitbucket extends Uecommerce_Deploy_Model_Abstract 
implements Uecommerce_Deploy_Model_Contracts_ServiceInterface
{
    public function __construct(){
        parent::__construct();
    }
    
    /**
     * Implements interface
     * 
     * @return string
     */
    public function getServiceName() {
        return 'bitbucket';
    }
    
    /**
     * Get branch to deploy
     * 
     * @return array
     */
    public function getBranchToDeploy() {
        $branch = $this->getConfigFlag('branch');
        return ($branch != '') ? $branch : self::BRANCH_DEFAULT_TO_DEPLOY;
    }
    
}

