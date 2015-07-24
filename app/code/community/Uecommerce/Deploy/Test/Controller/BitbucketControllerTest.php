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

   
    
    /**
     * @dataProvider postBitbucket
     */
    public function testPayloadPost($post, $expected) {
        
        $this->dispatch('/deploy/bitbucket', array(), array(
            'payload' => $post
        ));
        
        $this->assertNotContains($expected, $this->getResponseBody());
        
    }
    
    public function postBitbucket(){
        $post = new stdClass();
        $post->repository = new stdClass();
        $post->commits = new stdClass();
        $post->canon_url = 'https://bitbucket.org';
        return array(
            array(json_encode($post), 'cms-no-route')
            
        );
    }

}
