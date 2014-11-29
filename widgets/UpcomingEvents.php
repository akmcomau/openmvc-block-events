<?php

namespace modules\block_events\widgets;

use core\classes\exceptions\RenderableException;
use core\classes\Model;
use core\classes\renderable\Widget;

class UpcomingEvents extends Widget {

	public function render($limit = 10) {
		$model = new Model($this->config, $this->database);

		$block_event = $model->getModel('\modules\block_events\classes\models\BlockEvent');
		$events = $block_event->getUpcoming(4);

		$data = ['events' => $events];
		$template = $this->getTemplate('widgets/upcoming_events.php', $data, 'modules'.DS.'block_events');
		return $template->render();
	}
}