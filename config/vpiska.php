<?php

return [
	//Комиссии в рублях
	'fees' => [
		'default' => 70,
	],


	'event' => [
		/*Столько дней нужно добавить к сегодняшней дате,
		чтобы получить дату, после которой нельзя 
		создавать новый ивент*/
		'beforeDaysCreating' => 3
	],

	//Часовой пояс по-умолчанию (Москва)
	'utc_offset' => 3,

	'max_photo_per_user' => 10,
	'max_photo_per_event' => 10,
	'max_image_size' => 3072, //kB
	'min_image_height' => 200, //px
	'min_image_width' => 200, //px
];
