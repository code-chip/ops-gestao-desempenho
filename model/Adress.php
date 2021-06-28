<?php
require_once('../connection.php');

class Adress
{
    private $property= [];

    public function __get($attr) {
        if (isset($this->property[$attr])) {
            return $this->property[$attr];
        } else {
            echo "O nome da variável " . $attr . "Não existe!";
            return false;
        }
    }

    public function __set($attr, $value) {
        $this->property[$attr] = $value;
    }

    public function insertAdress($adress, $number, $block, $complement, $neighborhood, $city, $zipCode,$note, $voucher) {
        $cnx = mysqli_query(phpmyadmin ,'INSERT INTO ENDERECO(USUARIO_ID, ENDERECO, NUMERO, QUADRA, COMPLEMENTO, BAIRRO_ID, CEP, OBSERVACAO, CADASTRADO_EM, VALE_TRANSPORTE) VALUES(".$_SESSION["filter"][3].",'".$endereco."',".$numero.",NULL,'".$complemento."',".$bairro.",'".$cep."','".$observacao."','".date('Y-m-d')."', '".$vale."')";
		//');
    }

    public function queryAdress() {

    }

    public function updateAdress() {

    }

    public function deleteAdress() {

    }
}

$end = new Adress();
$end->__set(idAdress, 1);
$end->__set(adress, "Avenida dos Coqueiros");
$end->__set(number, 410);
$end->__set(neighbirhood, "Lagoa de Carabepus");
$end->__set(complement, "Casa de muro verde");
$end->__set(adress, "Avenida dos Coqueiros");
//echo array_values($end->property);
//var_dump($end);

echo $end->number;
$a = array('verde'=> 10, 'vermelho'=> 12, 'amarelo'=> 14);
$test = array_values ($a);
echo $test[0];
echo $a['vermelho'];