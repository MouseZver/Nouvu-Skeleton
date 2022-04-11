<?php

return [
	/*
		- 
	*/
	'user' => function ( object $std ): void
	{
		$this -> id = $std -> id;
		
		$this -> username = $std -> username;
		
		$this -> email = $std -> email;
		
		$this -> password = $std -> password;
		
		$this -> roles = json_decode ( $std -> roles, true );
		
		$this -> enabled = ( bool ) $std -> enabled;
		
		$this -> created_at = new \DateTime( $std -> created_at );
	},
	
	/*
		- 
	*/
	'role' => function ( object $std ): void
	{
		$this -> id = $std -> id;
		
		$this -> name = $std -> name;
		
		$this -> message = $std -> message;
		
		$this -> role = $std -> role;
		
		$this -> role_hierarchy = json_decode ( $std -> role_hierarchy, true );
		
		$this -> created_at = new \DateTime( $std -> created_at );
	},
	
	/*
		- 
	*/
	'permission' => function ( object $std ): void
	{
		$this -> id = $std -> id;
		
		$this -> name = $std -> name;
		
		$this -> permission = $std -> permission;
		
		$this -> role = $std -> role;
		
		$this -> created_at = new \DateTime( $std -> created_at );
	},
];