<?php

namespace modules\block_events\classes\models;

use core\classes\Model;

class BlockEvent extends Model {

	protected $table       = 'block_event';
	protected $primary_key = 'block_event_id';
	protected $columns     = [
		'block_event_id' => [
			'data_type'      => 'int',
			'auto_increment' => TRUE,
			'null_allowed'   => FALSE,
		],
		'block_id' => [
			'data_type'      => 'int',
			'null_allowed'   => FALSE,
		],
		'block_event_date' => [
			'data_type'      => 'date',
			'null_allowed'   => FALSE,
		],
		'block_event_datetime' => [
			'data_type'      => 'datetime',
			'null_allowed'   => TRUE,
		],
		'block_event_url' => [
			'data_type'      => 'text',
			'data_length'    => 256,
			'null_allowed'   => TRUE,
		],
	];

	protected $indexes = [
		'block_id',
	];

	protected $foreign_keys = [
		'block_id' => ['block', 'block_id'],
	];

	protected $relationships = [
		'__common_join__' => 'JOIN block USING (block_id) LEFT JOIN block_category_link USING (block_id) LEFT JOIN block_category USING (block_category_id)',
		'block' => [
			'where_fields'  => ['block_title', 'block_tag'],
		],
		'block_category' => [
			'where_fields'  => ['block_category_id'],
		],
	];

	public function getBlock() {
		if (!$this->block_id) {
			return NULL;
		}

		if (!isset($this->objects['block'])) {
			$this->objects['block'] = $this->getModel('\\core\\classes\\models\\Block')->get(['id' => $this->block_id]);
		}

		return $this->objects['block'];
	}

	public function getUpcoming($limit) {
		if (isset($this->objects['upcoming'])) {
			return $this->objects['upcoming'];
		}

		$sql = "
			SELECT
				*
			FROM
				block_event
				JOIN block USING (block_id)
			ORDER BY
				COALESCE(block_event_datetime, block_event_date::TIMESTAMP)
		";
		$records = $this->database->queryMulti($sql);

		$this->objects['upcoming'] = [];
		foreach ($records as $record) {
			$block = $this->getModel('\core\classes\models\Block', $record);
			$block->setObjectCache('block_type', $this->getModel('\modules\block_events\classes\models\BlockEvent', $record));
			$this->objects['upcoming'][] = $block;
		}

		return $this->objects['upcoming'];
	}
}
