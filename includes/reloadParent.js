<html>
<script language='javascript'>
/*
    includes/reloadParent.js
    YeAPF 0.8.61-148 built on 2018-11-21 10:19 (0 DST)
    Copyright (C) 2004-2018 Esteban Daniel Dortta - dortta@yahoo.com
    2018-08-24 21:24:25 (0 DST)
*/
  function recarregar()
  {
    var id=new String('#campo(id)');
    var rnd=Math.random()*1000;
    var s=new String(window.opener.location);
    rnd=Math.round(rnd);

    var p=s.search('rnd=');
    if (p>0)
      s=s.slice(0,p-1);

    p=s.search('#');
    if (p>0)
      s=s.slice(0,p);

    s=s+'&rnd='+rnd;
    s=s+'#'+id;

    window.opener.location.replace(s);
    window.close();
  }
</script>
<body onLoad='recarregar()'>
</body>
</html>
