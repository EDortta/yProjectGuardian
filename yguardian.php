<?php
/*
   yguardian.php
   
   .htaccess need to be as follows:
      RewriteEngine on 
      Options +FollowSymlinks
      RewriteBase / 
      RewriteRule ^check/([A-Za-z0-9\-\_]+)\/([A-Za-z0-9]+) rest.php?s=yguardian&a=check&project=$1&license=$2 

 */


  function em_yguardian($a, $values=null) {
    global $userContext, $sysDate, $u,
           $userMsg, $xq_start, $xq_requestedRows,
           $devSession;

    /* numer of rows to limit queries result
       By Default 20
       proposed interface.js (in future yinterface.js) use this
       in order to generare pages */
    $xq_requestedRows=max(1,isset($xq_requestedRows)?intval($xq_requestedRows):20);
    /* return set.
       Could be an array or an SQL statement */
    $ret=null;

    /* publish query variables as local variables */
    extract(xq_extractValuesFromQuery());

    /* publish SOAP parameters as local variables */
    if (($values) && is_array($values)) {
      extract($values);
    }
    $xq_start=isset($xq_start)?intval($xq_start):0;

    /* process the events */
    switch($a)
    {
      case 'check':
        $ret = array(
          'project'=>$project
        );

        if (file_exists("../prod-versions/$project.ver")) {
          $ret['version'] = @file_get_contents("../prod-versions/$project.ver");

          if (file_exists("../prod-versions/$project.def")) {
            $versionDef = @file_get_contents("../prod-versions/$project.def");
            if ($versionDef) {
              $appName             = $versionDef['APP_NAME'];
              $ret['app_name']     = $appName;
              $ret['versionLabel'] = $versionDef[$appName."_VERSION_LABEL"];
              $ret['versionDate']  = $versionDef[$appName."_VERSION_DATE"];
            }
          }
        } else {
          $ret['error']='Not found';
        }

        break;

    }

    return $ret;
  }

  /*
   * qyguardian is called from client side by YeAPF using _DO() and _QUERY() functions
   * The output is an array called '$ret' that is formatted using xq_produceReturnLines()
   * xq_produceReturnLines() can produce results using columns names or not and it
   * can limit the result set length
   */
  function qyguardian($a)
  {
    /* as in 0.8.60 you dont't need these here, but, they're still present

    global $userContext, $sysDate, $u,
           $fieldValue, $fieldName,
           $userMsg, $xq_start, $xq_requestedRows;
    */

    global $xq_requestedRows;

    $useColNames=true;

    /* call em_yguardian to process the event */
    $ret = em_yguardian($a);

    xq_produceReturnLines($ret, $useColNames, $xq_requestedRows);

  }

  function gyguardian($a)
  {
    global $userContext, $sysDate, $u;

    $ret='';


    /* samples:
    switch($a) {
      case 'dograph':
        // create the image and place it in 'cache' folder
        // after that, you can use it from 'cache' folder
        $ret="<img src='cache/test.svg'>";
        break;
    }
    */

    if ($ret>'')
      echo $ret;

  }

  /*
   * wyguardian is called when service is triggered by a WebSocket or REST
   *   https://en.wikipedia.org/wiki/WebSockets
   *   https://en.wikipedia.org/wiki/REST
   * The result is a JSON formatted as string.
   */

  function wyguardian($a)
  {
    /* call em_yguardian to process the event */
    $ret = em_yguardian($a);

    return jr_produceReturnLines($ret);
  }

  /*
   * ryguardianis called when service is triggered by REST interface
   * The result is a js script with json encoded data
   * if the callback function is not defined, its defaults to restCallBack.
   * If the callback function does not exists on
   * client side, no error happens but a console.log is triggered
   */
  function ryguardian($a)
  {
    $jsonRet=wyguardian($a);
    echo produceRestOutput($jsonRet);
  }

  function soap_yguardian($a, $values)
  {
    return em_yguardian($a, $values);
  }

?>
