<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Main extends Controller {

	public function action_index()
	{		
		//отображение
		$view = View::factory('/main');   
        $this->response->body($view);
   	}

   	public function action_getLogs() 
   	{
   		$params = $_GET;

   		//получение логов из БД
   		$obj = new Model_Main();
   		$logs = $obj->getLogs($params);

   		$result = [
   			'data' => $logs,
            'success' => true
   		];

   		echo json_encode($result);
   	}

      public function action_saveLogs() 
      {
         $obj = new Model_Main();
         $logs = $obj->getLogsFromFiles(); 
         $obj->saveLogs($logs);  

         $result = [
            'success' => true
         ];

         echo json_encode($result);
      }
}

