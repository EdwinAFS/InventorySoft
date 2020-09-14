<?php

namespace App\Infraestructure;

use App\Domain\repositories\FileRepository;

class FileRepositoryLocal implements FileRepository
{

	function __construct()
	{
	}

	public function upload($file, $folderName): string
	{
		return 'No implemented';
	}

	public function uploadImage($file, $folderName, $width = 0, $height = 0): string
	{

		list($originalWidth, $originalHeight) = getimagesize($file["tmp_name"]);

		$widthPhoto = $width <= 0 ? $originalWidth : $width;
		$heightPhoto = $height <= 0 ? $originalHeight : $height;

		$directory = "../storage/uploads/{$folderName}";

		if (!is_dir($directory)) {
			mkdir($directory, 0755, true);
		}

		$random = mt_rand(100, 999);

		if ( mime_content_type($file["tmp_name"]) == 'image/png') {
			$origin = imagecreatefrompng($file["tmp_name"]);
			$path = "$directory/$random.png";
		} else {
			$origin = imagecreatefromjpeg($file["tmp_name"]);
			$path = "$directory/$random.jpg";
		}

		$destination = imagecreatetruecolor($heightPhoto, $widthPhoto);

		imagecopyresized($destination, $origin, 0, 0, 0, 0, $heightPhoto, $widthPhoto, $originalWidth, $originalHeight);

		($file['type'] == "image/png") ? imagepng($destination, $path) : imagejpeg($destination, $path);

		return str_replace('../', '', $path);;
	}

	public function delete($fileUrl): void
	{
		unlink("../$fileUrl");
	}
}
