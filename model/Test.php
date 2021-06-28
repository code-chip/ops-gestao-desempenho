<?php


class Test
{
    private $props = [];

    public function __get($attr) {
        if (isset($this->props[$attr])) {
            return $this->props[$attr];
        } else {
            echo "Não foi criado nenhuma variável com nome: " . $attr;
            return false;
        }
    }

    public function __set($attr, $value) {
        $this->props[$attr] = $value;
    }
}

$teste = new Test();

$teste->nome = "jon";

echo $teste->nome;

echo $teste->test;