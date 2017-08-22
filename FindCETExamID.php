<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>找回四六级准考证号码</title>
    <meta name="description" content="">
    <meta name="keywords" content=""></head>
  
  <body>
    <div class="wrap">
      <div class="container">
        <h1>CET-4、6
          <br>
          <br>准考证号码找回</h1>
        <form method="post" class="form" action="FindCETExamID.php">
          <input type="text" name="name" placeholder="姓名">
          <input type="text" name="id" placeholder="身份证号">
          <select name="type" id="">
            <option value="1">四级</option>
            <option value="2">六级</option></select>
          <input type="submit" class="btn" name="submit" value="找  回"></form>
      </div>
    </div>
  </body>
</html>
<?php
class Candidates{
    var $ks_xm;
    var $ks_sfz;
    var $jb;
    public function __construct($exam_code,$id_number,$types){
        $this->ks_xm = $exam_code;
        $this->ks_sfz = $id_number;
        $this->jb = $types;
    }
}
if (isset($_POST["submit"]) && $_POST["submit"] == "找  回") {
	$ks_data = new Candidates($_POST['name'],$_POST['id'],$_POST['type']);

	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_PORT => "7066",
	  CURLOPT_URL => "http://app.cet.edu.cn:7066/baas/app/setuser.do?method=UserVerify",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => "action=&params=".json_encode($ks_data),
	  CURLOPT_HTTPHEADER => array(
		"accept: */*",
		"cache-control: no-cache",
		"content-type: application/x-www-form-urlencoded;charset=UTF-8",
		"origin: http://app.cet.edu.cn:7066",
		"referer: http://app.cet.edu.cn:7066/baas/app/setuser.do?method=UserVerify",
		"x-requested-with: XMLHttpRequest"
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	$number = json_decode($response)->ks_bh;
	echo("<h2>您的准考证号码为:<br><h1>".$number."</h1></h2>");
}
