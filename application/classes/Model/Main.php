<?php defined('SYSPATH') or die('No direct script access.');

class Model_Main extends Model {
	/**
	* @var название таблицы
	*/
	const table_name = 'logs'; 

	/**
	* @var название файлов с логами, последовательность колонок в файлах, разделитель колонок
	*/
	const files = [
  	[
			'filename' => 'logs'.DIRECTORY_SEPARATOR.'log1.txt',
			'columns'  => [
				'date',
				'time',
				'ip',
				'url_from',
				'url_to'
			],
			'separator' => '|'
		],[
      'filename' => 'logs'.DIRECTORY_SEPARATOR.'log2.txt',
      'columns'  => [
        'ip',
        'browser',
        'os'
      ],
      'separator' => '|'
    ]
	];

   	/**
	* Записывает данные файла в массив
	* 
	* @param $file array данные файла (название, колонки, разделитель колонок) 
	* @param $k int номер итерации (для сопоставления названия колонок и данных)
	* @return array
   	*/
   	private function fileDataToArray(array $file, $k) 
   	{
   		$arr = [];
   		$fileName = $file['filename'];
   		$separator = $file['separator'];
   		$columns = $file['columns'];
   		if (file_exists($fileName)) {
   			$arr = file($fileName);
   			foreach ($arr as &$v) {
   				$v = explode($separator, $v);
   				$v = array_combine(self::files[$k]['columns'], $v);
   			}
   			unset($v);
   		}

   		return $arr;
   	}

   	/**
	  * Объединяет логи из разных файлов
	  *
	  * @return array
   	*/
   	public function getLogsFromFiles() 
   	{
   		$result = [];
   		$logs = [];

   		//преобразование данных файла в массив
   		foreach (self::files as $k => $f) {
   			$logs[] = $this->fileDataToArray($f, $k);
   		}

   		//объединение логов из 1-ого и 2-ого файла
   		foreach ($logs[0] as $log1) {
   			$logArr1 = $log1;

   			$logArr2 = array_filter($logs[1], function($log2) use ($log1) {
   				if ($log1['ip'] === $log2['ip']) {
   					return $log2;
   				}
   			});

   			$result[] = array_merge($logArr1, reset($logArr2));
   		}
   		

   		return $result;
   	}

   	/**
	* Запись логов в БД
	*
	* @param $data array данные для записи в БД
   	*/
   	public function saveLogs(array $data)
   	{
   		foreach ($data as $record) {
   			DB::insert(self::table_name)
			    ->columns(array_keys($record))
			    ->values(array_values($record))
			    ->execute();
   		}   		
   	}

   	/**
	* Получает логи из БД
	*
	* @param $params array парметры для сортировки, фильтрации
	* @return array
   	*/
   	public function getLogs(array $params) 
   	{
   		$limit = $params['limit'];

   		$column = 'date';
   		$direction = 'DESC';

   		if (isset($params['sort'])) {
        	$sort = json_decode($params['sort']);
        	$column = $sort[0]->property;
        	$direction = $sort[0]->direction;
        }

        //реализация одного фильтра
        $field = 1;
        $value = 1;

        if (isset($params['filter'])) {
        	$filter = json_decode($params['filter']);
        	$field = $filter[0]->property;
        	$value = $filter[0]->value;
        }



   		$query = DB::select()
        ->from(self::table_name)
        ->where($field, '=', $value)        
        ->limit($limit)
        ->order_by($column, $direction);     


        $result = $query->execute()->as_array();
        return $result;
   	}

}