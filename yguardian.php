<?php
/*      yguardian.php
 *
 *      slotEmptyImplementation.php
 *      This file is part of YeAPF
 *      (Yet Another PHP Framework)
 *      YeAPF 0.8.61-148 built on 2018-11-21 10:19 (0 DST)
 *      Copyright (C) 2004-2018 Esteban Daniel Dortta - dortta@yahoo.com
 *      2018-08-02 21:25:18 (0 DST)
 *
 *
 *      The MIT License (MIT)
 *
 *      Copyright (c) 2016-2018 Esteban D.Dortta
 *
 *      Permission is hereby granted, free of charge, to any person obtaining a copy
 *      of this software and associated documentation files (the "Software"), to deal
 *      in the Software without restriction, including without limitation the rights
 *      to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *      copies of the Software, and to permit persons to whom the Software is
 *      furnished to do so, subject to the following conditions:
 *
 *      The above copyright notice and this permission notice shall be included in all
 *      copies or substantial portions of the Software.
 *
 *      THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *      IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *      FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *      AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *      LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *      OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 *      SOFTWARE.
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

  /* tyguardian is the task event manager
   * The tasks are created using YTaskManager() and called later to be fulfilled.
   * It is called by task.php?s=yeapf&a=tick ou yeapf_ticker.php via cron as this:
   *          wget http://example.com/task.php?s=yeapf&a=tick
   *          OR
   *          /usr/bin/php yeapf_ticker.php
   */
  function tyguardian($a)
  {
    global $sysDate, $ytasker, $xq_start;

    /* publish the task context as local variables:
       xq_start, xq_target, j_params */
    extract($ytasker->getTaskContext());

    /* grants xq_start is a positive integer value */
    $xq_start=isset($xq_start)?intval($xq_start):0;

    switch($a)
    {
      case 'exportTable':
        /*  For example, let's say you need to export a big table called 'invoices'
            When you create the task, you set j_params with 'startDate' and 'endDate'
            All task functionallity depends on $ytasker->taskCanRun() so you need to
            build a loop starting in xq_start and checking $ytasker->taskCanRun()

            $sql="select * from invoices where dueDate>='$startDate' and dueDate<='$endDate' offset $xq_start";
            $q=db_query($sql);
            while (($ytasker->taskCanRun()) && ($d=db_fetch_array($q))) {
              ...
              $xq_start++;
              $ytasker->advanceTo($xq_start);
            }
        */
        break;

      case 'buildList':
        break;

      case 'sendEmail':
        break;
    }


  }
?>
