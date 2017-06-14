<?php
header('Content-Type: text/html; charset=utf-8');
ini_set('max_execution_time', 0);
ini_set('display_errors',1);
ini_set('error_reporting',2047);
/*
Template Name: crawler
*/
// class SimpleImage {

$fp = file_get_contents(RC_TC_PLUGIN_URL.'views/links.txt');
$link_key = preg_split('/\n|\r\n?/', $fp);

$p = 0;
$jjj = array();
foreach($link_key as $key => $val){

	$name = $val;
	$source = array(
	  'post_title' => $name,      
	  'post_status' => 'publish',                     
	  'post_author' => 1,                              
	  'post_type' => 'movie',                          
	  'tags_input' => $name,  
	);
	$post_id = wp_insert_post($source);	
	$name = '';
	$dsa = str_replace(" ", "+", $val);
  $location = 'https://www.google.ru/search?q='.$dsa.'&newwindow=1&client=safari&rls=en&source=lnms&tbm=isch&sa=X&ved=0ahUKEwiawYPdvJzUAhVC6CwKHd8CAQoQ_AUICigB&biw=1920&bih=1019#q='.$dsa.'&newwindow=1&tbm=isch&tbs=isz:lt,islt:4mp';
 	print '<pre>';
	var_dump($location);
	print '</pre>';	
  $ch = curl_init($location);

  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.0; rv:20.0) Gecko/20100101 Firefox/20.0');
  curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  $data = curl_exec($ch);
  $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);
  $data = str_replace("\r\n","\n",$data);
  $data = explode(" ", $data);
  
foreach($data as $key => $element) {
    $sdasd = $element;
    $sdasdfsdfsd = '/http.+jpg/im';
	preg_match($sdasdfsdfsd, $sdasd, $dfgdfg);
	if(!empty($dfgdfg[0])){
		$jjj[$p] = $dfgdfg[0];
		$p++;

	}
}

$output = $jjj;
$p = 0;
$jjj = [];
$lucky = 0;
foreach($output as $key => $element) {

	$hhh = get_headers($element);
	$size = getimagesize ($element);

		if($hhh[0] == 'HTTP/1.1 200 OK' && $size[0] >= '1920' && $size[0] <= '3840' && $size[1] >= '1080' && $size[1] <= '2160'){
		print '<pre>';
		var_dump($hhh[0]);
		var_dump($element);
		var_dump($size[0]);
		var_dump($size[1]);
		print '</pre>';
		$to = '/var/www/html/images/'.$dsa.$key.'.jpg';
		file_put_contents($to, file_get_contents($element));
		add_post_meta($post_id, 'link', get_site_url().'/images/'.$dsa.$key.'.jpg');	
		print '<pre>';
		echo $key;
		echo "<img src='".get_site_url().'/images/'.$dsa.$key.'.jpg'."'>";
		print '</pre>';	
		$lucky++;
		if($lucky == 30){
			break;
		}
	}

}
	$dsa = '';
}
?>