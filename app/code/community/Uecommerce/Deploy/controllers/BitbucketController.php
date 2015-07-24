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
class Uecommerce_Deploy_BitbucketController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {

        /**
         * @var $bitbucket \Uecommerce_Deploy_Model_Bitbucket
         */
        $bitbucket = Mage::getModel('uecommerce_deploy/bitbucket');

        if (!$bitbucket->getConfig('config/active')) {
            $this->noRouteAction();
            return false;
        }

        if (!$this->getRequest()->isPost()) {
            $bitbucket->logError($this->__('Unexpected Access.'), true);
            $this->noRouteAction();
            return false;
        }
        $post = $this->getRequest()->getPost();
       
        if (!array_key_exists('payload', $post)) {
            $bitbucket->logError($this->__('No payload present. A BitBucket POST payload is required to deploy from this script.'), true);
            $this->noRouteAction();
            return false;
        }

        $payload = $this->validatePayload($post);
        if ($payload) {
            $bitbucket->execute($payload);
        } else {
            $bitbucket->logError($this->__('Unexpected Access.'), true);
            $this->noRouteAction();
        }
    }

    /**
     * Check some variables in post Bitbucket
     * 
     * @param json $payload
     * @return boolean|array
     */
    public function validatePayload($payload) {
        $decodePayload = json_decode($payload['payload']);
        
        if (is_object($decodePayload)) {
            if (!property_exists($decodePayload,'repository' ) ||
                    !property_exists($decodePayload, 'commits') ||
                    !property_exists($decodePayload,'canon_url')) {
                return false;
            }

            if ($decodePayload->canon_url != 'https://bitbucket.org' ) {
                return false;
            }

            return $decodePayload;
        }else{
            return false;
        }
    }

}
