<?php

class Cart {
    //properties

    public function getitems($db){
        $sql="SELECT * FROM products";


        $stmt = $db->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_OBJ);

        $items = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $items;
    }

    public function makePurchase($details, $finaltotal, $db){
        $sql = "INSERT INTO orders (invoiceDetails, invoiceTotal) VALUES (:invoiceDetails, :invoiceTotal)";

        $pdostm = $db->prepare($sql);

        $pdostm->bindParam(':invoiceDetails', $details);
        $pdostm->bindParam(':invoiceTotal', $finaltotal);

        $count = $pdostm->execute();
        return $count;
    }

}
?>