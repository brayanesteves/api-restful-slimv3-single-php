<?php

    /**
     * Get error
     */
    ini_set('display_errors', 1);
    $configuration = [
        'settings' => [
            'displayErrorDetails' => true,
        ],
    ];
    $c = new \Slim\Container($configuration);
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;

    $app = new \Slim\App($c);

    /**
     * GET
     */

     /**
      * Get all record
      */
    $app->get('/api/users_', function(Request $request, Response $response) {
        $sql = "SELECT * FROM `0_usrs`";
        try {
            $db = new db();
            $db = $db->connectionDB();
            $result = $db->query($sql);

            if($result->rowCount() > 0) {
                $usrs = $result->fetchAll(PDO::FETCH_OBJ);
                echo json_encode($usrs);
            } else {
                echo json_encode("No exists users");
            }
            
            $result = null;
            $db = null;
        } catch(PDOException $e) {
            echo '{"error": {"text"' . $e->getMessage() . '}';
        }
    });

    /**
     * GET
     * Get specific record
     */

    $app->get('/api/users_/{Rfrnc}', function(Request $request, Response $response) {
        $Rfrnc = $request->getAttribute('Rfrnc');
        $sql = "SELECT * FROM 0_usrs WHERE Rfrnc = '$Rfrnc' OR `Usrnm` = '" . $Rfrnc . "';";
        try {
            $db = new db();
            $db = $db->connectionDB();
            $result = $db->query($sql);
            if($result->rowCount() > 0) {
                $usrs = $result->fetchAll(PDO::FETCH_OBJ);
                echo json_encode($usrs);
            } else {
                echo json_encode("No exists users");
            }
            $result = null;
            $db = null;
        } catch(PDOException $e) {
            echo '{"error": {"text"' . $e->getMessage() . '}';
        }
    });

    /**
     * POST
     */

    $app->post('/api/users', function(Request $request, Response $response) {
        $sql = "SELECT * FROM `0_usrs`";
        try {
            $db = new db();
            $db = $db->connectionDB();
            $result = $db->query($sql);

            if($result->rowCount() > 0) {
                $usrs = $result->fetchAll(PDO::FETCH_OBJ);
                echo json_encode($usrs);
            } else {
                echo json_encode("No exists users");
            }
            
            $result = null;
            $db = null;
        } catch(PDOException $e) {
            echo '{"error": {"text"' . $e->getMessage() . '}';
        }
    });
    
    /**
     * GET
     * Get specific record
     */

    $app->post('/api/user/{Rfrnc}', function(Request $request, Response $response) {
        $Rfrnc = $request->getAttribute('Rfrnc');
        $sql = "SELECT * FROM 0_usrs WHERE Rfrnc = '$Rfrnc' OR `Usrnm` = '" . $Rfrnc . "';";
        try {
            $db = new db();
            $db = $db->connectionDB();
            $result = $db->query($sql);
            if($result->rowCount() > 0) {
                $usrs = $result->fetchAll(PDO::FETCH_OBJ);
                echo json_encode($usrs);
            } else {
                echo json_encode("No exists users");
            }
            $result = null;
            $db = null;
        } catch(PDOException $e) {
            echo '{"error": {"text"' . $e->getMessage() . '}';
        }
    });
     /**
      * Record data
      */
    $app->post('/api/users/new', function(Request $request, Response $response) {

        $Usrnm        = $request->getParam('Usrnm');
        $Psswrd       = $request->getParam('Psswrd');
        $Rfrnc_Prsn   = $request->getParam('Rfrnc_Prsn');
        $UsrTyp_Rfrnc = $request->getParam('UsrTyp_Rfrnc');
        $Cndtn        = 1;
        $Rmvd         = 0;
        $Lckd         = 0;
        $DtAdmssn     = date('Y-m-d');
        $ChckTm       = date('H:i:s');

        
        $verify = "SELECT * FROM `0_usrs` WHERE `Usrnm` = '$Usrnm';";

        try {
            $db     = new db();
            $db     = $db->connectionDB();

            $validate = $db->query($verify);

            if($validate->rowCount() == 0) {

                $sql   = "INSERT INTO `0_usrs` (`Usrnm`, `Psswrd`, `Rfrnc_Prsn`, `UsrTyp_Rfrnc`, `Cndtn`, `Rmvd`, `Lckd`, `DtAdmssn`, `ChckTm`) VALUES(:Usrnm, :Psswrd, :Rfrnc_Prsn, :UsrTyp_Rfrnc, :Cndtn, :Rmvd, :Lckd, :DtAdmssn, :ChckTm);"; 
                $result = $db->prepare($sql);
        
                $result->bindParam(':Usrnm', $Usrnm);
                $result->bindParam(':Psswrd', $Psswrd);
                $result->bindParam(':Rfrnc_Prsn', $Rfrnc_Prsn);
                $result->bindParam(':UsrTyp_Rfrnc', $UsrTyp_Rfrnc);
                $result->bindParam(':Cndtn', $Cndtn);
                $result->bindParam(':Rmvd', $Rmvd);
                $result->bindParam(':Lckd', $Lckd);
                $result->bindParam(':DtAdmssn', $DtAdmssn);
                $result->bindParam(':ChckTm', $ChckTm);
        
                $result->execute();
        
                echo json_encode("Users save");
        
                $result = null; 

            } else {
                echo json_encode("Users exist");
            }
            
            $db = null;
        } catch(PDOException $e) {
            echo '{"error": {"text"' . $e->getMessage() . '}';
        }
    });

    $app->post('/api/users/edit/{Rfrnc}', function(Request $request, Response $response) {

        $Rfrnc        = $request->getAttribute('Rfrnc');

        $Usrnm        = $request->getParam('Usrnm');
        $Psswrd       = $request->getParam('Psswrd');
        $Rfrnc_Prsn   = $request->getParam('Rfrnc_Prsn');
        $UsrTyp_Rfrnc = $request->getParam('UsrTyp_Rfrnc');
        $Cndtn        = $request->getParam('Cndtn');
        $Rmvd         = $request->getParam('Rmvd');
        $Lckd         = $request->getParam('Lckd');

        $sql = "UPDATE `0_usrs` SET `Usrnm` = :Usrnm, `Psswrd` = :Psswrd, `Rfrnc_Prsn` = :Rfrnc_Prsn, `UsrTyp_Rfrnc` = :UsrTyp_Rfrnc, `Cndtn` = :Cndtn, `Rmvd` = :Rmvd, `Lckd` = :Lckd WHERE `Rfrnc` = :Rfrnc;";
        
        try {
            $db     = new db();
            $db     = $db->connectionDB();            
            $result = $db->prepare($sql);
            
            $result->bindParam(':Rfrnc', $Rfrnc);
            $result->bindParam(':Usrnm', $Usrnm);
            $result->bindParam(':Psswrd', $Psswrd);
            $result->bindParam(':Rfrnc_Prsn', $Rfrnc_Prsn);
            $result->bindParam(':UsrTyp_Rfrnc', $UsrTyp_Rfrnc);
            $result->bindParam(':Cndtn', $Cndtn);
            $result->bindParam(':Rmvd', $Rmvd);
            $result->bindParam(':Lckd', $Lckd);
            
            $result->execute();
            echo json_encode("Users edit");

            $result = null;
            $db = null;
        } catch(PDOException $e) {
            echo '{"error": {"text"' . $e->getMessage() . '}';
        }
    });

    $app->post('/api/users/delete/{Rfrnc}', function(Request $request, Response $response){
        $Rfrnc = $request->getAttribute('Rfrnc');
        $sql   = "DELETE FROM `0_usrs` WHERE `Rfrnc` = $Rfrnc";
          
       try{
         $db     = new db();
         $db     = $db->connectionDB();
         $result = $db->prepare($sql);
        
         $result->execute();
     
         if ($result->rowCount() > 0) {
           echo json_encode("Record delete.");  
         }else {
           echo json_encode("Reference not exists.");
         }
     
         $result = null;
         $db     = null;
       }catch(PDOException $e){
         echo '{"error" : {"text":'.$e->getMessage().'}';
       }
    }); 

    /**
     * PUT
     */

     /**
      * Edit specific record
      */
    $app->put('/api/users/edit/{Rfrnc}', function(Request $request, Response $response) {

        $Rfrnc        = $request->getAttribute('Rfrnc');

        $Usrnm        = $request->getParam('Usrnm');
        $Psswrd       = $request->getParam('Psswrd');
        $Rfrnc_Prsn   = $request->getParam('Rfrnc_Prsn');
        $UsrTyp_Rfrnc = $request->getParam('UsrTyp_Rfrnc');
        $Cndtn        = $request->getParam('Cndtn');
        $Rmvd         = $request->getParam('Rmvd');
        $Lckd         = $request->getParam('Lckd');

        $sql = "UPDATE `0_usrs` SET `Usrnm` = :Usrnm, `Psswrd` = :Psswrd, `Rfrnc_Prsn` = :Rfrnc_Prsn, `UsrTyp_Rfrnc` = :UsrTyp_Rfrnc, `Cndtn` = :Cndtn, `Rmvd` = :Rmvd, `Lckd` = :Lckd WHERE `Rfrnc` = :Rfrnc;";
        
        try {
            $db     = new db();
            $db     = $db->connectionDB();            
            $result = $db->prepare($sql);
            
            $result->bindParam(':Rfrnc', $Rfrnc);
            $result->bindParam(':Usrnm', $Usrnm);
            $result->bindParam(':Psswrd', $Psswrd);
            $result->bindParam(':Rfrnc_Prsn', $Rfrnc_Prsn);
            $result->bindParam(':UsrTyp_Rfrnc', $UsrTyp_Rfrnc);
            $result->bindParam(':Cndtn', $Cndtn);
            $result->bindParam(':Rmvd', $Rmvd);
            $result->bindParam(':Lckd', $Lckd);
            
            $result->execute();
            echo json_encode("Users edit");

            $result = null;
            $db = null;
        } catch(PDOException $e) {
            echo '{"error": {"text"' . $e->getMessage() . '}';
        }
    });

    /**
     * DELETE
     */

     /**
      * Delete record
      */
    $app->delete('/api/users/delete/{Rfrnc}', function(Request $request, Response $response){
        $Rfrnc = $request->getAttribute('Rfrnc');
        $sql   = "DELETE FROM `0_usrs` WHERE `Rfrnc` = $Rfrnc";
          
       try{
         $db     = new db();
         $db     = $db->connectionDB();
         $result = $db->prepare($sql);
        
         $result->execute();
     
         if ($result->rowCount() > 0) {
           echo json_encode("Record delete.");  
         }else {
           echo json_encode("Reference not exists.");
         }
     
         $result = null;
         $db     = null;
       }catch(PDOException $e){
         echo '{"error" : {"text":'.$e->getMessage().'}';
       }
    }); 

?>