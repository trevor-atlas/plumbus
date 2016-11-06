<?php namespace Plumbus;

class Locate
{

	public function __construct() {
		$this->root = get_bloginfo('stylesheet_directory');
		$this->fileExtensions = [
			'jpg' => 'image',
			'jpeg' => 'image',
			'png' => 'image',
			'svg' => 'image',
			'js' => 'script',
			'css' => 'style',
			'mp4' => 'video',
			'webm' => 'video',
		];
		$this->themeDirs = [
			'image' => "/assets/images/",
			'script' => "/assets/scripts/",
			'style' => "/assets/css/",
			'video' => "/assets/videos/",
		];
	}

	protected function ValidateFilePath(string $endpoint): string {
		if (!file_exists(get_template_directory().$endpoint)) {
			return "File does not exist at {$endpoint}";
		}
		return $this->root.$endpoint;
	}

	protected function getDirectoryFromFile(string $fileName):string {
		$ext = explode(".", $fileName)[1];
		if (!isset($this->fileExtensions[$ext])) {
			return "No such file or path for file '{$fileName}'";
		}
		return $this->themeDirs[$this->fileExtensions[$ext]];
	}

	public function file(string $fileName): string {
		$filePath = self::getDirectoryFromFile($fileName);
		return self::ValidateFilePath($filePath.$fileName);
	}

}
