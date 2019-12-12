<!DOCTYPE html>
<html>
<head>
<style type="text/css">
.btn-uni {
     background-color: #b1c2df;
     -moz-border-radius: 5px;
     -webkit-border-radius: 5px;
     border-radius: 6px;
     color: #fff;
     font-family: 'Oswald';
     font-size: 20px;
     text-decoration: none;
     border: none;
     height: 46px;
     width: 100px;
}
.btn-uni:hover {
     border: none;
     background: #39352e;
     box-shadow: 0px 0px 1px #777;
}
#uploadData {
    background-color: #fbe5d6;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    border-radius: 6px;
    color: #000;
    font-family: 'Oswald';
    font-size: 20px;
    text-decoration: none;
    border: none;
    height: 46px;
}
#uploadData:hover {
     border: none;
     background: #39352e;
     box-shadow: 0px 0px 1px #777;
     color:#fff;
}
#uploadDataRow {
    text-align: center;
}
.result{
    text-align: center;
    background-color: #b1c2df;
    padding-top: 20px;
    padding-bottom: 20px;
    border: black 1px solid;
}
table { 
    border-collapse: collapse; 
    width: 100%; 
} 
th, td { 
    text-align: left; 
    padding: 8px; 
    vertical-align: baseline;
} 
tr:nth-child(even) { 
    background-color: #fbe5d6; 
} 
tr:nth-child(odd) { 
    background-color: #b1c2df; 
}
.phone-field {
    height: 40px;
    border-radius: 6px;
    width: 30%;
    border-color: #661313;
    border-bottom-color: #661313;
    margin-top: 10px;
    margin-bottom: 10px;
}
.inner-field{
    height: 40px;
    border-radius: 6px;
    width: 80%;
    border-color: #661313;
    border-bottom-color: #661313;
    margin-top: 10px;
    margin-bottom: 10px;
}
::placeholder {
    font-size: 18px;
    text-align: center;
}
</style>
</head>
  <body>
<?php $phone_number = ''; ?>
    <div class="container" style="border: 1px solid black;">
        <center>
            <form method="POST" action="">
                <input type="text" name="phone" value="<?php echo $phone_number; ?>" Placeholder="Enter your phone number here" class="phone-field" id='phone-id' required />
                <input type="submit" name="submit" id="submit" class="btn-uni" value="Download"/>
                <input type="button" name="upload" id="upload" class="btn-uni" value="Upload" style="display:none;" onclick ="uploadData()"/>
                <input type="button" name="next" id="next" class="btn-uni" value="Next" style="display:none;" onclick ="nextData()"/>
            </form>
        </center>
    </div>    
    <?php 
    function invenDescSort($item1,$item2)
    {
        if ($item1['1'] == $item2['1']) return 0;
        return ($item1['1'] < $item2['1']) ? 1 : -1;
    }
    if(isset($_POST['submit']))
    {
        $postData= $_POST['phone'];
        $phone_number = $_POST['phone'] ;
        $url='https://u7xe5pw6fg.execute-api.us-east-1.amazonaws.com/prod/downloadplusonemasterdataapi?PHONE='.$postData; 
        /*open connection*/
        $ch = curl_init();
        /*set the url*/ 
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'x-api-key: xBJaCoOftR6nfkhKmywjC98b4rKD9lo08asNt1u4',
            'Content-Type: application/json',
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        $result = curl_exec($ch);     
        $resultData=json_decode($result);
        // echo '<pre>';
        // print_r($resultData);
    }
    
    if(isset($_POST['uploadData']))
    {
        $phone_number = $_POST['phonenumber'];
        $phonenumber=$_POST['phonenumber'];
        $m_name=urlencode($_POST['m_name']);
        $m_adjustment=urlencode(trim($_POST['m_adjustment']));
        $m_retail=urlencode($_POST['m_retail']);
        $m_categories=$_POST['m_categories'];
        $m_note=urlencode($_POST['m_note']);
        $m_categories = urlencode($m_categories);
        $input='INPUT='.$phonenumber.'~$~'.$m_name.'~$~+'.$m_adjustment.'~$~'.$m_retail.'~$~'.$m_categories.'~$~'.$m_note;
        $url='https://u7xe5pw6fg.execute-api.us-east-1.amazonaws.com/prod/uploadplusonemasterdataapi?'.$input;
        //die();
        $ch = curl_init();
    
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'x-api-key: xBJaCoOftR6nfkhKmywjC98b4rKD9lo08asNt1u4'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        $uploadResult = curl_exec($ch);
        $uploadResultData=json_decode($uploadResult);
       // print_r($uploadResultData);
                
        if($uploadResultData->STATUS=='SUCCESS')
        {
            $phone_number = $_POST['phonenumber'] ;
            $url='https://u7xe5pw6fg.execute-api.us-east-1.amazonaws.com/prod/downloadplusonemasterdataapi?PHONE='.$phone_number; 
            /*open connection*/
            $ch = curl_init();
            /*set the url*/ 
            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'x-api-key: xBJaCoOftR6nfkhKmywjC98b4rKD9lo08asNt1u4',
                'Content-Type: application/json',
            ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            $result = curl_exec($ch);     
            $resultData=json_decode($result);
            //echo "Data has been uploaded successfully";
        }
        else
        {
            echo "Data not uploaded successfully";
        }
    }
    if(isset($_POST['nextData']))
    {
        $phone_number = urlencode($_POST['phonenumber']) ;  
        $phonenumber=urlencode($_POST['phonenumber']);
        $m_name=urlencode($_POST['m_name']);
        $m_adjustment=urlencode(trim($_POST['m_adjustment']));
        $m_retail=urlencode($_POST['m_retail']);
        $m_categories=urlencode($_POST['m_categories']);
        $m_note=urlencode($_POST['m_note']);
   
        $input='INPUT='.$phonenumber.'~$~'.$m_name.'~$~'.$m_adjustment.'~$~'.$m_retail.'~$~'.$m_categories.'~$~'.$m_note;
        
        $url='https://u7xe5pw6fg.execute-api.us-east-1.amazonaws.com/prod/nextplusone-masternumber-details-lambda?'.$input;
       // https://u7xe5pw6fg.execute-api.us-east-1.amazonaws.com/prod/nextplusone-masternumber-details-lambda?INPUT=
        //die();
        /*open connection*/
        $ch = curl_init();
        /*set the url*/ 
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'x-api-key: xBJaCoOftR6nfkhKmywjC98b4rKD9lo08asNt1u4',
            'Content-Type: application/json',
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        $result = curl_exec($ch);     
        $resultData=json_decode($result);
    }
    
    if($resultData)
    {
        if(!$resultData->errorMessage){
    ?>
    
    <table border='1px' cellpadding='0' cellspacing='0'>
        <form method="post" action="">
        <input type="submit" name="uploadData" id="uploadData" value="Upload Result" style="display:none;"/>
      <tr>
          <td>phonenumber</td>
          <td>m_name</td>
          <td>m_score</td>
          <td>m_adjustment</td>
          <td>m_retail</td>
          <td>m_rank</td>
          
      </tr>
      <tr>
          <td><?php echo $resultData->phonenumber; ?></td>
          
          <td><input type='text' id='m_name' class="inner-field" name='m_name' value= '<?php echo $resultData->m_name; ?>'/></td>
          <td><?php echo $resultData->m_score; ?></td>
          <td>
              <input type='text' name='m_adjustment' class="inner-field" value= '<?php echo $resultData->m_adjustment; ?>'/>
              <input type='hidden' id='phonenumber' class="inner-field" name='phonenumber' value= '<?php echo $resultData->phonenumber; ?>'/>
              </td>
          <td>
             <?php
                if($resultData->m_retail=='-')
                {
                    echo "<input type='text' name='m_retail' class='inner-field' value= '$resultData->leg_retail'/>";
                }
                else
                {
                    echo "<input type='text' name='m_retail' class='inner-field' value= '$resultData->m_retail'/>";
                }
            ?>
          </td>
          <td><?php echo $resultData->m_rank; ?></td>
          
      </tr>
      <tr>
          <td>m_categories</td>      
          <td>leg_numeric_score</td>
          <td>leg_adj_frequency</td>
          <td>leg_alpha_score</td>
          <td>leg_retail</td>
          <td>leg_rank</td>
          
      </tr>
      <tr>
          <td><input type='text' name='m_categories' class="inner-field" value= '<?php echo $resultData->m_categories; ?>'/></td>      
          <td><?php echo $resultData->leg_numeric_score; ?></td>
          <td><?php echo $resultData->leg_adj_frequency; ?></td>
          <td><?php echo $resultData->leg_alpha_score; ?></td>
          <td><?php echo $resultData->leg_retail; ?></td>
          <td><?php echo $resultData->leg_rank; ?></td>
          
      </tr>
      <tr>
          <td>m_note</td>      
          <td>log_score</td>
          <td>844_score</td>
          <td>855_score</td>
          <td>TWI</td>
          <td>PAR</td>
      </tr>
      <tr>
        <td><input type='text' name='m_note' class='inner-field' value= '<?php echo $resultData->m_note; ?>'/></td>     
          <td><?php echo $resultData->log_score; ?></td>
          <td><?php $key844 = '844_score'; echo $resultData->$key844; ?></td>
          <td><?php $key855_score='855_score'; echo $resultData->$key855_score; ?></td>
          <td>
          <?php
          if(is_array($resultData->twi))
          {
            usort($resultData->twi,'invenDescSort');
            $resArrTwi = $resultData->twi;
              foreach($resArrTwi as $twiData)
              {
          ?>
                   <div> <?php echo $twiData['1']; ?>
                    <?php echo $twiData['0']; ?></div>
                    <br>
          <?php
              }
          }
          ?>           
          </td>
          <td >
          <?php
          if(is_array($resultData->par))
          {
            usort($resultData->par,'invenDescSort');
            $resArrPar = $resultData->par;
              foreach($resArrPar as $parData)
              {
          ?>
                    <div><?php echo $parData['1']; ?>
                    <?php echo $parData['0']; ?></div>
                    <br>
          <?php
              }
          }
          ?> 
          </td>
          
      </tr>
      <tr>
          <td colspan="2">TMS</td>
          <td colspan="2">COM</td>
          <td colspan="2">DOM</td>
      </tr>
      <tr>
          <td colspan="2">
          <?php
          if(is_array($resultData->tms))
          {
            usort($resultData->tms,'invenDescSort');
            $resArrTms = $resultData->tms;
              foreach($resArrTms as $tmsData)
              {
          ?>
                    <div><?php echo $tmsData['1']; ?>
                    <?php echo $tmsData['0']; ?></div>
                    <br>
          <?php
              }
          }
          ?>
          </td> 
          <td colspan="2">
          <?php
          if(is_array($resultData->com))
          {
            usort($resultData->com,'invenDescSort');
            $resArrCom = $resultData->com;
              foreach($resArrCom as $comData)
              {
          ?>
                    <div><?php echo $comData['1']; ?>
                    <?php echo $comData['0']; ?></div>
                    <br>
          <?php
              }
          }
          ?>
          </td>
          <td colspan="2">
             <?php
          if(is_array($resultData->dom))
          {
            usort($resultData->dom,'invenDescSort');
            $resArrDom = $resultData->dom;
              foreach($resArrDom as $domData)
              {
          ?>
                    <div><?php echo $domData['1']; ?>
                    <?php echo $domData['0']; ?>
                    <?php echo $domData['2']; ?></div>
                    <br>
          <?php
              }
          }
          ?> 
          </td>
      </tr>
     </form> 
    </table>
     <form method="post" action="">
        <input type="submit" name="nextData" id="nextData" value="Next Result" style="display:none;"/>
        <input type='hidden' name='phonenumber' value="<?php echo $resultData->phonenumber; ?>" >
        <input type='hidden' name='m_name'  value="<?php echo $resultData->m_name; ?>">
        <input type='hidden' name='m_adjustment'  value="<?php echo $resultData->m_adjustment; ?>">
        <input type='hidden' name='m_retail'  value="<?php echo $resultData->m_retail; ?>">
        <input type='hidden' name='m_categories'  value="<?php echo $resultData->m_categories; ?>">
        <input type='hidden' name='m_note'  value="<?php echo $resultData->m_note; ?>">
    
    </form>
<?php
}
    }
?>

  </body>
<script language="javascript" type="text/javascript">
  var elementExists = document.getElementById("m_name");
 
  if(elementExists){
        document.getElementById("upload").style.display = "inline-block";
        document.getElementById("next").style.display = "inline-block";
        elementExists.focus();
  }
  function uploadData(){
      document.getElementById("uploadData").click();
  }
  function nextData(){
      document.getElementById("nextData").click();
  }
</script>
</html>      