<?php

namespace modules\block_events\controllers\administrator;

use core\classes\renderable\Controller;
use core\classes\Model;
use core\classes\Module;
use core\classes\Pagination;
use core\classes\FormValidator;
use core\controllers\administrator\Blocks as BaseBlocks;

class BlockEvents extends BaseBlocks {

	protected $block_type = 'Event';
	protected $autogen_tag = TRUE;

	protected function getBlockTypeFormInputs() {
		return [
			'date' => [
				'type' => 'date',
				'required' => TRUE,
			],
			'time' => [
				'type' => 'time',
				'required' => FALSE,
			],
			'url' => [
				'type' => 'url',
				'required' => FALSE,
			],
		];
	}

	protected function getListHeadings() {
		return [
			'date'     => 'block_event_date',
			'title'    => 'title',
			'tag'      => 'tag',
			'category' => 'category_name',
			'type'     => 'block_type_name',
		];
	}

	protected function getListData() {
		return [
			'date'     => function($block) {return htmlspecialchars($block->getType()->date);},
			'title'    => function($block) {return htmlspecialchars($block->title);},
			'tag'      => function($block) {return htmlspecialchars($block->tag);},
			'category' => function($block) {return htmlspecialchars($block->getCategoryName());},
			'type'     => function($block) {return htmlspecialchars($block->getBlockType()->name);},
		];
	}

	protected function getBlockTypeHtmlInputs($block, $form, $extra_data) {
		$data = [
			'block' => $block,
			'form'  => $form,
		];
		if ($extra_data) {
			$data = array_merge($data, $extra_data);
		}
		$template = $this->getTemplate('edit_forms/event.php', $data, 'modules'.DS.'block_events');
		return $template->render();
	}

	protected function updateTypeFromRequest(FormValidator $form, $block_type) {
		$block_type->datetime = NULL;
		$timestamp = strtotime($form->getValue('date').' '.$form->getValue('time'));
		if ($form->getValue('time') && $timestamp) {
			$block_type->datetime = date('c', $timestamp);
		}

		$date = strtotime($form->getValue('date'));

		$block_type->date = $date ? date('Y-m-d', $date) : NULL;
		$block_type->url = $form->getValue('url') ? $form->getValue('url') : NULL;
	}

	public function index($message = NULL) {
		$this->language->loadLanguageFile('administrator/block_events.php', 'modules'.DS.'block_events');
		parent::index($message);
	}

	public function add($type = NULL, $extra_data = NULL) {
		$this->language->loadLanguageFile('administrator/block_events.php', 'modules'.DS.'block_events');
		$module_config = $this->config->moduleConfig('\modules\block_events');
		$extra_data = ['enable_time' => $module_config->enable_time];
		parent::add($this->block_type, $extra_data);
	}

	public function edit($tag, $extra_data = NULL) {
		$this->language->loadLanguageFile('administrator/block_events.php', 'modules'.DS.'block_events');
		$module_config = $this->config->moduleConfig('\modules\block_events');
		$extra_data = ['enable_time' => $module_config->enable_time];
		parent::edit($tag, $extra_data);
	}

}