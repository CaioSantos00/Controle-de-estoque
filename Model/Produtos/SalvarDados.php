<?php
  namespace App\Produtos;

  use App\Servicos\Conexao\ConexaoBanco as CB;

  class SalvarDados{
    public static array $dado;
    public static string $query;
    public static bool $ok;
    static function executar(){
      self::$ok =
        CB::getConexao()
        ->prepare(self::$query)
        ->execute(self::$dado);
    }
  }
