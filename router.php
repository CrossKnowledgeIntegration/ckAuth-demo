<?php

/*
	Router class
	Author: Julien Chomarat @ Crossknowledge
	Project: https://github.com/CrossKnowledgeIntegration/ckAuth-demo

    This class is the router for incoming web service. It allows to keep URL simple

	This software is provided "AS IS" - Licence MIT (https://opensource.org/licenses/MIT)
*/

require_once("proxy.php");

function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
}

function endsWith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
}

if (endsWith($_SERVER["REQUEST_URI"], "/validate/") && $_SERVER["REQUEST_METHOD"] === "POST")
{
    $args = json_decode(file_get_contents("php://input"));
    $proxy = new proxy();
    return $proxy->validate($args);
}
else
{
    return false;
}
?>