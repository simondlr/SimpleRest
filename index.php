<?
include("SimpleRest.php");

//Process the request
$data = SimpleRest::processRequest(); 

/*
The .htaccess file intercepts the request and sends any request to index.php, but it keeps the path that was used. This is then stored in $_SERVER['PATH_INFO']. For example: Say we want to go to: "api.example.com/user/simon", all requests will go to "api.example.com/index.php" instead of going to "api.example.com/user/simon/index.php" (which doesn't exist).
*/

//Listening: Young the Giant - Cough Syrup\\

//This takes the path and puts it into an array so that we can take the parameters and figure out where to go. 
$path = explode('/',$_SERVER['PATH_INFO']);


//This gets rid of any empty paths.
$a_path = array();
foreach($path as $p)
{
	if($p != NULL)
	{
		$a_path[] = $p;
	}
}

//What method has been called?
switch($data->getMethod())  
{  
    //Check what method has been called (GET OR POST).  
    case 'get': 
	//GET is for retrieving any information.
	//Do whatever you want to do with your input.
	//Here is an example:
	if(count($a_path) > 0) //if there are any extra parameters
	{
		$base1 = array_shift($a_path);
		//get the next parameter
		switch($base1)
		{
			case 'user':
				//we want user data.
				if(count($a_path) > 0) //if the request included another parameter
				{

				//get next parameter
				$base2 = array_shift($a_path);
				
				//in most apps, here you will do a search through a database to find the user.
				//for now we will just create a mock user.
				$return = array('user'=>array('id'=>'12345678','name'=>$base2));
					
				}
				else
				{
					//The request looked like this:
					//api.example.com/user
					//This probably is an error and the client needs to be notified.
					
					//If the header was json, it should return something.
					//This is optional. If it is an HTML request, it should ideally not return json.
					if($data->getHttpAccept() == 'json') 
					{
						SimpleRest::sendResponse(404,'','application/json');
					}
				}
				break;
		}
	}	

	//
	
	//If the request was done with json.
        if($data->getHttpAccept() == 'json')  
        {  
            SimpleRest::sendResponse(200, json_encode($return), 'application/json');  
        }  
  
        break;  
    
    case 'post':  
    	
	//When you send a post request it should get the parameters as with the 'get' and udpate something like a database.
        
	default:
		echo "nothing happened";
		
}





?>
