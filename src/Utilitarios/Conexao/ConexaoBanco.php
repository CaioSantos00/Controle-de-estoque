<?php    
    namespace Utilitarios\Conexao;        
    require_once "../../../vendor/autoload.php";
    
    use Monolog\Level;
    use Monolog\Logger;
    use Monolog\Handler\StreamHandler;
    
    class ConexaoBanco{
        private static PDO $Conexao;
        public static 
        public static function getConexao() :PDO{
            if(empty(ConexaoBanco::$Conexao)){
                try{
                    ConexaoBanco::$Conexao = new PDO('mysql:dbname=mmsx;charset=utf-8;host=localhost','root','');    
                }
                catch(PDOException $ex){
                    
                }                
            }
            return ConexaoBanco::$Conexao;
        }
    }
?>