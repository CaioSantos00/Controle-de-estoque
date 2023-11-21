@echo off >nul 2>&1

set "arquivo_a_verificar=../Sistema-de-pedidos-TCC/.phpunit.result.cache"
set "arqv_configs=phpunit.xml"

cd Tools 
move phpunit.phar ../ >nul
move "%arqv_configs%" ../ >nul

cd ../

php phpunit.phar --testdox %*

move phpunit.phar Tools >nul
move "%arqv_configs%" Tools >nul

if exist "%arquivo_a_verificar%" (
del "%arquivo_a_verificar%" >nul
)