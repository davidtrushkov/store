@ECHO OFF
SET BIN_TARGET=%~dp0/../nikic/php-parser/bin/php-parse
php "%BIN_TARGET%" %*
