<?php
class Noticia {
private $conn;
private $table_name = "noticias";
public function __construct($db) {
$this->conn = $db;
}
public function registrar($id, $data, $titulo, $desc) {
$query = "INSERT INTO " . $this->table_name . " (idusu, data, titulo,
noticia) VALUES (?, ?, ?, ?)";
$stmt = $this->conn->prepare($query);
$stmt->execute([$id, $data, $titulo, $desc]);
return $stmt;
}

public function criar($id, $data, $titulo, $desc) {
return $this->registrar($id, $data, $titulo, $desc);
}
public function lerIdusu($id) {
    $query = "SELECT * FROM " . $this->table_name . " INNER JOIN usuarios WHERE idusu = ? AND id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$id, $id]);
    return $stmt;
}

public function ler() {
    $query = "SELECT * FROM " . $this->table_name . " INNER JOIN usuarios WHERE idusu = id";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
    }


public function lerPorId($id) {
$query = "SELECT * FROM " . $this->table_name . " WHERE idnot = ?";
$stmt = $this->conn->prepare($query);
$stmt->execute([$id]);
return $stmt->fetch(PDO::FETCH_ASSOC);
}
public function atualizar($idnot, $data, $titulo, $noticia) {
$query = "UPDATE " . $this->table_name . " SET data = ?, titulo =
?, noticia = ? WHERE idnot = ?";
$stmt = $this->conn->prepare($query);
$stmt->execute([$data, $titulo, $noticia, $idnot]);
return $stmt;
}
public function deletar($idnot) {
$query = "DELETE FROM " . $this->table_name . " WHERE idnot = ?";
$stmt = $this->conn->prepare($query);
$stmt->execute([$idnot]);
return $stmt;
}

public function gerarCodigoVerificacao($email) {
    $codigo =
    substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 10);
    $query = "UPDATE " . $this->table_name . " SET
    codigo_verificacao = ? WHERE email = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$codigo, $email]);
    return ($stmt->rowCount() > 0) ? $codigo : false;
    }

    public function verificarCodigo($codigo) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE
        codigo_verificacao = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$codigo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function redefinirSenha($codigo, $senha) {
        $query = "UPDATE " . $this->table_name . " SET senha = ?,
        codigo_verificacao = NULL WHERE codigo_verificacao = ?";
        $stmt = $this->conn->prepare($query);
        $hashed_password = password_hash($senha, PASSWORD_BCRYPT);
        $stmt->execute([$hashed_password, $codigo]);
        return $stmt->rowCount() > 0;
        }
}
?>