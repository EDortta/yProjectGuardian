<?php
/*
    includes/yeapf.uuid.php
    YeAPF 0.8.61-148 built on 2018-11-21 10:19 (0 DST)
    Copyright (C) 2004-2018 Esteban Daniel Dortta - dortta@yahoo.com
    2018-11-01 19:45:14 (0 DST)
*/

  /*
   * this function was made public by Andrew Moore at
   * http://php.net/manual/en/function.uniqid.php
   *
   */

  _recordWastedTime("Gotcha! ".$dbgErrorCount++);

  function y_rand($min=0, $max=null) {
    if ($max===null)
      $max=getrandmax();
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
      $t = mt_rand($min, $max);
    } else {
      do {
        $f=fopen("/dev/urandom", "r");
        if ($f)
          break;
        else
         sleep(1);
      } while(true);
      $t=$max / mt_rand(1,64);
      $n=mt_rand(7,21);
      while ($n>0) {
        $n--;
        for($i=0; $i<7; $i++) {
          $x=ord(fread( $f, 1 ));
          $t+=$x;
        }
      }
      fclose($f);
      $t = $min + $t % ($max - $min + 1);
    }
    return $t;
  }


  class UUID {
    public static function v3($namespace, $name) {
      if(!self::is_valid($namespace)) return false;

      // Get hexadecimal components of namespace
      $nhex = str_replace(array('-','{','}'), '', $namespace);

      // Binary Value
      $nstr = '';

      // Convert Namespace UUID to bits
      for($i = 0; $i < strlen($nhex); $i+=2) {
        $nstr .= chr(hexdec($nhex[$i].$nhex[$i+1]));
      }

      // Calculate hash value
      $hash = md5($nstr . $name);

      return sprintf('%08s-%04s-%04x-%04x-%12s',

        // 32 bits for "time_low"
        substr($hash, 0, 8),

        // 16 bits for "time_mid"
        substr($hash, 8, 4),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 3
        (hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x3000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        (hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,

        // 48 bits for "node"
        substr($hash, 20, 12)
      );
    }

    public static function v4() {

      return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

        // 32 bits for "time_low"
        y_rand(0, 0xffff), y_rand(0, 0xffff),

        // 16 bits for "time_mid"
        y_rand(0, 0xffff),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        y_rand(0, 0x0fff) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        y_rand(0, 0x3fff) | 0x8000,

        // 48 bits for "node"
        y_rand(0, 0xffff), y_rand(0, 0xffff), y_rand(0, 0xffff)
      );
    }

    public static function v5($namespace, $name) {
      if(!self::is_valid($namespace)) return false;

      // Get hexadecimal components of namespace
      $nhex = str_replace(array('-','{','}'), '', $namespace);

      // Binary Value
      $nstr = '';

      // Convert Namespace UUID to bits
      for($i = 0; $i < strlen($nhex); $i+=2) {
        $nstr .= chr(hexdec($nhex[$i].$nhex[$i+1]));
      }

      // Calculate hash value
      $hash = sha1($nstr . $name);

      return sprintf('%08s-%04s-%04x-%04x-%12s',

        // 32 bits for "time_low"
        substr($hash, 0, 8),

        // 16 bits for "time_mid"
        substr($hash, 8, 4),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 5
        (hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x5000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        (hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,

        // 48 bits for "node"
        substr($hash, 20, 12)
      );
    }

    public static function is_valid($uuid) {
      return preg_match('/^\{?[0-9a-f]{8}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?'.
                        '[0-9a-f]{4}\-?[0-9a-f]{12}\}?$/i', $uuid) === 1;
    }
  }

  function y_uniqid()
  {
    global $cfgNodePrefix;
    $ret = UUID::v4();
    return $cfgNodePrefix.preg_replace("/[^A-Za-z0-9 ]/", '', $ret);
  }

  function y_sequence_initializer($firstNumber, $segment='', $nodePrefix='') {
    global $cfgNodePrefix, $cfgSegmentPrefix;

    $ret=null;

    if ($nodePrefix=='')
      $nodePrefix = "$cfgNodePrefix";
    if ($segment=='')
      $segment="$cfgSegmentPrefix";

    $cc=db_sql("select count(*) from is_sequence where nodePrefix='$nodePrefix' and segment='$segment'");
    if ($cc==0) {
      db_sql("insert into is_sequence (nodePrefix, segment, seq_value) value('$nodePrefix', '$segment', $firstNumber)");
      $ret=true;
    } else {
      $seq_value = db_sql("select seq_value from is_sequence where nodePrefix='$nodePrefix' and segment='$segment'");
      $ret=($seq_value>=$firstNumber);
    }
    return $ret;
  }

  function y_sequence_enabled($segment='', $nodePrefix='') {
    global $cfgNodePrefix, $cfgSegmentPrefix;

    if ($nodePrefix=='')
      $nodePrefix = "$cfgNodePrefix";
    if ($segment=='')
      $segment="$cfgSegmentPrefix";

    $segment = substr(str_repeat("_", 4).$segment, -4);
    $nodePrefix   = substr(str_repeat("_", 3).$nodePrefix, -3);

    $sequence=db_sql("select seq_value from is_sequence where nodePrefix='$nodePrefix' and segment='$segment'");
    return $sequence>0;
  }

  function y_sequence($segment='', $nodePrefix='')
  {
    /*
        sssCCCC000000nnnnnnnnnnnnnnnnnnn
    theoretical max  9999999999999999999
    real bigint max  9223372036854775807
    */
    global $cfgNodePrefix, $cfgSegmentPrefix;

    $ret=null;
    $erroGrave=false;

    if ($nodePrefix=='')
      $nodePrefix = "$cfgNodePrefix";
    if ($segment=='')
      $segment="$cfgSegmentPrefix";

    $segment = substr(str_repeat("_", 4).$segment, -4);
    $nodePrefix   = substr(str_repeat("_", 3).$nodePrefix, -3);
    $flagName="sequencer-$segment-$nodePrefix";

    if (lock($flagName)) {
      $sequence=db_sql("select seq_value from is_sequence where nodePrefix='$nodePrefix' and segment='$segment'");
      if ($sequence>0) {
        $sequence++;
        db_sql("update is_sequence set seq_value=$sequence where nodePrefix='$nodePrefix' and segment='$segment'");
        $sequence=str_repeat("0", 19-strlen("$sequence")).$sequence;
        $ret=$nodePrefix.$segment."000000".$sequence;
      } else {
        $erroGrave=true;
      }
      unlock($flagName);
    }

    if ($erroGrave) {
      $errMsg="Sequencer not initialized. You're trying to generate a sequencer for '$segment' at '$nodePrefix'. Create an entry at is_sequence table";
      _dump($errMsg);
      throw new Exception($errMsg);
    }

    return $ret;
  }

  mt_srand(mktime()*y_rand(1000,2000));


?>
