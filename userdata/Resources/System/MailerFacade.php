<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\System;

use Nouvu\Framework\Foundation\Application AS App;
use PHPMailer\PHPMailer\{ SMTP, PHPMailer };

use function Nouvu\Resources\System\Helpers\{ config };

final class MailerFacade
{
	public function __construct ( App $app )
	{
		$this -> mail = new PHPMailer( true );
		
		if ( config( 'config.mailer.debug' ) )
		{
			$this -> mail -> SMTPDebug = SMTP :: DEBUG_SERVER;
		}
		
		if ( config( 'config.mailer.smtp' ) )
		{
			$this -> mail -> isSMTP();
			
			foreach ( config( 'config.mailer.host' ) AS $key => $value )
			{
				$this -> mail -> {$key} = $value;
			}
		}
		else
		{
			$this -> mail -> isMail();
		}
		
		$this -> mail -> isHTML( config( 'config.mailer.html' ) );
		
		if ( config() -> has( 'config.mailer.from' ) )
		{
			$this -> setFrom( ...config( 'config.mailer.from' ) );
		}
	}
	
	public function setFrom( string ...$string ): void
	{
		$this -> mail -> setFrom( ...$string );
	}
	
	public function setTo( string ...$string ): void
	{
		$this -> mail -> addAddress( ...$string );
	}
	
	public function setSubject( string $name ): void
	{
		$this -> mail -> Subject = $name;
	}
	
	public function setContent( string $content ): void
	{
		$this -> mail -> Body = $content;
	}
	
	public function send(): bool
	{
		return $this -> mail -> send();
	}
	
	public function getInstance(): PHPMailer
	{
		return $this -> mail;
	}
}