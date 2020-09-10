<?php
use Slim\Http\Request; //namespace
use Slim\Http\Response; //namespace

//include productProc.php file
include __DIR__ . '/../function/productProc.php';

//read requestdb
$app->get('/requestdb', function (Request $request, Response $response, array $arg)
{
    $data = getAllproducts($this->db);
    if(is_null($data)){
        return $this->response->withJson(array('error' => 'no data'), 400);

    }
 return $this->response->withJson(array('data' => $data), 200); 
});

//request table products by condition
$app->get('/products/[{id}]', function ($request, $response, $args){

    $productId = $args['id'];
    if (!is_numeric($productId)) {
    return $this->response->withJson(array('error' => 'numeric paremeter required'), 422);
    }
    $data = getProduct($this->db,$productId);
    if (empty($data)) {
    return $this->response->withJson(array('error' => 'no data'), 404);
   }
    return $this->response->withJson(array('data' => $data), 200);
   });

//insert data
   $app->post('/insertProduct',function(Request $request, Response $response, array $arg)
   {
        $form_data=$request->getParsedBody();
        $data = createProduct($this->db, $form_data);   
    
       if(is_null($data)){
        return $this->response->withJson(array('error' => 'no data'), 400);
    }
        return $this->response->withJson(array('data' => 'data insert successful'), 200); 
   });
   
   //delete row
$app->delete('/products/del/[{id}]', function ($request, $response, $args){

    $productId = $args['id'];
   if (!is_numeric($productId)) {
    return $this->response->withJson(array('error' => 'numeric paremeter required'), 422);
   }
   $data = deleteProduct($this->db,$productId);
   if (empty($data)) {
   return $this->response->withJson(array($productId=> 'is successfully deleted'), 202);};
   });
   
   //put table product. 
$app->put('/products/put/[{id}]', function ($request, $response, $args){
 
    $productId = $args['id'];
    $date = date("Y-m-j h:i:s");
        if (!is_numeric($productId)) {
        return $this->response->withJson(array('error' => 'numeric paremeter required'), 422);
} 
     $form_dat=$request->getParsedBody();
    $data=updateProduct($this->db,$form_dat,$productId,$date);
        //  if ($data <=0)
        return $this->response->withJson(array('data' => 'successfully updated'), 200);
});

  // Assignment 
    //read requestList
    $app->get('/requestList', function (Request $request, Response $response, array $arg)
    { 
        $data = getAllProduct($this->db);
        if (is_null($data)){
        return $this->response->withJson(array('error' => 'NO DATA'), 404); 
        }
    
        return $this->response->withJson(array('LIST OF All DATA' => $data), 200); //display all the product
    });

    //request table products by condition
    $app->get('/data/[{name}]', function ($request, $response, $args){

        $dataName = $args['name'];
        if (is_null($dataName)) {
        return $this->response->withJson(array('error' => 'please enter name'), 422);
      }
        $name = getData($this->db,$dataName);
        if (empty($name)) {
        return $this->response->withJson(array('error' => 'no data'), 404);
   }
        return $this->response->withJson(array('data' => $name), 200);
   });

      //put table product. 
    $app->put('/data/put/[{name}]', function (Request $request, Response $response, array $arg){
 
        $dataName = $arg['name'];
        $date = date("Y-m-j h:i:s");
            if (is_null($dataName)) {
            return $this->response->withJson(array('error' => 'please enter name'), 422);
    } 
         $form_dat=$request->getParsedBody();
        $data=updateData($this->db,$form_dat,$dataName,$date);
        //  if ($data <=0)
        return $this->response->withJson(array('data' => 'successfully updated'), 200);
});



//delete row
$app->delete('/data/del/[{name}]', function ($request, $response, $args){

    $dataName = $args['name'];
   if (!is_string($dataName)) {
    return $this->response->withJson(array('error' => 'please enter name'), 422);
   }
   $data = deleteData($this->db,$dataName);
   if (empty($data)) {
   return $this->response->withJson(array($dataName=> 'is successfully deleted'), 202);};
   });

