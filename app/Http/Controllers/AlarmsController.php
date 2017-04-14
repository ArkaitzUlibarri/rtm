<?php

namespace App\Http\Controllers;

use App\RTM\Alarm\AlarmRepository;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AlarmsController extends Controller
{
	protected $alarmRepository;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(AlarmRepository $alarmRepository)
	{
		$this->middleware('auth');
		$this->alarmRepository = $alarmRepository;
	}

	/**
	 * Show the alarms view.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('alarms.index');
	}

	/**
	 * Genero y descargo un fichero excel con alarmas.
	 * 
	 * @return [type] [description]
	 */
    public function download()
    {
		Excel::create('Alarms', function($excel) {
			$this->addSheet('Node',	$excel,	$this->fetchBy('node'));
			$this->addSheet('Alarms', $excel, $this->fetchBy('archive'));
		})->export('xlsx');
	}

	/**
	 * Filtro las alarmas de un tipo determinado.
	 * 
	 * @param  $type
	 * @return array
	 */
	private function fetchBy($type)
	{
		$array = $this->alarmRepository->all($type);

		return array_map( function($item) {
			return get_object_vars($item);
		}, $array);
	}

	/**
	 * Creo una pestaña nueva en el excel.
	 * 
	 * @param $name     Nombre de la pestaña
	 * @param $excel    Excel sobre el que crear la pestaña
	 * @param $data     Datos a insertar en la pestaña
	 */
	private function addSheet($name, $excel, $data)
	{
		if(count($data) > 0) {
			$excel->sheet($name, function($sheet) use ($data) {
				$sheet->fromArray($data);
				$sheet->freezeFirstRow();
				$sheet->setHeight(1, 20);
				$sheet->row(1, function($row) {
					$row->setBackground('#C6EFD8');
					$row->setFontColor('#006100');
					$row->setAlignment('center');
					$row->setValignment('center');
				});
			});
		}
		else {
			$excel->sheet($name, function($sheet) {
				$sheet->row(1, array('No data available'));
			});
		}
	}

}
