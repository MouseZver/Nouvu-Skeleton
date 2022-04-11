<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
//use Symfony\Component\Security\Core\Encoder\EncoderAwareInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
	private int $id;
	private string $username;
	private string $email;
	private string $password;
	private string $plainPassword;
	private array $roles;
	private bool $enabled;
	private \DateTime $created_at;
	
	public function getId(): int
	{
		return $this -> id;
	}
	
	public function getUserIdentifier(): string
	{
		return $this -> username;
	}
	
	public function getUsername(): string
	{
		return $this -> getUserIdentifier();
	}
	
	public function setUsername( string $username ): self
	{
		$this -> username = $username;
		
		return $this;
	}
	
	public function getEmail(): string
	{
		return $this -> email;
	}
	
	public function setEmail( string $email ): self
	{
		$this -> email = $email;
		
		return $this;
	}
	
	public function setPassword( string $password ): self
	{
		$this -> password = $password;
		
		return $this;
	}
	
	public function getPassword(): string
	{
		return $this -> password;
	}
	
	public function setPlainPassword( string $password ): self
	{
		$this -> plainPassword = $password;
		
		return $this;
	}
	
	public function getPlainPassword(): string
	{
		return $this -> plainPassword;
	}
	
	public function setRoles( array $roles ): void
	{
		$this -> roles = $roles;
	}
	
	public function getRoles(): array
	{
		return array_unique ( [ /*'ROLE_USER',*/ ...$this -> roles ] );
	}
	
	public function isEnabled(): bool
    {
        return $this -> enabled;
    }
	
	public function getCreatedAt(): \DateTime
    {
		return $this -> created_at;
	}
	
	public function getSalt(): ?string
	{
		return null;
	}
	
	public function getEncoderName(): string
	{
		return self :: class;
	}
	
	public function eraseCredentials(): void
	{}
}