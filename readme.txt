Para subir um projeto

curl \
  -F 'project_file=@downloads/myLittleProject-1.0.34.zip' \
  -F 'project_def=@.distribution/1.0.34/version.def' \
  -F 'version=1.0.34-991'  \
  -F 'project=myLittleProject'  \
  http://distro.inovacaosistemas.com.br/uploadProject.php
