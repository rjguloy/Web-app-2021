<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	function isPasswordValid($password){
		if (! preg_match( '/^(?=.*[_=!@#$%^&*+-])(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z]).{6,}$/', $password)) {
	     	return false;
	    } else { 
	     	return true;
	    }
    }
