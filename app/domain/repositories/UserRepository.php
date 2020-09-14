<?php

namespace App\Domain\repositories;

use App\Domain\models\User;

interface UserRepository {
	public function create( User $user );
	public function update( User $user );
	public function findById(String $id);
	public function findByUsername(String $username);
	public function users();
}
