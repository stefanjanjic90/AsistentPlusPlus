<?php
  
  header('Content-Type=utf-8');

  $data=json_decode(file_get_contents('php://input'));
  
  echo json_encode($data);
?> 
