<?php

require_once 'Entity/ConfigRepository.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * ConfigRepository test case.
 */
class ConfigRepositoryTest extends PHPUnit_Framework_TestCase
{

    /**
     * Tests ConfigRepository->findAllForNamespace()
     */
    public function testFindAllForNamespace()
    {
        $configRepository = $this->getMock('Arnm\ConfigBundle\Entity\ConfigRepository', array('findByNamespace'), array(), '', false);
        $configRepository->expects($this->once())
                 ->method('findByNamespace')
                 ->with($this->equalTo('name'));
        $configRepository->findAllForNamespace('name');
    }

}

