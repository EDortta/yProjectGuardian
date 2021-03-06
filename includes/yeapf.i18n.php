<?php
/*
    includes/yeapf.i18n.php
    YeAPF 0.8.61-148 built on 2018-11-21 10:19 (0 DST)
    Copyright (C) 2004-2018 Esteban Daniel Dortta - dortta@yahoo.com
    2018-08-24 21:24:25 (0 DST)
*/
  _recordWastedTime("Gotcha! ".$dbgErrorCount++);

  $GLOBALS['prepositions'] = array ( 'à',"ao",'a','ante','até','após',
       'com','contra','de','desde','em','entre','para','per','perante',
       'por','sem','sob','sobre','trás');

  $GLOBALS['abbreviations'] = array(
      'ACAD.'=> 'acadêmico',
      'ACADÊM.'=> 'acadêmico',
      'ADV.º'=> 'advogado',
      'ADVO.'=> 'advogado',
      'ALM.'=> 'almirante',
      'ARC.º'=> 'arcebispo',
      'ARCO.'=> 'arcebispo',
      'B.EL'=> 'bacharel',
      'BEL.'=> 'bacharela',
      'B.ELA'=> 'bacharéis',
      'BELA.'=> 'bacharelas',
      'B.ÉIS'=> 'null',
      'BÉIS.'=> 'null',
      'B.ELAS'=> 'null',
      'BELAS.'=> 'null',
      'B.PO'=> 'bispo',
      'BPO.'=> 'bispo',
      'CAP.'=> 'capitão',
      'CARD.'=> 'cardeal',
      'COM.'=> 'comandante',
      'COM.TE'=> 'comandante',
      'COMTE.'=> 'comandante',
      'COM.'=> 'comendador',
      'COMEND.'=> 'comendador',
      'COM.OR'=> 'comendador',
      'COMOR.'=> 'comendador',
      'CÔN.º'=> 'cônego',
      'CÔNO.'=> 'cônego',
      'CONS.'=> 'conselheiro',
      'CONSEL.'=> 'conselheiro',
      'CONSELH.'=> 'conselheiro',
      'CONS.º'=> 'conselheiro',
      'CONSO.'=> 'conselheiro',
      'CONT.DOR'=> 'contador',
      'CONTDOR.'=> 'contador',
      'CONT.OR'=> 'contador',
      'CONTOR.'=> 'contador',
      'C.-ALM.'=> 'contra-almirante',
      'C.EL'=> 'coronel',
      'CEL.'=> 'coronel',
      'DEP.'=> 'deputado',
      'DES.'=> 'desembargador',
      'DES.ª'=> 'desembargadora',
      'DESA.'=> 'null',
      'DIÁC.'=> 'diácono',
      'DD.'=> 'Digníssimo',
      'D.'=> 'Digno',
      'D.ª'=> 'Dona',
      'DA.'=> 'Dona',
      'D.R'=> 'doutor',
      'DR.'=> 'doutores',
      'D.RS'=> 'null',
      'DRS.'=> 'null',
      'D.RA'=> 'doutora',
      'DRA. D.RAS'=> 'doutoras',
      'DRAS.'=> 'null',
      'E.'=> 'editor',
      'EE.'=> 'editores',
      'E.E.P.'=> 'embaixador extraordinário e plenipotenciário',
      'EM.ª'=> 'Eminência',
      'EMA.'=> 'Eminência',
      'EM.MO'=> 'Eminentíssimo',
      'EMMO.'=> 'Eminentíssimo',
      'ENF.'=> 'enfermeiro',
      'ENF.ª'=> 'enfermeira',
      'ENFA.'=> 'null',
      'ENG.'=> 'engenheiro',
      'ENG.º'=> 'engenheira',
      'ENGO.'=> 'null',
      'E.E.M.P.'=> 'enviado extraordinário e ministro plenipotenciário',
      'E.M.'=> 'Estado-Maior',
      'E.-M.'=> 'Estado-Maior',
      'EX.ª'=> 'Excelência',
      'EXA.'=> 'Excelência',
      'EX.MO'=> 'Excelentíssimo',
      'EXMO. EX.MA'=> 'Excelentíssima',
      'EXMA.'=> 'null',
      'GEN.'=> 'general',
      'G.AL'=> 'general',
      'GAL.'=> 'general',
      'IL.MO'=> 'ilustríssimo',
      'ILMO.'=> 'Ilustríssima',
      'IL.MA'=> 'null',
      'ILMA.'=> 'null',
      'M.ME'=> 'madame (francês = senhora)',
      'MME.'=> 'madame (francês = senhora)',
      'M.LLE'=> 'mademoiselle (francês = senhorita)',
      'MLLE.'=> 'mademoiselle (francês = senhorita)',
      'MAJ.'=> 'major',
      'MAJ.-BRIG.'=> 'major-brigadeiro',
      'MAR.'=> 'marechal',
      'M.AL'=> 'marechal',
      'MAL.'=> 'marechal',
      'MÉD.'=> 'médico',
      'MM.'=> 'Meritíssimo',
      'ME'=> 'mestre',
      'ME.'=> 'mestra',
      'Mª'=> 'null',
      'MA.'=> 'null',
      'MR.'=> 'mister (inglês = senhor)',
      'MONS.'=> 'monsenhor',
      'M.'=> 'monsieur',
      'MM.'=> 'messieurs (francês = senhor',
      'M.D.'=> 'Mui(to) Digno',
      'N.Sª'=> 'Nossa Senhora',
      'N.SA.'=> 'Nossa Senhora',
      'N.S.'=> 'Nosso Senhor',
      'P.'=> 'padre',
      'P.E'=> 'padre',
      'PE.'=> 'padre',
      'PÁR.º'=> 'pároco',
      'PARO.'=> 'pároco',
      'PR.'=> 'pastor',
      'PH.D.' => 'PHILOSOPHIAE DOCTOR (LATIM = DOUTOR DE/ EM FILOSOFIA)',
      'PREF.'=> 'prefeito',
      'PRESB.º'=> 'presbítero',
      'PRESBO.'=> 'presbítero',
      'PRES.'=> 'presidente',
      'PRESID.'=> 'presidente',
      'PROC.'=> 'procurador',
      'PROF.'=> 'professor',
      'PROFS.'=> 'professores',
      'PROF.ª'=> 'professora',
      'PROFA.'=> 'professoras',
      'PROF.AS'=> 'null',
      'PROFAS.'=> 'null',
      'PROM.'=> 'promotor',
      'PROV.'=> 'provedor',
      'R.'=> 'rei',
      'REV.MO'=> 'Reverendíssimo',
      'REVMO.'=> 'Revendíssima',
      'REV.MA'=> 'null',
      'REVMA.'=> 'null',
      'REV.'=> 'Reverendo',
      'REV.DO'=> 'Reverendo',
      'REVDO.'=> 'Reverendo',
      'REV.º'=> 'Reverendo',
      'REVO.'=> 'Reverendo',
      'R.P.'=> 'Reverendo Padre',
      'SAC.'=> 'sacerdote',
      'S.'=> 'Santa',
      'S.TA'=> 'Santa',
      'STA.'=> 'Santa',
      'SS.'=> 'Santíssimo',
      'S.'=> 'Santo',
      'S.TO'=> 'Santo',
      'STO.'=> 'Santo',
      'S.P.'=> 'Santo Padre',
      'S.'=> 'São',
      'SARG.'=> 'sargento',
      'SARG.-AJ.TE'=> 'sargento-ajudante',
      'SARG.-AJTE.'=> 'sargento-ajudante',
      'SEC.'=> 'secretário',
      'SECR.'=> 'secretária',
      'SEN.'=> 'senador',
      'S.R'=> 'senhor',
      'SR.'=> 'senhores',
      'S.RS'=> 'null',
      'SRS.'=> 'null',
      'S.RA'=> 'senhora',
      'SRA.'=> 'senhoras',
      'S.RAS'=> 'null',
      'SRAS.'=> 'null',
      'SR.TA'=> 'senhorita',
      'SRTA.'=> 'senhoritas',
      'SR.TAS'=> 'null',
      'SRTAS.'=> 'null',
      'S.OR'=> 'Sênior',
      'SOR.'=> 'Sênior',
      'SÓR.'=> 'sóror',
      'S.OR'=> 'sóror',
      'SOR.'=> 'sóror',
      'S.A.R.'=> 'Sua Alteza Real',
      'S.A.'=> 'Sua Alteza',
      'S.EM.ª'=> 'Sua Eminência',
      'S.EMA.'=> 'Sua Eminência',
      'S..EX.ª'=> 'Sua Excelência',
      'S.EXA.'=> 'Sua Excelência',
      'S.EX.ª REV.MA'=> 'Sua Excelência Reverendíssima',
      'S. EXA. REVMA.'=> 'Sua Excelência Reverendíssima',
      'S.M.'=> 'Sua Majestade',
      'S. REV.ª'=> 'Sua Reverência',
      'S.REVA.'=> 'Sua Reverência',
      'S.REV.MA'=> 'Sua Reverendíssima',
      'S. REVMA.'=> 'Sua Reverendíssima',
      'S.S.'=> 'Sua Santidade',
      'S.Sª'=> 'Sua Senhoria',
      'S.SA.'=> 'Sua Senhoria',
      'TEN.'=> 'tenente',
      'T.TE'=> 'tenente',
      'TTE.'=> 'tenente',
      'TEN. -C.EL'=> 'tenente-coronel',
      'TEN.-CEL.'=> 'tenente-coronel',
      'T.TE - C.EL'=> 'tenente-coronel',
      'TTE. - CEL.'=> 'tenente-coronel',
      'TES.'=> 'tesoureiro',
      'TEST.'=> 'testemunha',
      'VER.'=> 'vereador',
      'VET.'=> 'veterinário',
      'V. -ALM.'=> 'vice-almirante',
      'VIG.'=> 'vigário',
      'VIG.º'=> 'vigário',
      'VIGO.'=> 'vigário',
      'V.DE'=> 'visconde',
      'VDE.'=> 'visconde',
      'V.DESSA'=> 'viscondessa',
      'VDESSA.'=> 'viscondessa',
      'V.'=> 'você',
      'V.'=> 'você',
      'V.A.'=> 'Vossa Alteza',
      'V.EM.ª'=> 'Vossa Eminência',
      'V.EMA.'=> 'Vossas Eminências',
      'V.EM.AS'=> 'null',
      'V.EMAS.'=> 'null',
      'V.EX.ª REV.MA'=> 'Vossa Excelência Reverendíssima',
      'V. EXA. REVMA.'=> 'Vossas Excelências Reverendíssimas',
      'V.EX.AS REV.MAS'=> 'null',
      'V. EXAS. REVMAS.'=> 'null',
      'V.EX.ª'=> 'Vossa Excelência',
      'V.EXA.'=> 'Vossas Excelências',
      'V.EX.AS'=> 'null',
      'V.EXAS.'=> 'null',
      'V. MAG.ª'=> 'Vossa Magnificência',
      'V.MAGA.'=> 'Vossas Magnificências',
      'V.MAG.AS'=> 'null',
      'V.MAGAS.'=> 'null',
      'V.M.'=> 'Vossa Majestade',
      'V. VER.MA'=> 'Vossa Revendíssima',
      'V. REVMA.'=> 'Vossas Reverendíssimas',
      'V.REV.MAS'=> 'null',
      'V. REVMAS.'=> 'null',
      'V.REV.ª'=> 'Vossa Reverência',
      'V.REVA.'=> 'Vossas Reverências',
      'V. REV.AS'=> 'null',
      'V.REVAS.'=> 'null',
      'V.S.ª'=> 'Vossa Senhoria',
      'V.SA.'=> 'Vossas Senhorias',
      'V.S.AS'=> 'null',
      'V.SAS.'=> 'null');

  $_entFile=dirname(__FILE__)."/i18n/html-entities-utf8";
  function _grantEntFile($_entFile) {
    if (!file_exists("$_entFile.php")) {
      if (file_exists("$_entFile.txt")) {
        $_php1 = ""; $_php2 = ""; $_php3 = "";
        $_codes = file("$_entFile.txt");
        foreach($_codes as $_c) {
          $_c=str_replace("\n", '', $_c);
          $_c=explode(":", $_c);
          if ((!isset($_c[2])) || ($_c[2]==''))
            $_c[2]='';
          if ($_php1>"") { $_php1.=",\n\t"; $_php2.=",\n\t"; if ($_c[2]>'') $_php3.=",\n\t";}

          $_php1.="'$_c[0]' => array('$_c[0]', '$_c[1]', '$_c[2]')";
          $_php2.="'$_c[1]' => array('$_c[0]', '$_c[1]', '$_c[2]')";
          if ($_c[2]>'') {
            $_php3.="'$_c[2]' => array('$_c[0]', '$_c[1]', '$_c[2]')";
          }
        }
        $_php1 = "\$GLOBALS['html_entities_A']=array($_php1);\n";
        $_php2 = "\$GLOBALS['html_entities_B']=array($_php2);\n";
        $_php3 = "\$GLOBALS['html_entities_C']=array($_php3);\n";
        $_php = "<?php\n/* %YEAPF_VERSION_LABEL %*/\n$_php1$_php2$_php3\n?>";
        file_put_contents("$_entFile.php", $_php);
      }
    }
  };
  _grantEntFile($_entFile);

  (@include_once "$_entFile.php") or (_die("Error loading $_entFile"));
  unset($_entFile);
  // unset(_grantEntFile);

  function convertLatin1ToHtml($str) 
  { 
    /* source: http://php.net/manual/en/function.get-html-translation-table.php#84623 */
    $allEntities = get_html_translation_table(HTML_ENTITIES, ENT_NOQUOTES); 
    $specialEntities = get_html_translation_table(HTML_SPECIALCHARS, ENT_NOQUOTES); 
    $noTags = array_diff($allEntities, $specialEntities); 
    $str = strtr($str, $noTags); 
    return $str; 
  }   

?>
