<?php

class Uecommerce_Deploy_Test_Model_BitbucketTest extends PHPUnit_Framework_TestCase
{
    public function testGetServiceName(){
        $bitbucket = Mage::getModel('uecommerce_deploy/bitbucket');
        $this->assertEquals('bitbucket',$bitbucket->getServiceName());
    }
    
    public function testGetGitCommands(){
        $bitbucket = Mage::getModel('uecommerce_deploy/bitbucket');
        $this->assertGreaterThanOrEqual(0, count($bitbucket->getGitCommands()));
    }
}

