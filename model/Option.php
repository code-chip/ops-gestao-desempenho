<?php


class Option
{
    private $idOption;
    private $name;
    private $type;
    private $status;

    public function __construct()
    {
    }

    public function __get($attr)
    {
        switch ($attr) {
            case 'idOption':
                return $this->idOption;
            case 'name':
                return $this->name;
            case 'type':
                return $this->type;
            case 'status':
                return $this->status;
        }
    }

    public function __set($attr, $value)
    {
        switch ($attr) {
            case 'idOption':
                $this->idOption = $value;
            case 'name':
                $this->name = $value;
            case 'type':
                $this->type = $value;
            case 'status':
                $this->status = $value;
        }
    }


}

$opcao = new Option();

$opcao->name= "Hello World";
$opcao->status = "Ativo";
echo $opcao->name;
$opcao->__set(name, "Teste");
echo $opcao->__get(name);
echo $opcao->__get(status);

