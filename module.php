<?php
$_MODULE = [
	'name' => 'Block Event',
	'description' => 'Event Block mangement',
	'namespace' => '\modules\block_events',
	'config_controller' => 'administrator\BlockEvents',
	'controllers' => [
		'administrator\BlockEvents'
	],
	'block_types' => [
		'Event' => [
			'model' => '\modules\block_events\classes\models\BlockEvent',
			'controller' => 'administrator\BlockEvents',
			'relationships' => [
				'block_event' => [
					'where_fields'  => ['block_event_date', 'block_event_datetime'],
					'join_clause'   => 'LEFT JOIN block_event USING (block_id)',
				],
			],
		],
	],
	'hooks' => [
		'models' => [
			'block_insert' => 'classes\Hooks',
			'block_update' => 'classes\Hooks',
			'block_render' => 'classes\Hooks',
			'block_delete' => 'classes\Hooks'
		]
	],
	'default_config' => [
		'enable_time' => TRUE,
	]
];
