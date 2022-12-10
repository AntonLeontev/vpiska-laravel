<?php

namespace App\Traits\Models;

use Illuminate\Support\Facades\File;

trait HasThumbnail
{
	abstract protected function thumbnailDir(): string;

	public function makeThumbnail(string $size): string
	{
		return route('thumbnail', [
			'size' => $size,
			'dir'  => $this->thumbnailDir(),
			'file' => File::basename($this->{$this->thumbnailColumn()}),
		]);
	}

	protected function thumbnailColumn(): string
	{
		return 'thumbnail';
	}
}
