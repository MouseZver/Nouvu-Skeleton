<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Entity;

class Permission
{
	private int $id;
	private string $name;
	private string $permission;
	private string $role;
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
	
	public function setPermission( string $permission ): self
	{
		$this -> permission = $permission;
		
		return $this;
	}
	
	public function getPermission(): string
	{
		return $this -> permission;
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
	
	public function getCreatedAt(): \DateTime
    {
		return $this -> created_at;
	}
}