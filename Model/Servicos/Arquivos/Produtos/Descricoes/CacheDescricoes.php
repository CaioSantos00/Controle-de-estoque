<?php
    namespace App\Servicos\Arquivos\Produtos\Descricoes;

    class CacheDescricoes{
        private static array $descricoesSalvas;
        public static function setCache(string $nomeCache, string $cache){
            self::$descricoesSalvas[$nomeCache] = $cache;
        }
        public static function getCache(string $nomeCache) :string{
            return self::$descricoesSalvas[$nomeCache];
        }
        public static function inCache(string $nomeCache) :bool{
            return isset(self::$descricoesSalvas[$nomeCache]);
        }
    }
