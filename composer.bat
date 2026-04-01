@echo off
setlocal
set "SCRIPT_DIR=%~dp0"
"%SCRIPT_DIR%php\php.exe" "%SCRIPT_DIR%composer.phar" %*
