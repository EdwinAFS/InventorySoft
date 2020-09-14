<?php

namespace App\Domain\repositories;

interface FileRepository {
	public function upload( $file, $directory ) : string;
	public function uploadImage( $file, $directory, $width = -1, $height = -1 ) : string;
	public function delete( $fileUrl ): void;
}
