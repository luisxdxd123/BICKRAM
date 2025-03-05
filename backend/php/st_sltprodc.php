<?php
function getProducts(){
    require '../../backend/bd/ctconex.php';

    $sentencia = $connect->prepare("SELECT p.idprod, p.codba, p.nomprd, p.precio, c.nomca, p.stock 
        FROM producto AS p 
        INNER JOIN categoria AS c ON p.idcate = c.idcate    
        ORDER BY p.idprod DESC;");
    
    $sentencia->execute();
    $data = array();
    if ($sentencia) {
        while ($r = $sentencia->fetchObject()) {
            $data[] = $r;
        }
    }
    return $data;
}
?>
