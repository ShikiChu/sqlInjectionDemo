<?php

 function getPDO()
{
    $dbConnection = parse_ini_file("DBConnection.ini"); //read the ini file
    extract($dbConnection);
    return new PDO($dsn, $scriptUser, $scriptPassword);  // create the PDO obj
}

function getUserByIdAndPassword($studentID, $password)
{
    $pdo = getPDO();
    
    // with prepared code: 

//    $sql = "SELECT StudentId, Name, Phone FROM Student WHERE StudentId = :studentID AND Password = :password";
//    $stmt = $pdo->prepare($sql);
//    $stmt->execute(['studentID' => $studentID, 'password' => $password]);
//    $row = $stmt->fetch(PDO::FETCH_ASSOC);
//    if ($row)
//    {
//        return new User($row['StudentId'], $row['Name'], $row['Phone'] ); 
//    }
//    return null;

    // not secured code : 
    // inject code : ' or '1' = '1
    $sql = "SELECT StudentId, Name, Phone FROM Student WHERE StudentId = '$studentID' AND Password = '$password'";

    $resultSet = $pdo->query($sql);

    if ($resultSet)  // if the sql statement is valid 
    {
        $row = $resultSet->fetch(PDO::FETCH_ASSOC);
        if ($row)
        {
          return new User($row['StudentId'], $row['Name'], $row['Phone'] );            
       }
      else
       {
          return null;
      }
  }
  else
  {
        throw new Exception("Query failed! SQL statement: $sql");
    }
}