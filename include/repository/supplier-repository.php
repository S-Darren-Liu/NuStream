<?php

    function create_supplier_request($createSupplierArray)
    {
        $supplierName = $createSupplierArray['supplierName'];
        $supplierType = $createSupplierArray['supplierType'];
        $priceUnit = $createSupplierArray['priceUnit'];
        $pricePerUnit = $createSupplierArray['pricePerUnit'];
        $firstContactName = $createSupplierArray['firstContactName'];
        $firstContactNumber = $createSupplierArray['firstContactNumber'];
        $supportArea = $createSupplierArray['supportArea'];
        $secondContactNumber = $createSupplierArray['secondContactNumber'];
        $supportLocation = $createSupplierArray['supportLocation'];
        $HSTNumber = $createSupplierArray['HSTNumber'];
        $paymentTerm = $createSupplierArray['paymentTerm'];
        $mimPayment = $createSupplierArray['mimPayment'];
        $condoPrice = $createSupplierArray['condoPrice'];
        $townPrice = $createSupplierArray['townPrice'];
        $semiPrice = $createSupplierArray['semiPrice'];
        $detachedPrice = $createSupplierArray['detachedPrice'];
        if($paymentTerm === 'OTHER')
            $otherPaymentTerm = $createSupplierArray['otherPaymentTerm'];
        else
            $otherPaymentTerm = null;
        $sql = "INSERT INTO suppliers (SupplierName, SupplierType, PriceUnit, PricePerUnit, FirstContactName, FirstContactNumber, SupportLocation,
                SecondContactNumber, HSTNumber, PaymentTerm, OtherPaymentTerm, MinimumPrice, PricePerCondo, PricePerHouse, PricePerSemi, PricePerTownhouse )
                        VALUES ('$supplierName', '$supplierType', '$priceUnit', '$pricePerUnit', '$firstContactName', '$firstContactNumber', '$supportArea', '$secondContactNumber', '$HSTNumber', '$paymentTerm', '$otherPaymentTerm', '$mimPayment', '$condoPrice', '$detachedPrice', '$semiPrice', '$townPrice')";

        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();
        $result = mysqli_query($conn, $sql);

        if($result === TRUE){
            $sql = "SELECT LAST_INSERT_ID()";
            $result = mysqli_query($conn, $sql);
        }

        mysqli_close($conn);
        return $result;
    }

    // Get supplier Brief Info
    function get_supplier_brief_info_request($supplierType)
    {
        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "SELECT SupplierID, SupplierName, PricePerUnit, FirstContactName, FirstContactNumber, SupportLocation FROM suppliers WHERE SupplierType='$supplierType' AND IsActivate=TRUE ";
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);

        return $result;
    }

    // Get Supplier Brief Info
    function get_no_default_supplier_brief_info_request($supplierType){
        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "SELECT SupplierID, SupplierName, PricePerUnit, FirstContactName, FirstContactNumber, SupportLocation FROM suppliers WHERE SupplierType='$supplierType' AND isDefault='0' AND IsActivate=TRUE ";
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);

        return $result;
    }

    // Get Supplier Detail
    function get_supplier_detail_request($supplierID)
    {
        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "SELECT * FROM suppliers WHERE SupplierID='$supplierID' AND IsActivate=TRUE LIMIT 1";
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);

        return $result;
    }

    // Edit Supplier
    function edit_supplier_request($updateSupplierArray)
    {
        $supplierID = $updateSupplierArray['supplierID'];
        $priceUnit = $updateSupplierArray['priceUnit'];
        $pricePerUnit = $updateSupplierArray['pricePerUnit'];
        $firstContactName = $updateSupplierArray['firstContactName'];
        $firstContactNumber = $updateSupplierArray['firstContactNumber'];
        $secondContactName = $updateSupplierArray['secondContactName'];
        $secondContactNumber = $updateSupplierArray['secondContactNumber'];
        $supportLocation = $updateSupplierArray['supportLocation'];
        $HSTNumber = $updateSupplierArray['HSTNumber'];
        $paymentTerm = $updateSupplierArray['paymentTerm'];
        $mimPayment = $updateSupplierArray['mimPayment'];
        $condoPrice = $updateSupplierArray['condoPrice'];
        $townPrice = $updateSupplierArray['townPrice'];
        $semiPrice = $updateSupplierArray['semiPrice'];
        $detachedPrice = $updateSupplierArray['detachedPrice'];
        if($paymentTerm === 'OTHER')
            $otherPaymentTerm = $updateSupplierArray['otherPaymentTerm'];
        else
            $otherPaymentTerm = null;

        $sql = "UPDATE suppliers SET 
                    PriceUnit = '$priceUnit',
                    PricePerUnit = '$pricePerUnit', 
                    FirstContactName = '$firstContactName', 
                    FirstContactNumber = '$firstContactNumber',
                    SecondContactName = '$secondContactName',
                    SecondContactNumber = '$secondContactNumber',
                    SupportLocation = '$supportLocation',
                    HSTNumber = '$HSTNumber',
                    PaymentTerm = '$paymentTerm',
                    OtherPaymentTerm = '$otherPaymentTerm',
                    MinimumPrice = '$mimPayment',
                    PricePerCondo = '$condoPrice',
                    PricePerTownhouse = '$townPrice',
                    PricePerSemi = '$semiPrice',
                    PricePerHouse = '$detachedPrice'
                    WHERE SupplierID = '$supplierID'";

        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();
        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);

        return $result;
    }

    // Deactivate Supplier
    function deactivate_supplier_by_id_request($supplierID){
        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "UPDATE suppliers SET IsActivate = FALSE 
                        WHERE SupplierID = '$supplierID' AND isDefault=FALSE ";
        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
        return $result;
    }

    // Get Default Supplier By Type
    function get_default_supplier_by_type($supplierType){
        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "SELECT * FROM suppliers WHERE SupplierType='$supplierType' AND isDefault=TRUE LIMIT 1";
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);

        return $result;
    }

    // Get Supplier Name By Id
    function get_supplier_name_by_id_request($supplierID){
        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "SELECT SupplierName FROM suppliers WHERE SupplierID='$supplierID' AND IsActivate=TRUE LIMIT 1";
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);

        return $result;
    }

?>