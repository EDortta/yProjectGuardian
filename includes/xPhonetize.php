<?php
/*
    includes/xPhonetize.php
    YeAPF 0.8.61-148 built on 2018-11-21 10:19 (0 DST)
    Copyright (C) 2004-2018 Esteban Daniel Dortta - dortta@yahoo.com
    2018-11-02 10:57:10 (0 DST)
*/
  _recordWastedTime("Gotcha! ".$dbgErrorCount++);

  class phonetize {

    var $passNDX=0;
    var $aWord='';
    var $HexaFormat=false;

    var $phoneticRules = array(
      array('y',          0, 0, 'i'),
      array('amy@',       0, 0, 'am'),
      array('onca',       0, 0, 'doca'),
      array('mind',       0, 0, 'mend'),
      array('ingo',       0, 0, 'digo'),
      array('rose%',      0, 0, 'rosi%'),
      array('noel',       0, 0, 'nuel'),
      array('aguina',     0, 0, 'agna'),
      array('edis',       0, 0, 'eds'),
      array('~deividi',   0, 0, 'davi'),
      array('~david',     0, 0, 'davi'),
      array('~dei',       0, 0, 'dai'),
      array('meir?',      0, 0, 'mar?'),
      array('ia%',        0, 0, 'ai??'),
      array('~dion',      0, 0, 'jon'),
      array('tas@',       0, 0, 'tan'),
      array('tam@',       0, 0, 'tan'),
      array('ngt',        0, 0, 'nt'),
      array('hn',         0, 0, 'n'),
      array('sh',         0, 0, 'x'),
      array('ch',         0, 0, 'x'),
      array('chr',        0, 0, 'cr'),
      array('eira',       0, 0, 'era'),
      array('eia',        0, 0, 'ea'),
      array('ean',        0, 0, 'in'),
      array('ang',        0, 0, 'ain'),
      array('ge',         0, 0, 'je'),
      array('ph',         0, 0, 'f'),
      array('th',         0, 0, 't'),
      array('ck',         0, 0, 'c'),
      array('iei',        0, 0, 'ie'),
      array('laire',      0, 0, 'ler'),
      array('~leo',       0, 0, 'lio'),
      array('apt',        0, 0, 'at'),
      array('~p%',        0, 0, '?'),
      array('ti@',        0, 0, 'te'),
      array('eth@',       0, 0, 'ete'),
      array('~uil',       0, 0, 'wil'),
      array('e@',         0, 0, 'a'),
      array('z',          0, 0, 's'),
      array('je',         0, 0, 'ge'),
      array('~giu',       0, 0, 'ju'),
      array('ctor',       0, 0, 'tor'),
      array('~henr',      0, 0, 'enr'),
      array('~he?k',      0, 0, 're?k'),
      array('~hos?',      0, 0, 'ros?'),
      array('qu#@',       1, 1, 'k'),
      array('~apare?id#', 1, 1, 'yapd'),
      array('~cid#',      1, 1, 'yapd'),
      array('~cidinh#',   1, 1, 'yapd'),
      array('~ap.',       1, 1, 'yapd'),
      array('%ia%',       2, 2, '?ya'),
      array('~ele',       2, 2, 'hele'),
      array('ao@',        0, 0, 'an'),
      array('ão',         0, 0, 'an'),
      array('ã@',         0, 0, 'an'),
      array('nh',         0, 0, 'n'),
      array('w',          0, 0, 'v'),
      array('k',          0, 0, 'c'),
      array('y',          0, 0, 'i'),
      array('ç',          0, 0, 'c'),
      array('ñ',          0, 0, 'n'),
      array('h',          0, 0, ''),
      array('ss',         0, 0, 'c')
    );

    function delete(&$str, $pos, $len)
    {
      if ($len>0) {
        $str=substr($str,0,$pos).substr($str,$pos+$len,strlen($str));
      }
      return $str;
    }

    function insert($toInsert, &$target, $pos)
    {
      $target=substr($target,0,$pos).$toInsert.substr($target,$pos);
      return $target;
    }

    function is_vocal($char)
    {
      $p=0;
      if ($char>'') {
        $char=strtolower($char);
        $p=(strpos(' aeiou',$char)>0)*1;
      }
      return $p;
    }

    function isGoodPosition($phonemNDX, &$p)
    {
      $x=$i=$off=0;

      $res=0;

      if (substr($this->phoneticRules[$phonemNDX][0],0,1)=='~') {
        $off=-1;
        $x=1;
      } else {
        $off=0;
        $x=0;
      }

      $canGo=true;

      if ($off<0)
        if ($p>1)
          $canGo=false;

      if ($canGo) {
        if (($this->passNDX<$this->phoneticRules[$phonemNDX][1]) or ($this->passNDX>$this->phoneticRules[$phonemNDX][2]))
          $canGo=false;
      }

      if ($canGo) {
        for ($i=-$off; $i<strlen($this->phoneticRules[$phonemNDX][0]); $i++) {
          if (($p+$i+$off)>strlen($this->aWord)) {
            if (substr($this->phoneticRules[$phonemNDX][0],$i,1)=='@') {
              $x++;
              break;
            }
          }
          $prs=substr($this->phoneticRules[$phonemNDX][0],$i,1);
          switch ($prs) {
            case '@':
              $x=$x+(($p+$i+$off==strlen($this->aWord))*1);
              break;
            case '?':
              $x++;
              break;
            case '#':
              $wpio=substr($this->aWord,$p+$i+$off,1);
              if ($this->is_vocal($wpio))
                $x++;
              break;
            case '%':
              $wpio=substr($this->aWord,$p+$i+$off,1);
              if (!$this->is_vocal($wpio))
                $x++;
              break;
            default:
              $ch=substr($this->aWord,$p+$i+$off,1);
              $pr=substr($this->phoneticRules[$phonemNDX][0],$i,1);
              if ($ch==$pr)
                $x++;
              break;
          }
        }

        if ($x==strlen($this->phoneticRules[$phonemNDX][0]))
          $res=1;
      }
      return $res;
    }

    function phonemPosition($phonemNDX)
    {
      $p=0;
      $res=-1;
      $p=0;
      while ($p<strlen($this->aWord) and ($this->isGoodPosition($phonemNDX, $p)==0))
        $p++;
      if ($p<strlen($this->aWord))
        $res=$p;
      return $res;
    }

    function lenSpecChars($s)
    {
      $i=$res=0;
      while ($i<strlen($s)) {
        $ss=substr($s,$i,1);
        if (!(($ss=='~') or ($ss=='@')))
          $res++;
        $i++;
      }
      return $res;
    }

    function resultRule($aRule, $aPos)
    {
      $xSubstLetters='';
      $n=$i=0;
      $s=$t='';

      $s=$this->phoneticRules[$aRule][0];
      $t=$this->phoneticRules[$aRule][3];

      $i=0;
      while ($i<strlen($s)) {
        $ss=substr($s,$i,1);
        if (($ss=='~') or ($ss=='@'))
          $this->delete($s,$i,1);
        else
          $i++;
      }

      for ($i=0; $i<strlen($s); $i++) {
        $sc=substr($s,$i,1);
        $scp=strpos(' ?%#',$sc);
        if ($scp>0)
          $xSubstLetters.=substr($this->aWord, $i+$aPos, 1);
      }

      $n=0;
      for ($i=0; $i<strlen($t); $i++) {
        if ((substr($t,$i,1)=='?') and ($n<strlen($xSubstLetters))) {
          $t=substr($t,0,$i-1).substr($xSubstLetters,$n,1).substr($t,$i+1,strlen($t));
          $n++;
        }
      }

      return $t;
    }


    function substPhonems()
    {
      $i=$j=0;
      $t='';

      for ($i=0; $i<count($this->phoneticRules); $i++) {
        $j=$this->phonemPosition($i);
        while ($j>=0) {
          $t=$this->resultRule($i,$j);
          $s=$this->phoneticRules[$i][0];
          $this->delete($this->aWord,$j,$this->lenSpecChars($s));
          $this->insert($t, $this->aWord,$j);
          $j=$this->phonemPosition($i);
        }
      }
      $this->passNDX++;
    }

    function codifica($s, $tabela)
    {
      $res='';
      for ($i=0; $i<strlen($s); $i++) {
        $j=0;
        while (($j<count($tabela)) && (strpos($tabela[$j],substr($s,$i,1))===false))
          $j++;
        $res.=chr($j+48);
      }

      return $res;
    }

    function charsToNum($word)
    {
      $t0 = array('adg','jmp','sxz','beh','knq','tyu','cfi','lor','w');
      $t1 = array('qweita', 'rhkdf', 'luop', 'zscvb', 'nmjxg','y');

      $res=substr($word,0,1).$this->codifica(substr($word,1,1),$t0).$this->codifica(substr($word,2,strlen($word)),$t1);

      if ($this->HexaFormat) {
        while ((strlen($res)-1) % 2 > 0) {
          $res=substr($res,0,1).'0'.substr($res,1);
        }

        $h=substr($res,0,1);
        for($i=1; $i<strlen($res) / 2; $i++) {
          $k=str_pad(dechex(intval(substr($res,$i*2-1,2))),2,'0',STR_PAD_LEFT);
          $h.=$k;
        }

        $res=$h;
      }

      return $res;
    }

    function eliminarLetrasDuplicadas()
    {
      $res='';
      $la='';
      for($i=0; $i<strlen($this->aWord); $i++) {
        $letra=substr($this->aWord,$i,1);
        if ($letra!=$la)
          $res.=$letra;
        $la=$letra;
      }
      $this->aWord=$res;
    }

    function eliminarAcentuadas()
    {    
      /*   
      $a=' áéíóúàèìòùãõâêîôûäëïöüÁÉÍÓÚÀÈÌÒÙÃÕÂÊÎÔÛÄËÏÖÜ';
      $b=' aeiouaeiouaoaeiouaeiouAEIOUAEIOUAOAEIOUAEIOU';

      $res='';
      for ($i=0; $i<strlen($this->aWord); $i++) {
        $letra=substr($this->aWord,$i,1);
        $p=strpos($a,$letra);
        if ($p>0)
          $letra=substr($b,$p,1);
        $res.=$letra;
      }
      */

      $toDebug=false;

      $search = explode(",","ñ,Ñ,ç,õ,Õ,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,ø,Ø,Å,Á,À,Â,Ä,È,É,Ê,Ë,Í,Î,Ï,Ì,Ò,Ó,Ô,Ö,Ú,Ù,Û,Ü,Ÿ,Ç,Æ,Œ");
      $replace = explode(",","n,N,c,o,O,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,o,O,A,A,A,A,A,E,E,E,E,I,I,I,I,O,O,O,O,U,U,U,U,Y,C,AE,OE");

      if ($toDebug) echo "[ $this->aWord -> ";
      $res=str_replace($search, $replace, $this->aWord);
      if ($toDebug) echo " $res -> ";
      $res=(mb_strtolower($res));
      if ($toDebug) echo " $res ] ";

      $this->aWord=mb_convert_encoding(mb_strtolower($res), "ASCII");
    }

    function doPhonetize()
    {
      // eliminamos acentuações
      $this->eliminarAcentuadas();
      // pegamos só as letras
      /* $this->aWord=ereg_replace("[^A-Z,^a-z]", "", $this->aWord);*/
      $this->aWord=preg_replace("/[^A-Z,^a-z]/", "", $this->aWord);
      if ($this->aWord>'') {
        $this->passNDX=0;
        // erros de digitação mais comuns
        $this->substPhonems();
        $this->eliminarLetrasDuplicadas();
        // simplificação de erros menos comuns e sobra da simplificação anterior
        $this->substPhonems();
        // elimino fonemas após redução
        $this->substPhonems();
      }
      return $this->aWord;
    }

    public function __construct($phrase, &$encodedWord, $hexFormat=true) {
      $this->HexaFormat=$hexFormat;

      $res='#';
      $words=explode(' ',$phrase);
      $encodedWord='#';
      foreach($words as $w) {
        $this->aWord=$w;
        $phonetizedWord=$this->doPhonetize();

        if ($phonetizedWord>'') {
          $encodedWord.=$this->charsToNum($phonetizedWord);
          $res.=$phonetizedWord;

          $encodedWord.='#';
          $res.='#';          
        }

      }
      $this->result="$res";      
    }

    function phonetize($phrase, &$encodedWord, $hexFormat=true)
    {
      self::__construct($phrase, $encodedWord, $hexFormat);
    }
  }


  function testarFonetizador()
  {
    $palavra='rosiclaire chico alexandre alessandro alezandra';
    $palavra='ÔNIBUS ÓNIBUS ONIBUS';

    $teste = new phonetize($palavra,$encoded,true);

    echo "palavra=$palavra<br>$teste->result<br>encoded=$encoded<br>";
  }
?>
