<?php

interface UserRepository {
	public function create( User $user );
	public function update( User $user );
	public function findById(String $id);
	public function users();
}
