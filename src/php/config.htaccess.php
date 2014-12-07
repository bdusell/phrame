DefaultLanguage en-US
AddDefaultCharset utf-8
ServerSignature Off
RewriteEngine On
DirectorySlash Off
Options -Indexes
IndexIgnore *
RewriteCond %{REQUEST_FILENAME} !-f [OR]
RewriteCond %{REQUEST_FILENAME} !^<?= config::document_root() ?>/(css/.*\.css|js/.*\.js|assets/.*)$
RewriteRule ^ index.php [L]
