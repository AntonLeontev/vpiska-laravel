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

];