<?php  
 require_once '../function/db_connect.php';  
 if(isset($_POST["query"]))  
 {  
      $output = '';  
      $query = "SELECT * FROM siswa WHERE nama LIKE '%".$_POST["query"]."%'";  
      $result = $connect->query($query); 
      $output = '<ul class="list-unstyled">';
	  $ada=$result->num_rows;
      if($ada > 0)  
      {  
           while($row = $result->fetch_assoc())  
           {  
                $output .= '<li>'.$row["nama"].'</li>';  
           }  
      }  
      else  
      {  
           $output .= '<li>Country Not Found</li>';  
      }  
      $output .= '</ul>';  
      echo $output;  
 }  
 ?>  