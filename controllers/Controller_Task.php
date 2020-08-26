<?php

namespace controllers;

use \core\Controller;
use \models\Tasks;

class Controller_Task extends Controller {
public function action_index($params=[]){
$current_page = $params ['page'] ?? 1;
$current_sort = $params['sort'] ?? 'id ASC';
// TODO: InvalidArgumentException
$offset = ( (int) $current_page - 1 ) * 3;
$select = array (
'order' => $current_sort,
'limit' => 3,
'offset' => $offset

);
$model = new Tasks($select);

$model['page'] = $current_page;
$model['sort'] = $current_sort;

$pager = new Tasks();

$this->view->generate('main.php', 'layout.php', ['model' => $model, 'pager' => $pager]);

}
public function action_create(){
  $this->view->generate('create.php', 'layout.php');
}

public function action_save (){
  $model = new Tasks();
  $keys = $model->fieldsTable();
  foreach ($keys as $key => $value){

    if ( $_POST[ $key ] === '' ){
      $response[ $key ] = "Необходимо заполнить поле {$value}";
      continue;
    }
    $newVal = $model->validate( $_POST[ $key ]);
    if ($key === 'email' && ! $model ::clean_email( $newVal ) ) {
    $response [ $key ] = "Адрес электронной почты указан некорректно.";
    continue;
    }
    $model->$key = $newVal;
  }
  if (empty( $response)){
    $model->save();
    $response['status'] = true;
  } else {
  $response ['status'] = false;
}
echo json_encode( $response );
}
}
