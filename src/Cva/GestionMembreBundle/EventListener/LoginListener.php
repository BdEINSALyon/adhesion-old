<?php

namespace Cva\GestionMembreBundle\EventListener;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LoginListener {

	private $securityContext;
	private $session;

	public function __construct(SecurityContext $securityContext, Session $session) {

		$this->securityContext = $securityContext;
		$this->session = $session;
	}
	
	public function onSecurityInteractiveLogin(InteractiveLoginEvent $event) {

		$this->session->set('idUser', $this->securityContext->getToken()->getUser()->getId());
		$this->session->set('username', $this->securityContext->getToken()->getUser()->getUsername());		
	}	
	
}
