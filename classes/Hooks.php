<?php

namespace modules\block_events\classes;

use core\classes\Hook;
use core\classes\Request;
use core\classes\Config;
use core\classes\Logger;
use core\classes\Database;
use core\classes\Model;
use core\classes\Module;
use core\classes\models\Block;

class Hooks extends Hook {

	public function block_insert(Block $block) {
	}

	public function block_update(Block $block) {
	}

	public function block_delete(Block $block) {
		$mathjax = $block->getModel('\modules\block_mathjax\classes\models\BlockEvent')->get([
			'block_id' => $block->id
		]);
		$mathjax->delete();
		return ;
	}

	public function block_render(Block $block) {
		$model  = new Model($this->config, $this->database);
		$content = $model->getModel('\modules\block_mathjax\classes\models\BlockEvent')->get(['block_id' => $block->id]);
		if ($content) {
			return 'asdfasdfsadfsadf';
		}
		return NULL;
	}
}
