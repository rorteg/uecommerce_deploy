<a href="http://www.uecommerce.com.br">![Uecommerce](http://www.uecommerce.com.br/wp-content/uploads/2012/11/logo2.gif)</a>

Magento Module for Automatic Deployment
===================

Magento module that provides functionality for automated deployment through services like bitbucket, Github, etc ... [POST].

System Requirements
-------------------
* PHP 5.3 or higher
* Magento CE1.7.x-1.8.x-1.9.x

Build Status
------------
* Latest Release: [![Master Branch](https://travis-ci.org/rorteg/uecommerce_deploy.png?branch=master)](https://travis-ci.org/rorteg/uecommerce_deploy)
* Development Branch: [![Development Branch](https://travis-ci.org/rorteg/uecommerce_deploy.png?branch=develop)](https://travis-ci.org/rorteg/uecommerce_deploy)

Installation
------------
There are two ways of obtaining the extension:    
    *Use [Module Manager](https://github.com/colinmollenhour/modman) 
    ```bash
    modman clone https://github.com/rorteg/uecommerce_deploy.git
    ```

Usage Bitbucket
---------------
1. Read the documentation: https://confluence.atlassian.com/display/BITBUCKET/Manage+Bitbucket+services#ManageBitbucketservices-Whattriggersapost-receiveservice?
    * Select POST
    * In the URL type http://mymagentoproject.com/deploy/bitbucket
2. In your Magento Administration:
    * Change the branch if necessary (in staging environments).

Features:
* Bitbucket integration
* (TODO) Github integration
