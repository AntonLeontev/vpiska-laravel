<?php

namespace App\Actions;

use App\Models\Event;
use App\Events\EventArchived;

class ArchiveOldEventsAction
{
	public function handle()
	{
		Event::where('ends_at', '<', now())
			->where('status', Event::ACTIVE)
			->chunkById(300, function ($events) {

				foreach ($events as $event) {
					$event->updateOrFail(['status' => Event::ARCHIVED]);
					event(new EventArchived($event));
				}
			});
	}
}
