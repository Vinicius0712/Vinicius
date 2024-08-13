<?php
require_once("../classes/Database.class.php");
require_once("../classes/Unidade.class.php");

class Quadrado {
    
    private $id; 
    private $lado; 
    private $id_unidade;
    private $cor; 

    // Construtor da classe que inicializa as propriedades com valores fornecidos ou padrão
    public function __construct($id = 0, $lado = 0, UnidadeMedida $id_unidade = null, $cor = "null") {
        $this->setId($id); 
        $this->setLado($lado); 
        $this->setIdUnidade($id_unidade); 
        $this->setCor($cor);
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getLado() {
        return $this->lado;
    }

    public function setLado($lado) {
        $this->lado = $lado;
        return $this;
    }

    public function getIdUnidade() {
        return $this->id_unidade;
    }
    
    public function setIdUnidade(UnidadeMedida $id_unidade) {
        $this->id_unidade = $id_unidade;
    }
    
    public function getCor() {
        return $this->cor;
    }

    public function setCor($cor) {
        $this->cor = $cor;
        return $this;
    }

    public function incluir() {
        $sql = 'INSERT INTO quadrado (lado, id_unidade, cor)   
                     VALUES (:lado, :id_unidade, :cor)';

        $parametros = array(':lado' => $this->lado,
                            ':id_unidade' => $this->getIdUnidade()->getIdUnidade(),
                            ':cor' => $this->cor);

        return Database::executar($sql, $parametros);
    }    

    public function excluir() {
        $sql = 'DELETE 
                  FROM quadrado
                 WHERE id = :id';

        $parametros = array(':id' => $this->id);

        return Database::executar($sql, $parametros);
    }  

    public function alterar() {
        $sql = 'UPDATE quadrado 
                   SET lado = :lado, id_unidade = :id_unidade, cor = :cor
                 WHERE id = :id';
                
        $parametros = array(':id' => $this->id,
                            ':lado' => $this->lado,
                            ':id_unidade' => $this->getIdUnidade()->getIdUnidade(),
                            ':cor' => $this->cor);

        return Database::executar($sql, $parametros);
    }    

    public static function listar($tipo = 0, $busca = "") {
        $sql = "SELECT * FROM quadrado"; 

        $parametros = array(); 

        if ($tipo > 0) {
            switch ($tipo) {
                case 1:
                    $sql .= " WHERE id = :busca";
                    break;
                case 2:
                    $sql .= " WHERE lado like :busca";
                    $busca = "%{$busca}%";
                    break;
            }
            $parametros = array(':busca' => $busca);
        }
 
        $registros = Database::executar($sql, $parametros);

        $quadrados = array();

        while ($registro = $registros->fetch()) {
            $id_unidade = UnidadeMedida::listar(1, $registro['id_unidade'])[0];
            $quadrado = new Quadrado($registro['id'], $registro['lado'], $id_unidade, $registro['cor']);
            array_push($quadrados, $quadrado);
        }
        return $quadrados; 
    }    

    public function desenhar() {
        return "<a href='index.php?id=" . $this->getId() . "'><div class='container' style='background-color: ".$this->getCor()."; width:" .$this->getLado() .$this->getIdUnidade()->getSigla()."; height:" .$this->getLado() .$this->getIdUnidade()->getSigla(). "'></div></a><br>";
    }
    
}
?>
