<?php
    namespace App\Servicos\Arquivos\Produtos\Descricoes;

    class CacheDescicoes{
        private static array $descricoesSalvas;
        public static function setCache(string $nomeCache, string $cache){
            self::$descricoesSalvas[$nomeCache] = $cache;
        }
        public static function getCache(string $nomeCache) :string{
            return self::$descricoesSalvas[$nome];
        }
        public static function inCache(string $nomeCache) :bool{
            return isset(self::$descricoesSalvas[$nome]);
        }
    }
