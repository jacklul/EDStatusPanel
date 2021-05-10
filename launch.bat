@echo off

SET PATH=%SPATH%\runtime\;%PATH%

WHERE php 2> NUL
IF %ERRORLEVEL% NEQ 0 ECHO PHP is not available && GOTO EOF

php -S 127.0.0.1:3300

:eof
