<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Entity;

class Role
{
	private int $id;
	private string $name;
	private ?string $message = null;
	private string $role;
	private array $role_hierarchy;
	private \DateTime $created_at;
	
	public function getId(): int
	{
		return $this -> id;
	}
	
	public function setName( string $name ): self
	{
		$this -> name = $name;
		
		return $this;
	}
	
	public function getName(): string
	{
		return $this -> name;
	}
	
	public function setMessage( string $message ): self
	{
		$this -> message = $message;
		
		return $this;
	}
	
	public function getMessage(): ?string
	{
		return $this -> message;
	}
	
	public function setRole( string $role ): self
	{
		$this -> role = $role;
		
		return $this;
	}
	
	public function getRole(): string
	{
		return $this -> role;
	}
	
	public function setRoleHierarchy( array $role_hierarchy ): self
	{
		$this -> role_hierarchy = $role_hierarchy;
		
		return $this;
	}
	
	public function getRoleHierarchy(): array
	{
		return array_unique ( [ ...$this -> role_hierarchy ] );
	}
	
	public function getCreatedAt(): \DateTime
    {
		return $this -> created_at;
	}
}