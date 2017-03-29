<?php

namespace App\RTM\Filter;

class FilterOutput
{
	public function format($dataIn)
	{
		if(! is_array($dataIn['response'])) {
			return $dataIn['response'];
		}

		$response = [
			'kpis' => $this->formatKpis($dataIn['equations']['kpis']),
			'data' => $dataIn['response']
		];

		$dicctionary = array();

		foreach ($dataIn['items'] as $table => $values) {
			foreach ($values as $key => $item) {			
				$dicctionary[$key]['name'] = $item->name;
				
				if(isset($item->node)) {
					$dicctionary[$key]['node'] = $item->node;
				}

				if(isset($item->province)) {
					$dicctionary[$key]['province'] = $item->province;
				}

				if(isset($item->controller)) {
					$dicctionary[$key]['controller'] = $item->controller;
				}
			}
		}

		$response['data'] = array_map(function($entry) use($dicctionary) {
			
			$entry->date = substr($entry->created_at, 0, 10);
			$entry->time = substr($entry->created_at, 11, 5);

			if(isset($entry->item)) {
				if( array_key_exists('node', $dicctionary[$entry->item]) ) {
					$entry->node = $dicctionary[$entry->item]['node'];
				}
				if( array_key_exists('province', $dicctionary[$entry->item]) ) {
					$entry->province = $dicctionary[$entry->item]['province'];
				}
				if( array_key_exists('controller', $dicctionary[$entry->item]) ) {
					$entry->controller = $dicctionary[$entry->item]['controller'];
				}

				$entry->item = $dicctionary[$entry->item]['name'];
			}

			unset($entry->created_at);

			return $entry;
		}, $dataIn['response']);

		return $response;
	}


	private function formatKpis($kpis)
	{
		$response = array();

		foreach ($kpis as $kpi) {
			$obj = new \stdClass();
			$obj->name = strtolower($kpi->name);
			$obj->symbol_red = $kpi->symbol_red;
			$obj->symbol_yellow = $kpi->symbol_yellow;
			$obj->threshold_red = $kpi->threshold_red;
			$obj->threshold_yellow = $kpi->threshold_yellow;
			$response[$obj->name] = $obj;
		}

		return $response;
	}

}