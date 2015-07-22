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
class Uecommerce_Deploy_Test_Controller_BitbucketControllerTest extends Codex_Xtest_Xtest_Unit_Frontend {

    
    public function testPayloadPost() {
        $this->isSupported();
        $this->dispatch('/deploy/bitbucket', array(), array(
            'payload' => json_encode(array())
        ));
        $this->assertEquals(array(), json_decode(Mage::app()->getRequest()->getPost('payload')));
    }

    protected function isSupported() {
        if (!version_compare(Mage::getVersion(), '1.8', '>=')) {
            echo '** Codex_Xtest for now only supports version 1.9.x **';
            $this->markTestSkipped(
                    '*Codex_Xtest does not support this Magento Version*'
            );
        }
    }

}
