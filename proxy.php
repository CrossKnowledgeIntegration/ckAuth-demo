<?php

/*
	Wrapper for web service calls
	Author: Julien Chomarat @ Crossknowledge
	Project: https://github.com/CrossKnowledgeIntegration/ckAuth-demo

	This software is provided "AS IS" - Licence MIT (https://opensource.org/licenses/MIT)
*/

class proxy
{
	private $httpVersion = "HTTP/1.1";
    private $CKAUTH_URL = "https://ckauth.crossknowledge.com/api/learner/authenticate.json?token=";

	// Finalize HTTP response with status code and content type
	private function setHttpHeaders($contentType, $statusCode)
	{		
		$statusMessage = $this -> getHttpStatusMessage($statusCode);		
		header($this->httpVersion. " ". $statusCode ." ". $statusMessage);		
		header("Content-Type:". $contentType);
	}
	
	// Wrapper for all HTTP statuses
	private function getHttpStatusMessage($statusCode)
	{
		$httpStatus = array(
			100 => 'Continue',  
			101 => 'Switching Protocols',  
			200 => 'OK',
			201 => 'Created',  
			202 => 'Accepted',  
			203 => 'Non-Authoritative Information',  
			204 => 'No Content',  
			205 => 'Reset Content',  
			206 => 'Partial Content',  
			300 => 'Multiple Choices',  
			301 => 'Moved Permanently',  
			302 => 'Found',  
			303 => 'See Other',  
			304 => 'Not Modified',  
			305 => 'Use Proxy',  
			306 => '(Unused)',  
			307 => 'Temporary Redirect',  
			400 => 'Bad Request',  
			401 => 'Unauthorized',  
			402 => 'Payment Required',  
			403 => 'Forbidden',  
			404 => 'Not Found',  
			405 => 'Method Not Allowed',  
			406 => 'Not Acceptable',  
			407 => 'Proxy Authentication Required',  
			408 => 'Request Timeout',  
			409 => 'Conflict',  
			410 => 'Gone',  
			411 => 'Length Required',  
			412 => 'Precondition Failed',  
			413 => 'Request Entity Too Large',  
			414 => 'Request-URI Too Long',  
			415 => 'Unsupported Media Type',  
			416 => 'Requested Range Not Satisfiable',  
			417 => 'Expectation Failed',  
			500 => 'Internal Server Error',  
			501 => 'Not Implemented',  
			502 => 'Bad Gateway',  
			503 => 'Service Unavailable',  
			504 => 'Gateway Timeout',  
			505 => 'HTTP Version Not Supported');
		return ($httpStatus[$statusCode]) ? $httpStatus[$statusCode] : $status[500];
	}

	/*
		Authenticate the learners based on his code.
        If the token is valid, this service returns
            * The learner login
            * A unique key to authentify him
            * The instance URL he is attached to
	*/
	public function validate($args)
	{
        $url = $this->CKAUTH_URL . $args->token;
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $data = json_decode(curl_exec($ch));

        if ($data == FALSE)
        {
            $data = new \stdClass; 
            $data->message ="Token failed";
            $this->setHttpHeaders("application/json", 401);
        }
        else
        {
            $this->setHttpHeaders("application/json", 200);
        }

        curl_close($ch);
		echo json_encode($data);
	}
}
?>