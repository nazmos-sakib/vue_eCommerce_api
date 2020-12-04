<?php
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST');
    header('Content-Type: application/json');
     
    $res = [];
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        if (!empty($_FILES["fileToUpload"]["name"])) 
        {
            $target_dir = "uploads/";
            if(isset($_GET['tem']))
            {
                $target_dir = "uploads/temp/";
            }
            $image_name = time();
            $extension = strtolower(substr(strrchr($_FILES["fileToUpload"]["name"], '.'), 1));
            $target_file = $target_dir . $image_name .".". $extension;      
            //$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $uploadOk = true;


            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = true;
            } 
            else 
            {
                $uploadOk = false;
                throwError("File is not an image. you sent ". $check["mime"]. " file");
            }

            // Check if file already exists
            if (file_exists($target_file)) 
            {
                $uploadOk = false;
                throwError("Sorry, file already exists.". basename($_FILES["fileToUpload"]["name"]) . " try changing the name of the file");
            }

            // Check file size 5MB
            if ($_FILES["fileToUpload"]["size"] > 5242880) 
            {
                $uploadOk = false;
                $image_uploadErr = ".";
                throwError("Sorry, your file is too large. upload a file less tham 2MB");
            }

            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) 
            {
                $uploadOk = false;
                throwError( "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
                
            }


            if($uploadOk)
            {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
                {
                $res["message"] =  "The file " . basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                $res["uploadedUrl"] = $target_file;
                returnResponse($res["uploadedUrl"], $res["message"]);
                } else {
                    $res["message"] =  "Sorry, there was an error uploading your file.";
                    throwError($res["message"]);
                }
            }
        }
    }
    
    function returnResponse($data, $message)
    {
        //header("Content-Type: application/json");
        $response = json_encode(['response' => ['error'=> false, 'data'=>$data, 'message'=>$message]]);

        echo $response;
        exit;
    }

    function throwError($message)
    {   
        header('Content-Type: application/json');
        $errorMessage = json_encode(["response"=>['error'=> true, "message"=>$message]]);
        echo $errorMessage;
        exit;
    } 
    
