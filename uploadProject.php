<?php
$target_dir = "uploads";

if (!is_dir($target_dir))
  mkdir($target_dir);

$project = $_POST['project'];
if ($project>'') {
  if (!is_dir("$target_dir/$project"))
    mkdir("$target_dir/$project");
  $target_file="$target_dir/$project/". basename($_FILES["project_file"]["name"]);

  if (!is_dir("prod-versions"))
    mkdir("prod-versions");

  $target_def = "prod-versions/$project.def";
  $target_ver = "prod-versions/$project.ver";

  if ($_FILES["project_file"]['error']==0) {
    if (move_uploaded_file($_FILES["project_file"]["tmp_name"], $target_file)) {
      if (move_uploaded_file($_FILES["project_def"]["tmp_name"], $target_def)) {
        file_put_contents($target_ver, $_POST['version']);
        echo "OK";
      } else {
        echo "ErrorDef";
      }
    } else  {
      print_r($_FILES);
      echo "ErrorProject copying ".$_FILES["project_file"]["tmp_name"]." to $target_file";
    }      
  } else {
    echo "Error uploading project file";
  }
} else 
  echo "NoProject";

echo "\n";

?>