<?php
function filter_file($file_name)
{
	//replce space with a hyphen
    $file_name=str_replace(' ','-',$file_name);
	//replace comma with hyphen
    $file_name=str_replace(',','-',$file_name);
	//single an underscore mark with hyphen
	$file_name=str_replace('_','-',$file_name);
	//single quatation mark with no space
    $file_name=str_replace("'",'',$file_name);
	//single %20 with no hyphen
    $file_name=str_replace("%20",'-',$file_name);
	//single percent with no space
    $file_name=str_replace("%",'-',$file_name);
	//single & with no hyphen
    $file_name=str_replace("&",'and',$file_name);
    //single 3 hyphens with 1 hyphen
    $file_name=str_replace('---','-',$file_name);
    //single 2 hyphens with 1 hyphen
    $file_name=str_replace('--','-',$file_name);

    return $file_name;
}

function str_replaceHyphen($text){
    return str_replace(' ','-',$text);
}
?>