<?php
namespace AppBundle\Monolog\Processor;

use Symfony\Component\HttpFoundation\Session\Session;

class SessionRequestProcessor
{
	private $session;
	private $token;

	public function __construct(Session $session)
	{
		$this->session = $session;
	}

	public function processRecord(array $record)
	{
		if (null === $this->token) {
			try {
				$this->token = substr($this->session->getId(), 0, 8);
			} catch (\RuntimeException $e) {
				$this->token = '????????';
			}
			$this->token .= '-' . substr(uniqid(), -8);
		}
		$record['extra']['token'] = $this->token;

		return $record;
	}
}