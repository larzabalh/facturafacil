<?php

namespace JOYAS\JoyasBundle\Controller;

/**
 * This code has been auto-generated by the JMSDiExtraBundle.
 *
 * Manual changes to it will be lost.
 */
class UsuarioController__JMSInjector
{
    public static function inject($container) {
        $instance = new \JOYAS\JoyasBundle\Controller\UsuarioController();
        $instance->sessionSvc = $container->get('session.manager', 1);
        return $instance;
    }
}