<?php

// Start Session
session_start();

/*
Template Name: Agent Case File Upload
*/

    // Get Case ID
    $MLS = $_GET['CID'];
    $isRefreshPage = $_GET['RF'];
    $uploadBasePath = "wp-content/themes/NuStream/Upload/case/" . $MLS;
    $PageURL = get_home_url() . '/agent-case-file-upload';
    $houseImageURL =  get_home_url() . "/wp-content/themes/NuStream/Upload/case/" . $MLS . "/HouseImage/";
    $defaultHouseImageURL =  get_home_url() . "/wp-content/themes/NuStream/img/house.jpg";

    // Init Date
    // Get Case Statuses
    $caseStatuses = get_case_statuses();

    // Get Case Basic Details
    $caseDetailsArray = array();
    $caseDetailsArray = get_case_basic_details($MLS);

    // Get All Services Info
    $stagingServiceArray = array();
    $stagingServiceArray = get_service_detail($caseDetailsArray['StagingID']);
    $touchUpServiceArray = array();
    $touchUpServiceArray = get_service_detail($caseDetailsArray['TouchUpID']);
    $cleanUpServiceArray = array();
    $cleanUpServiceArray = get_service_detail($caseDetailsArray['CleanUpID']);
    $yardWorkServiceArray = array();
    $yardWorkServiceArray = get_service_detail($caseDetailsArray['YardWorkID']);
    $inspectionServiceArray = array();
    $inspectionServiceArray = get_service_detail($caseDetailsArray['InspectionID']);
    $storageServiceArray = array();
    $storageServiceArray = get_service_detail($caseDetailsArray['StorageID']);
    $relocateHomeServiceArray = array();
    $relocateHomeServiceArray = get_service_detail($caseDetailsArray['RelocateHomeID']);
    $photographyServiceArray = array();
    $photographyServiceArray = get_service_detail($caseDetailsArray['PhotographyID']);

    // Get All Files
    $stagingImageFilesArray = get_staging_files();
    $cleanUpImageFilesArray = get_clean_up_files();
    $touchUpImageFilesArray = get_touch_up_files();
    $yardWorkImageFilesArray = get_yard_work_files();
    $inspectionImageFilesArray = get_inspection_files();
    $storageImageFilesArray = get_storage_files();
    $relocateHomeImageFilesArray = get_relocate_home_files();
    $stagingImageFilesArray = get_staging_files();

    // Get Case Basic Details
    function get_case_basic_details($MLS){
        $getCaseResult = get_case_by_id($MLS);
        if($getCaseResult !== null){
            $caseDetailsArray = mysqli_fetch_array($getCaseResult);
        }
        else{
            echo die("Cannot find account");
        }
        $getCoStaffResult = get_agent_account($caseDetailsArray['CoStaffID']);
        if($getCoStaffResult !== null){
            $coStaffArray = mysqli_fetch_array($getCoStaffResult);
            $caseDetailsArray['CoStaffName'] = $coStaffArray['FirstName'] . " " . $coStaffArray['LastName'];
        }
        return $caseDetailsArray;
    }

    // Get Service Details By ID
    function get_service_detail($serviceID){
        global $isRefreshPage;
        $serviceDetailsResult = get_service_details_by_id($serviceID);
        $serviceDetailsArray = mysqli_fetch_array($serviceDetailsResult);
        $isActive = $isRefreshPage === "1" ? $_SESSION['CaseEstimate'][$serviceID]['isServiceChecked'] : $serviceDetailsArray['IsActivate'];
        $serviceDetailsArray['IsChecked'] = $isActive === 'checked' ? 'checked' : null;
        $serviceDetailsArray['IsDisabled'] = $serviceDetailsArray['InvoiceStatus'] === 'APPROVED' ? 'disabled' : null;
        if($isRefreshPage === '1'){
            $serviceDetailsArray['ServiceSupplierID'] = $_SESSION['CaseEstimate'][$serviceID]['supplierID'];
            $serviceDetailsArray['RealCost'] = $_SESSION['CaseEstimate'][$serviceID]['serviceRealCost'];
        }
        return $serviceDetailsArray;
    }

    // Get All Files
    function get_staging_files(){
        global $uploadBasePath;
        $uploadPath = $uploadBasePath . "/Staging/";
        $stagingImageFilesArray = array(
            "Invoice" => mysqli_fetch_array(download_file_by_path($uploadPath . "Invoice/")),
            "BeforeLivingRoom" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "LivingRoom/")),
            "BeforeDinningRoom" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "DinningRoom/")),
            "BeforeMasterRoom" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "MasterRoom/")),
            "AfterLivingRoom" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "LivingRoom/")),
            "AfterDinningRoom" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "DinningRoom/")),
            "AfterMasterRoom" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "MasterRoom/"))
        );
        return $stagingImageFilesArray;
    }
    function get_clean_up_files(){
        global $uploadBasePath;
        $uploadPath = $uploadBasePath . "/CleanUp/";
        $cleanUpImageFilesArray = array(
            "Invoice" => mysqli_fetch_array(download_file_by_path($uploadPath . "Invoice/")),
            "BeforeLivingRoom" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "LivingRoom/")),
            "BeforeKitchen" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "Kitchen/")),
            "BeforeWashRoom" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "WashRoom/")),
            "AfterLivingRoom" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "LivingRoom/")),
            "AfterKitchen" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "Kitchen/")),
            "AfterWashRoom" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "WashRoom/"))
        );
        return $cleanUpImageFilesArray;
    }
    function get_touch_up_files(){
        global $uploadBasePath;
        $uploadPath = $uploadBasePath . "/TouchUp/";
        $touchUpImageFilesArray = array(
            "Invoice" => mysqli_fetch_array(download_file_by_path($uploadPath . "Invoice/")),
            "Before1" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "1/")),
            "Before2" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "2/")),
            "Before3" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "3/")),
            "Before4" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "4/")),
            "Before5" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "5/")),
            "After1" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "1/")),
            "After2" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "2/")),
            "After3" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "3/")),
            "After4" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "4/")),
            "After5" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "5/"))
        );
        return $touchUpImageFilesArray;
    }
    function get_yard_work_files(){
        global $uploadBasePath;
        $uploadPath = $uploadBasePath . "/YardWork/";
        $yardWorkImageFilesArray = array(
            "Invoice" => mysqli_fetch_array(download_file_by_path($uploadPath . "Invoice/")),
            "BeforeFrontYard" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "FrontYard/")),
            "BeforeBackYard" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "BackYard/")),
            "AfterFrontYard" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "FrontYard/")),
            "AfterBackYard" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "BackYard/"))
        );
        return $yardWorkImageFilesArray;
    }
    function get_inspection_files(){
        global $uploadBasePath;
        $uploadPath = $uploadBasePath . "/Inspection/";
        $inspectionImageFilesArray = array(
            "Invoice" => mysqli_fetch_array(download_file_by_path($uploadPath . "Invoice/")),
            "Report" => mysqli_fetch_array(download_file_by_path($uploadPath . "Report/"))
        );
        return $inspectionImageFilesArray;
    }
    function get_storage_files(){
        global $uploadBasePath;
        $uploadPath = $uploadBasePath . "/Storage/";
        $storageImageFilesArray = array(
            "Invoice" => mysqli_fetch_array(download_file_by_path($uploadPath . "Invoice/"))
        );
        return $storageImageFilesArray;
    }
    function get_relocate_home_files(){
        global $uploadBasePath;
        $uploadPath = $uploadBasePath . "/RelocateHome/";
        $relocateHomeImageFilesArray = array(
            "Invoice" => mysqli_fetch_array(download_file_by_path($uploadPath . "Invoice/"))
        );
        return $relocateHomeImageFilesArray;
    }

    // Upload File
    function upload_file($uploadPath, $uploadTmp, $uploadName){
        if(!is_dir($uploadPath)){
            mkdir($uploadPath, 0777, true);
        }

        if (!$uploadTmp) {
            die("No File Selected, Please Upload Again.");
        } else {
            $uploadResult = move_uploaded_file($uploadTmp, $uploadPath . $uploadName);
        }

        if($uploadResult){
            $setFilePathAndNameResult = set_file_path_and_name($uploadPath, $uploadName);
        }
    }

    // Remove File
    function remove_file($dir, $fileName){
        if(!is_null($fileName)){
            if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir."/".$object) == "dir")
                        rrmdir($dir."/".$object);
                    else unlink   ($dir."/".$object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
            $removeFileResult = remove_file_by_name($fileName);
        }
    }

    // Upload Staging
    if(isset($_POST['submit_staging'])){
        global $PageURL;
        $serviceID = $stagingServiceArray['ServiceID'];
        $uploadPath = $uploadBasePath . "/Staging/";

        $invoiceUploadTmp = $_FILES['upload_staging_invoice']['tmp_name'];
        $invoiceUploadName = preg_replace("#[^a-z0-9.]#i", "",  time() . '_' . $_FILES['upload_staging_invoice']['name']);

        $beforeLivingRoomUploadTmp = $_FILES['upload_staging_before_living_room']['tmp_name'];
        $beforeLivingRoomUploadName = preg_replace("#[^a-z0-9.]#i", "",  time() . '_' . $_FILES['upload_staging_before_living_room']['name']);

        $beforeDinningRoomUploadTmp = $_FILES['upload_staging_before_dinning_room']['tmp_name'];
        $beforeDinningRoomUploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_staging_before_dinning_room']['name']);

        $beforeMasterRoomUploadTmp = $_FILES['upload_staging_before_master_room']['tmp_name'];
        $beforeMasterRoomUploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_staging_before_master_room']['name']);

        $afterLivingRoomUploadTmp = $_FILES['upload_staging_after_living_room']['tmp_name'];
        $afterLivingRoomUploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_staging_after_living_room']['name']);

        $afterDinningRoomUploadTmp = $_FILES['upload_staging_after_dinning_room']['tmp_name'];
        $afterDinningRoomUploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_staging_after_dinning_room']['name']);

        $afterMasterRoomUploadTmp = $_FILES['upload_staging_after_master_room']['tmp_name'];
        $afterMasterRoomUploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_staging_after_master_room']['name']);

        if(!empty($invoiceUploadTmp)){
            remove_file($stagingImageFilesArray['Invoice']["FilePath"], $stagingImageFilesArray['Invoice']["FileName"]);
            upload_file($uploadPath . "Invoice/", $invoiceUploadTmp, $invoiceUploadName);
        }
        if(!empty($beforeLivingRoomUploadTmp)){
            remove_file($stagingImageFilesArray['BeforeLivingRoom']["FilePath"], $stagingImageFilesArray['BeforeLivingRoom']["FileName"]);
            upload_file($uploadPath . "Before/" . "LivingRoom/", $beforeLivingRoomUploadTmp, $beforeLivingRoomUploadName);
        }
        if(!empty($beforeDinningRoomUploadTmp)){
            remove_file($stagingImageFilesArray['BeforeDinningRoom']["FilePath"], $stagingImageFilesArray['BeforeDinningRoom']["FileName"]);
            upload_file($uploadPath . "Before/" . "DinningRoom/", $beforeDinningRoomUploadTmp, $beforeDinningRoomUploadName);
        }
        if(!empty($beforeMasterRoomUploadTmp)){
            remove_file($stagingImageFilesArray['BeforeMasterRoom']["FilePath"], $stagingImageFilesArray['BeforeMasterRoom']["FileName"]);
            upload_file($uploadPath . "Before/" . "MasterRoom/", $beforeMasterRoomUploadTmp, $beforeMasterRoomUploadName);
        }
        if(!empty($afterLivingRoomUploadTmp)){
            remove_file($stagingImageFilesArray['AfterLivingRoom']["FilePath"], $stagingImageFilesArray['AfterLivingRoom']["FileName"]);
            upload_file($uploadPath . "After/" . "LivingRoom/", $afterLivingRoomUploadTmp, $afterLivingRoomUploadName);
        }
        if(!empty($afterDinningRoomUploadTmp)){
            remove_file($stagingImageFilesArray['AfterDinningRoom']["FilePath"], $stagingImageFilesArray['AfterDinningRoom']["FileName"]);
            upload_file($uploadPath . "After/" . "DinningRoom/", $afterDinningRoomUploadTmp, $afterDinningRoomUploadName);
        }
        if(!empty($afterMasterRoomUploadTmp)) {
            remove_file($stagingImageFilesArray['AfterMasterRoom']["FilePath"], $stagingImageFilesArray['AfterMasterRoom']["FileName"]);
            upload_file($uploadPath . "After/" . "MasterRoom/", $afterMasterRoomUploadTmp, $afterMasterRoomUploadName);
        }

        $updateServiceInvoiceResult = update_service_invoice($serviceID, $uploadPath . "Invoice/");
        $updateServiceImageResult = update_service_image($serviceID, $uploadPath);
        header('location: ' . $PageURL . '/?CID=' . $MLS);
    }

    if(isset($_POST['submit_clean_up'])){
        global $PageURL;
        $serviceID = $cleanUpServiceArray['ServiceID'];
        $uploadPath = $uploadBasePath . "/CleanUp/";

        $invoiceUploadTmp = $_FILES['upload_clean_up_invoice']['tmp_name'];
        $invoiceUploadName = preg_replace("#[^a-z0-9.]#i", "",  time() . '_' . $_FILES['upload_clean_up_invoice']['name']);

        $beforeLivingRoomUploadTmp = $_FILES['upload_clean_up_before_living_room']['tmp_name'];
        $beforeLivingRoomUploadName = preg_replace("#[^a-z0-9.]#i", "",  time() . '_' . $_FILES['upload_clean_up_before_living_room']['name']);

        $beforeKitchenUploadTmp = $_FILES['upload_clean_up_before_kitchen']['tmp_name'];
        $beforeKitchenUploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_clean_up_before_kitchen']['name']);

        $beforeWashRoomUploadTmp = $_FILES['upload_clean_up_before_wash_room']['tmp_name'];
        $beforeWashRoomUploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_clean_up_before_wash_room']['name']);

        $afterLivingRoomUploadTmp = $_FILES['upload_clean_up_after_living_room']['tmp_name'];
        $afterLivingRoomUploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_clean_up_after_living_room']['name']);

        $afterKitchenRoomUploadTmp = $_FILES['upload_clean_up_after_kitchen']['tmp_name'];
        $afterKitchenRoomUploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_clean_up_after_kitchen']['name']);

        $afterWashRoomUploadTmp = $_FILES['upload_clean_up_after_wash_room']['tmp_name'];
        $afterWashRoomUploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_clean_up_after_wash_room']['name']);

        if(!empty($invoiceUploadTmp)){
            remove_file($cleanUpImageFilesArray['Invoice']["FilePath"], $cleanUpImageFilesArray['Invoice']["FileName"]);
            upload_file($uploadPath . "Invoice/", $invoiceUploadTmp, $invoiceUploadName);
        }
        if(!empty($beforeLivingRoomUploadTmp)){
            remove_file($cleanUpImageFilesArray['BeforeLivingRoom']["FilePath"], $cleanUpImageFilesArray['BeforeLivingRoom']["FileName"]);
            upload_file($uploadPath . "Before/" . "LivingRoom/", $beforeLivingRoomUploadTmp, $beforeLivingRoomUploadName);
        }
        if(!empty($beforeKitchenUploadTmp)){
            remove_file($cleanUpImageFilesArray['BeforeKitchen']["FilePath"], $cleanUpImageFilesArray['BeforeKitchen']["FileName"]);
            upload_file($uploadPath . "Before/" . "Kitchen/", $beforeKitchenUploadTmp, $beforeKitchenUploadName);
        }
        if(!empty($beforeWashRoomUploadTmp)){
            remove_file($cleanUpImageFilesArray['BeforeWashRoom']["FilePath"], $cleanUpImageFilesArray['BeforeWashRoom']["FileName"]);
            upload_file($uploadPath . "Before/" . "WashRoom/", $beforeWashRoomUploadTmp, $beforeWashRoomUploadName);
        }
        if(!empty($afterLivingRoomUploadTmp)){
            remove_file($cleanUpImageFilesArray['AfterLivingRoom']["FilePath"], $cleanUpImageFilesArray['AfterLivingRoom']["FileName"]);
            upload_file($uploadPath . "After/" . "LivingRoom/", $afterLivingRoomUploadTmp, $afterLivingRoomUploadName);
        }
        if(!empty($afterKitchenRoomUploadTmp)){
            remove_file($cleanUpImageFilesArray['AfterKitchen']["FilePath"], $cleanUpImageFilesArray['AfterKitchen']["FileName"]);
            upload_file($uploadPath . "After/" . "Kitchen/", $afterKitchenRoomUploadTmp, $afterKitchenRoomUploadName);
        }
        if(!empty($afterWashRoomUploadTmp)) {
            remove_file($cleanUpImageFilesArray['AfterWashRoom']["FilePath"], $cleanUpImageFilesArray['AfterWashRoom']["FileName"]);
            upload_file($uploadPath . "After/" . "WashRoom/", $afterWashRoomUploadTmp, $afterWashRoomUploadName);
        }

        $updateServiceInvoiceResult = update_service_invoice($serviceID, $uploadPath . "Invoice/");
        $updateServiceImageResult = update_service_image($serviceID, $uploadPath);
        header('location: ' . $PageURL . '/?CID=' . $MLS);
    }

    if(isset($_POST['submit_touch_up'])){
        global $PageURL;
        $serviceID = $touchUpServiceArray['ServiceID'];
        $uploadPath = $uploadBasePath . "/TouchUp/";

        $invoiceUploadTmp = $_FILES['upload_touch_up_invoice']['tmp_name'];
        $invoiceUploadName = preg_replace("#[^a-z0-9.]#i", "",  time() . '_' . $_FILES['upload_touch_up_invoice']['name']);

        $before1UploadTmp = $_FILES['upload_touch_up_before_1']['tmp_name'];
        $before1UploadName = preg_replace("#[^a-z0-9.]#i", "",  time() . '_' . $_FILES['upload_touch_up_before_1']['name']);

        $before2UploadTmp = $_FILES['upload_touch_up_before_2']['tmp_name'];
        $before2UploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_touch_up_before_2']['name']);

        $before3UploadTmp = $_FILES['upload_touch_up_before_3']['tmp_name'];
        $before3UploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_touch_up_before_3']['name']);

        $before4UploadTmp = $_FILES['upload_touch_up_before_4']['tmp_name'];
        $before4UploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_touch_up_before_4']['name']);

        $before5UploadTmp = $_FILES['upload_touch_up_before_5']['tmp_name'];
        $before5UploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_touch_up_before_5']['name']);

        $after1UploadTmp = $_FILES['upload_touch_up_after_1']['tmp_name'];
        $after1UploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_touch_up_after_1']['name']);

        $after2UploadTmp = $_FILES['upload_touch_up_after_2']['tmp_name'];
        $after2UploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_touch_up_after_2']['name']);

        $after3UploadTmp = $_FILES['upload_touch_up_after_3']['tmp_name'];
        $after3UploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_touch_up_after_3']['name']);

        $after4UploadTmp = $_FILES['upload_touch_up_after_4']['tmp_name'];
        $after4UploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_touch_up_after_4']['name']);

        $after5UploadTmp = $_FILES['upload_touch_up_after_5']['tmp_name'];
        $after5UploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_touch_up_after_5']['name']);

        if(!empty($invoiceUploadTmp)){
            remove_file($touchUpImageFilesArray['Invoice']["FilePath"], $touchUpImageFilesArray['Invoice']["FileName"]);
            upload_file($uploadPath . "Invoice/", $invoiceUploadTmp, $invoiceUploadName);
        }
        if(!empty($before1UploadTmp)){
            remove_file($touchUpImageFilesArray['Before1']["FilePath"], $touchUpImageFilesArray['Before1']["FileName"]);
            upload_file($uploadPath . "Before/" . "1/", $before1UploadTmp, $before1UploadName);
        }
        if(!empty($before2UploadTmp)){
            remove_file($touchUpImageFilesArray['Before2']["FilePath"], $touchUpImageFilesArray['Before2']["FileName"]);
            upload_file($uploadPath . "Before/" . "2/", $before2UploadTmp, $before2UploadName);
        }
        if(!empty($before3UploadTmp)){
            remove_file($touchUpImageFilesArray['Before3']["FilePath"], $touchUpImageFilesArray['Before3']["FileName"]);
            upload_file($uploadPath . "Before/" . "3/", $before3UploadTmp, $before3UploadName);
        }
        if(!empty($before4UploadTmp)){
            remove_file($touchUpImageFilesArray['Before4']["FilePath"], $touchUpImageFilesArray['Before4']["FileName"]);
            upload_file($uploadPath . "Before/" . "4/", $before4UploadTmp, $before4UploadName);
        }
        if(!empty($before5UploadTmp)){
            remove_file($touchUpImageFilesArray['Before5']["FilePath"], $touchUpImageFilesArray['Before5']["FileName"]);
            upload_file($uploadPath . "Before/" . "5/", $before5UploadTmp, $before5UploadName);
        }
        if(!empty($after1UploadTmp)) {
            remove_file($touchUpImageFilesArray['After1']["FilePath"], $touchUpImageFilesArray['After1']["FileName"]);
            upload_file($uploadPath . "After/" . "1/", $after1UploadTmp, $after1UploadName);
        }
        if(!empty($after2UploadTmp)){
            remove_file($touchUpImageFilesArray['After2']["FilePath"], $touchUpImageFilesArray['After2']["FileName"]);
            upload_file($uploadPath . "After/" . "2/", $after2UploadTmp, $after2UploadName);
        }
        if(!empty($after3UploadTmp)){
            remove_file($touchUpImageFilesArray['After3']["FilePath"], $touchUpImageFilesArray['After3']["FileName"]);
            upload_file($uploadPath . "After/" . "3/", $after3UploadTmp, $after3UploadName);
        }
        if(!empty($after4UploadTmp)){
            remove_file($touchUpImageFilesArray['After4']["FilePath"], $touchUpImageFilesArray['After4']["FileName"]);
            upload_file($uploadPath . "After/" . "4/", $after4UploadTmp, $after4UploadName);
        }
        if(!empty($after5UploadTmp)) {
            remove_file($touchUpImageFilesArray['After5']["FilePath"], $touchUpImageFilesArray['After5']["FileName"]);
            upload_file($uploadPath . "After/" . "5/", $after5UploadTmp, $after5UploadName);
        }

        $updateServiceInvoiceResult = update_service_invoice($serviceID, $uploadPath . "Invoice/");
        $updateServiceImageResult = update_service_image($serviceID, $uploadPath);
        header('location: ' . $PageURL . '/?CID=' . $MLS);
    }

    if(isset($_POST['submit_yard_work'])){
        global $PageURL;
        $serviceID = $yardWorkServiceArray['ServiceID'];
        $uploadPath = $uploadBasePath . "/YardWork/";

        $invoiceUploadTmp = $_FILES['upload_yard_work_invoice']['tmp_name'];
        $invoiceUploadName = preg_replace("#[^a-z0-9.]#i", "",  time() . '_' . $_FILES['upload_yard_work_invoice']['name']);

        $beforeFrontYardUploadTmp = $_FILES['upload_yard_work_before_front']['tmp_name'];
        $beforeFrontYardUploadName = preg_replace("#[^a-z0-9.]#i", "",  time() . '_' . $_FILES['upload_yard_work_before_front']['name']);

        $beforeBackYardUploadTmp = $_FILES['upload_yard_work_before_back']['tmp_name'];
        $beforeBackYardUploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_yard_work_before_back']['name']);

        $afterFrontYardUploadTmp = $_FILES['upload_yard_work_after_front']['tmp_name'];
        $afterFrontYardUploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_yard_work_after_front']['name']);

        $afterBackYardUploadTmp = $_FILES['upload_yard_work_after_back']['tmp_name'];
        $afterBackYardUploadName = preg_replace("#[^a-z0-9.]#i", "", time() . '_' . $_FILES['upload_yard_work_after_back']['name']);

        if(!empty($invoiceUploadTmp)){
            remove_file($yardWorkImageFilesArray['Invoice']["FilePath"], $yardWorkImageFilesArray['Invoice']["FileName"]);
            upload_file($uploadPath . "Invoice/", $invoiceUploadTmp, $invoiceUploadName);
        }
        if(!empty($beforeFrontYardUploadTmp)){
            remove_file($yardWorkImageFilesArray['BeforeFrontYard']["FilePath"], $yardWorkImageFilesArray['BeforeFrontYard']["FileName"]);
            upload_file($uploadPath . "Before/" . "FrontYard/", $beforeFrontYardUploadTmp, $beforeFrontYardUploadName);
        }
        if(!empty($beforeBackYardUploadTmp)){
            remove_file($yardWorkImageFilesArray['BeforeBackYard']["FilePath"], $yardWorkImageFilesArray['BeforeBackYard']["FileName"]);
            upload_file($uploadPath . "Before/" . "BackYard/", $beforeBackYardUploadTmp, $beforeBackYardUploadName);
        }
        if(!empty($afterFrontYardUploadTmp)){
            remove_file($yardWorkImageFilesArray['AfterFrontYard']["FilePath"], $yardWorkImageFilesArray['AfterFrontYard']["FileName"]);
            upload_file($uploadPath . "After/" . "FrontYard/", $afterFrontYardUploadTmp, $afterFrontYardUploadName);
        }
        if(!empty($afterBackYardUploadTmp)){
            remove_file($yardWorkImageFilesArray['AfterBackYard']["FilePath"], $yardWorkImageFilesArray['AfterBackYard']["FileName"]);
            upload_file($uploadPath . "After/" . "BackYard/", $afterBackYardUploadTmp, $afterBackYardUploadName);
        }

        $updateServiceInvoiceResult = update_service_invoice($serviceID, $uploadPath . "Invoice/");
        $updateServiceImageResult = update_service_image($serviceID, $uploadPath);
        header('location: ' . $PageURL . '/?CID=' . $MLS);
    }

    if(isset($_POST['submit_inspection'])){
        global $PageURL;
        $serviceID = $inspectionServiceArray['ServiceID'];
        $uploadPath = $uploadBasePath . "/Inspection/";

        $reportUploadTmp = $_FILES['upload_inspection_report']['tmp_name'];
        $reportUploadName = preg_replace("#[^a-z0-9.]#i", "",  time() . '_' . $_FILES['upload_inspection_report']['name']);

        $invoiceUploadTmp = $_FILES['upload_inspection_invoice']['tmp_name'];
        $invoiceUploadName = preg_replace("#[^a-z0-9.]#i", "",  time() . '_' . $_FILES['upload_inspection_invoice']['name']);

        if(!empty($reportUploadTmp)){
            remove_file($inspectionImageFilesArray['Report']["FilePath"], $inspectionImageFilesArray['Report']["FileName"]);
            upload_file($uploadPath . "Report/", $reportUploadTmp, $reportUploadName);
        }
        if(!empty($invoiceUploadTmp)){
            remove_file($inspectionImageFilesArray['Invoice']["FilePath"], $inspectionImageFilesArray['Invoice']["FileName"]);
            upload_file($uploadPath . "Invoice/", $invoiceUploadTmp, $invoiceUploadName);
        }

        $updateServiceInvoiceResult = update_service_invoice($serviceID, $uploadPath . "Invoice/");
        $updateServiceImageResult = update_service_image($serviceID, $uploadPath . "Report/"); // For Report
        header('location: ' . $PageURL . '/?CID=' . $MLS);
    }

    if(isset($_POST['submit_storage'])) {
        global $PageURL;
        $serviceID = $storageServiceArray['ServiceID'];
        $uploadPath = $uploadBasePath . "/Storage/";

        $invoiceUploadTmp = $_FILES['upload_storage_invoice']['tmp_name'];
        $invoiceUploadName = preg_replace("#[^a-z0-9.]#i", "",  time() . '_' . $_FILES['upload_storage_invoice']['name']);

        if(!empty($invoiceUploadTmp)){
            remove_file($storageImageFilesArray['Invoice']["FilePath"], $storageImageFilesArray['Invoice']["FileName"]);
            upload_file($uploadPath . "Invoice/", $invoiceUploadTmp, $invoiceUploadName);
        }

        $updateServiceInvoiceResult = update_service_invoice($serviceID, $uploadPath . "Invoice/");
        $updateServiceImageResult = update_service_image($serviceID, $uploadPath);
        header('location: ' . $PageURL . '/?CID=' . $MLS);
    }

    if (isset($_POST['submit_relocate_home'])) {
        global $PageURL;
        $serviceID = $relocateHomeServiceArray['ServiceID'];
        $uploadPath = $uploadBasePath . "/RelocateHome/";

        $invoiceUploadTmp = $_FILES['upload_relocate_home_invoice']['tmp_name'];
        $invoiceUploadName = preg_replace("#[^a-z0-9.]#i", "",  time() . '_' . $_FILES['upload_relocate_home_invoice']['name']);

        if(!empty($invoiceUploadTmp)){
            remove_file($relocateHomeImageFilesArray['Invoice']["FilePath"], $relocateHomeImageFilesArray['Invoice']["FileName"]);
            upload_file($uploadPath . "Invoice/", $invoiceUploadTmp, $invoiceUploadName);
        }

        $updateServiceInvoiceResult = update_service_invoice($serviceID, $uploadPath . "Invoice/");
        $updateServiceImageResult = update_service_image($serviceID, $uploadPath);
        header('location: ' . $PageURL . '/?CID=' . $MLS);
    }

?>
<!DOCTYPE html>
<style type="text/css">
    /*------------------------------------nav bar css---------------------------------*/
    html, body {
        margin: 0;
        padding: 0;
        background-color: #eeeeee !important;
        font-family: Arial !important;
    }

    #container {
        margin-left: 230px;
        _zoom: 1;
    }

    #nav {
        float: left;
        width: 230px;
        height: 100%;
        background: #32323a;
        margin-left: -230px;
        position: fixed;
        margin-top: -89px;
    }

    #main {
        height: 400px;
    }

    /* style icon */
    .inner-addon .glyphicon {
        position: absolute;
        padding: 10px;
        pointer-events: none;
    }

    /* align icon */
    .left-addon .glyphicon {
        left: 0px;
    }

    /* add padding  */
    .left-addon input {
        padding-left: 30px;
    }

    a {
        letter-spacing: 1px;
    }

    .logo {
        height: 120px;
        width: 230px;
        padding-top: 20px;
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 20px;
        display: block;
        background-color: #28282e;
    }

        .logo img {
            width: 100%;
        }

    .nav-pills {
        background-color: #32323a;
        border-color: #030033;
    }

        .nav-pills > li > a {
            color: #95a0aa; /*Change active text color here*/
        }

    .navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus {
        color: #000; /*Sets the text hover color on navbar*/
    }

    li {
        border-bottom: 1px #2a2a31 solid;
    }

    .footer {
        position: absolute;
        bottom: 0px;
        left: 0;
        right: 0;
        margin: 0 auto;
        text-align: center;
    }

    .copyRight {
        color: white;
    }

    .formPart {
    }

    th {
        color: white;
        font-size: 11px;
        text-align: center;
    }

    .userNamePart {
        color: white;
        text-align: center;
        margin-bottom: 20px;
    }

    /*--------------------------template css for all page----------------------*/

    .title {
        padding: 5px 0 5px 0;
        margin-top: 89px;
        margin-left: 23px;
        background-color: #fff;
        border-left: 5px #0068b7 solid;
        border-bottom: 1px #eeeeee solid;
        width: 600px;
    }

    .titleSize {
        font-size: 20px;
        margin: 0px;
        padding-left: 23px;
    }

    .contentPart {
        padding-top: 20px;
        background-color: #fff;
        color: #a9a9a9;
        height: 400px;
        width: 600px;
        font-size: 12px;
        margin-left: 23px;
    }


    /*--------------------------template-agent-create-case----------------------*/

    .inputPart {
        padding-top: 20px;
        background-color: #fff;
        color: #a9a9a9;
        height: 400px;
        width: 600px;
        font-size: 12px;
        margin-left: 23px;
    }

    .oneLineDiv {
        display: relative;
        height: 45px;
        padding: 0px;
        margin: 0px;
        vertical-align: middle;
        padding: 10px 0 0 0;
    }

    .requireTitle {
        height: 30px;
        padding-left: 23px;
        float: left;
        vertical-align: middle;
        line-height: 30px;
        display: absolute;
    }

    .inputContent {
        display: absolute;
        padding: 0 0 0 143px;
        margin: 0px;
        width: 150px;
    }

    .secondTitle {
        margin: -30px 0 0 280px;
    }

    .secondInput {
        margin: -30px 0 0 415px;
    }

    input {
        border-radius: 3px;
        border: 1px #a9a9a9 solid;
        width: 150px;
        height: 30px;
    }

    fieldset {
        overflow: hidden;
    }

    .dropdown {
        height: 30px;
        width: 150px;
    }

    select {
        border-radius: 3px;
        height: 30px;
        width: 150px;
    }

    .createButton {
        border-radius: 5px;
        background-color: #32323a;
        border: #32323a;
        color: #fff;
        font-weight: 100px;
        height: 30px;
        width: 150px;
    }

    .PropertyType select {
        border-radius: 3px;
        height: 30px;
        width: 150px;
    }

    .coListingTitle {
        margin-top: -60px;
        margin-left: 290px;
    }

    .photoUploadButton {
        font-size: 11px;
        color: #a9a9a9;
        background-color: #fff;
        border: 1px #a9a9a9 solid;
        width: 150px;
        height: 30px;
        border-radius: 3px;
    }

    .error-message a {
        color: red;
        font-size: 80%;
    }


    /*------------------------------------table page css--------------------------------------*/
    .tablePageTitle {
        width: 800px;
        margin: 0 auto;
    }

    .title img {
        width: 100%;
    }

    .tablePart table {
        text-align: center;
        border: 1px #000 solid;
        width: 800px;
        margin: 0 auto;
    }

    /*------------------------------------File Approvement Admin css--------------------------------------*/

    .FAFContentPart {
        padding-top: 20px;
        background-color: #fff;
        color: #a9a9a9;
        height: 240px;
        width: 750px;
        font-size: 12px;
        margin-left: 23px;
        border-bottom: 1px #eeeeee solid;
    }
    /*File Approvement Page First Title*/
    .FAFTitle {
        padding: 5px 0 5px 0;
        margin-top: 89px;
        margin-left: 23px;
        background-color: #fff;
        border-left: 5px #0068b7 solid;
        border-bottom: 1px #eeeeee solid;
        width: 750px;
    }

    .FANormalTitle {
        padding: 5px 0 5px 0;
        margin-top: 25px;
        margin-left: 23px;
        background-color: #fff;
        border-left: 5px #0068b7 solid;
        border-bottom: 1px #eeeeee solid;
        width: 750px;
    }

    .FASContentPart {
        padding-top: 10px;
        background-color: #fff;
        color: #a9a9a9;
        height: 270px;
        width: 750px;
        font-size: 12px;
        margin-left: 23px;
        border-bottom: 1px #eeeeee solid;
    }

    .table-striped {
        width: 775px !important;
        padding-left: 20px;
        margin-left: 20px;
    }

        .table-striped th {
            font-size: 10px;
            color: #a9a9a9;
        }

        .table-striped td {
            color: #a9a9a9;
        }

    .houseInfo .table-striped tr {
        font-size: 10px;
        color: #a9a9a9;
    }

    .houseInfo .table-striped th {
        font-size: 10px;
        color: #a9a9a9;
    }

    .houseInfo .table-striped td {
        padding-top: 2px !important;
        padding-bottom: 2px !important;
    }

    .houseInfo .table-striped {
        /*  margin-top: 0px;
            margin-left: 0px;*/
        width: 400px !important;
        height: 200px !important;
        color: #a9a9a9;
    }

    .houseInfo {
        width: 100%;
        overflow: hidden;
        padding-left: 20px;
        background-color: #fff;
    }

    .houseImg {
        height: 200px;
        width: 300px;
        float: left;
        /*padding-top:25px;*/
    }

        .houseImg img {
            width: 100%;
        }

    .houseTable {
        width: 300px;
        margin-left: 300px;
    }



    .FAFSubTitle {
        font-weight: bold;
        padding-left: 23px;
        float: left;
        padding-top: 5px;
        width: 100px;
    }

    .FASubTitleUpload {
        margin-left: 10px;
        width: 130px;
        float: left;
        padding-top: 5px;
    }

    .FASelectType {
        height: 30px;
        width: 80px;
        margin-left: 360px;
    }

        .FASelectType select {
            border-radius: 3px;
            height: 30px;
            width: 80px;
        }

    .FASCPSLine {
        float: left;
        height: 100px;
        width: 750px;
        margin-top: 10px;
        margin-left: 20px;
    }

    .FASSubTitle {
        font-weight: bold;
        padding-left: 23px;
        float: left;
        padding-top: 5px;
        color: #a9a9a9;
    }

    .FAImage {
        float: left;
        height: 70px;
        width: 130px;
        border: 1px blue dashed;
        margin: 0 25px;
    }

    .FAtable {
        float: left;
    }


        .FAtable td {
            padding-top: 5px;
            padding-bottom: 5px;
            text-align: center;
        }

    .FASCPTLine {
        float: left;
        height: 100px;
        width: 750px;
        margin-top: 10px;
        margin-left: 20px;
    }

    .FATContentPart {
        padding-top: 10px;
        background-color: #fff;
        color: #a9a9a9;
        height: 270px;
        width: 750px;
        font-size: 12px;
        margin-left: 23px;
        border-bottom: 1px #eeeeee solid;
    }

    .FAFoContentPart {
        padding-top: 10px;
        background-color: #fff;
        color: #a9a9a9;
        height: 270px;
        width: 750px;
        font-size: 12px;
        margin-left: 23px;
        border-bottom: 1px #eeeeee solid;
    }

    .FAImageTouchUp {
        float: left;
        height: 70px;
        width: 80px;
        border: 1px blue dashed;
        margin: 0 25px;
    }

    .FAImageYardWork {
        float: left;
        height: 80px;
        width: 170px;
        border: 1px blue dashed;
        margin: 0 25px;
    }

    .FASubTitleInsoection {
        margin-left: 10px;
        width: 150px;
        float: left;
        padding-top: 5px;
    }

    .FASubTitleInvoice {
        margin-left: 20px;
        width: 150px;
        float: left;
        padding-top: 5px;
    }

    .FASelectTypeInspection {
        height: 30px;
        width: 80px;
        margin-left: 145px;
    }

    .FAFiContentPart {
        padding-top: 10px;
        background-color: #fff;
        color: #a9a9a9;
        height: 280px;
        width: 750px;
        font-size: 12px;
        margin-left: 23px;
        border-bottom: 1px #eeeeee solid;
    }

    .FASixContentPart {
        padding-top: 10px;
        background-color: #fff;
        color: #a9a9a9;
        height: 50px;
        width: 750px;
        font-size: 12px;
        margin-left: 23px;
        border-bottom: 1px #eeeeee solid;
    }

    .FASubTitleStoageInvoice {
        margin-left: 10px;
        width: 70px;
        float: left;
        padding-top: 5px;
    }

    .FASelectTypeStorage {
        height: 30px;
        width: 80px;
        margin-left: 315px;
    }

    .approveButton {
        height: 30px;
        width: 120px;
        background-color: #32323a;
        color: #fff;
        font-size: 12px;
        float: left;
        border: 1px solid #32323a;
        margin-left: 20px;
        border-radius: 3px;
    }

    .submitChangeButton {
        height: 30px;
        width: 120px;
        background-color: #32323a;
        color: #fff;
        font-size: 12px;
        border: 1px solid #32323a;
        margin-left: 10px;
        border-radius: 3px;
    }

    .FASevenContentPart {
        padding-top: 10px;
        background-color: #fff;
        color: #a9a9a9;
        height: 60px;
        width: 750px;
        font-size: 12px;
        margin-left: 23px;
        border-bottom: 1px #eeeeee solid;
    }


    /*----------------------------------------File Upload Agent---------------------------------------*/

    .FUASaveButton {
        height: 25px;
        width: 80px;
        background-color: #32323a;
        color: #fff;
        font-size: 12px;
        float: left;
        border: 1px solid #32323a;
        margin-left: 10px;
        border-radius: 3px;
    }

    .FUAChooseFileButton {
        border-radius: 3px;
        height: 17px;
        width: 130px;
        margin: 0 25px;
        font-size: 9px;
    }

    .TouchUpButtonStyle {
        margin-left: 0px;
        margin-right: 5px;
    }

    .inspectionButtonStyle {
        margin-left: 120px;
        margin-top: 20px;
    }

    .inspectionStyle {
        margin-left: 0px;
    }

    .FUSixContentPart {
        padding-top: 10px;
        background-color: #fff;
        color: #a9a9a9;
        height: 60px;
        width: 750px;
        font-size: 12px;
        margin-left: 23px;
        border-bottom: 1px #eeeeee solid;
    }

    .storageButtonStyle {
        margin-left: 215px;
        margin-top: -10px;
    }

    .storageInputFileStyle {
        float: left;
        margin-left: 0px;
        margin-top: 5px;
    }
    /*----------------------------------------File Upload Agent New---------------------------------------*/
    .FUAInputOnOneLine {
        border-radius: 3px;
        height: 17px;
        width: 130px;
        margin: 2px 0px 0px 10px;
        font-size: 9px;
        float: left;
    }

    .FUAChooseFileButtonTouchUp {
        border-radius: 3px;
        height: 17px;
        width: 120px;
        margin: 0 5px;
        font-size: 9px;
    }

    .FUSixContentPartNew {
        padding-top: 10px;
        background-color: #fff;
        color: #a9a9a9;
        height: 80px;
        width: 750px;
        font-size: 12px;
        margin-left: 23px;
        border-bottom: 1px #eeeeee solid;
    }

    .upload{
            text-align: center;
    padding-top: 3px;
    font-weight: 500;
    }

    .uploadLabel{
        float: left;
    height: 70px;
    width: 130px;
    border: 1px blue dashed;
    margin: 0 25px;
    padding-top: 25px;
    }

    .imgsmall{
        width:80px;
    }
    
    .largeimg{
        width:130px;
        height:70px;
        margin:0 25px;
    }
    
    .smallimg{
        width:80px;
        height:70px;
        margin:0 25px;
    }
</style>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <title>NuStream 新勢力地產</title>
    <!--    <link rel="stylesheet" type="text/css" href="css/pcStyles.css">-->
</head>
<body>
    <div id="container">
        <?php
        include_once(__DIR__ . '/navigation.php');
        ?>
        <div id="main">
            <div class="formPart">
                <div class="FAFTitle">
                    <p class="titleSize">BASIC INFO</p>
                </div>
                <div class="FAFContentPart ">
                    <div class="houseInfo">
                        <div class="houseImg">
                            <?php
                            if(!empty($caseDetailsArray['Images'])){
                            echo '<img src="' . $houseImageURL . $caseDetailsArray['Images'] . '">';
                            }else{
                            echo '<img src="' . $defaultHouseImageURL . '">';
                            }
                            ?>
                        </div>
                        <div class="houseTable">
                            <div style="width:300px; padding:0px;"><h5 style="z-index:100;color:#a9a9a9; margin-top:0px; margin-left:10px;">HOUSE INFORMATION</h5></div>
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td>MLS#</td>
                                        <td><?php echo $caseDetailsArray['MLS'];?></td>
                                    </tr>
                                    <tr>
                                        <td>ADDRESS</td>
                                        <td><?php echo $caseDetailsArray['Address'];?></td>
                                    </tr>
                                    <tr>
                                        <td>PROPERTY TYPE</td>
                                        <td><?php echo $caseDetailsArray['PropertyType'];?></td>
                                    </tr>
                                    <tr>
                                        <td>LAND SIZE (LOT)</td>
                                        <td><?php echo $caseDetailsArray['LandSize'];?></td>
                                    </tr>
                                    <tr>
                                        <td>HOUSE SIZE(SQF)</td>
                                        <td><?php echo $caseDetailsArray['HouseSize'];?></td>
                                    </tr>
                                    <tr>
                                        <td>LISTING PRICE</td>
                                        <td><?php echo $caseDetailsArray['ListingPrice'];?></td>
                                    </tr>
                                    <tr>
                                        <td>OWNER'S NAME</td>
                                        <td><?php echo $caseDetailsArray['OwnerName'];?></td>
                                    </tr>
                                    <tr>
                                        <td>TEAM MEMBER'S NAME</td>
                                        <td><?php echo $caseDetailsArray['CoStaffName'];?></td>
                                    </tr>
                                    <tr>
                                        <td>SELLING LISTING RATE</td>
                                        <td><?php echo $caseDetailsArray['CommissionRate'] . "%";?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="FANormalTitle">
                    <p class="titleSize">FILE UPLOAD</p>
                </div>
                <form method="post" enctype="multipart/form-data" name="FileUploadFrom">
                    <div class="FASContentPart">
                        <div class="FASCPFLine">
                            <p class="FAFSubTitle">STAGING</p>
                            <p class="FASubTitleUpload">
                                <?php
                                if(!empty($stagingImageFilesArray['Invoice']["FileName"])){
                                echo '<a>Invoice uploaded</a>';
                                }
                                else{
                                echo '<a>No Invoice uploaded</a>';
                                }
                                ?>

                            </p>
                            <label for="stagingupload" class="FUASaveButton upload">Upload</label>
                            <input style="display:none" id="stagingupload" type="file" name="upload_staging_invoice" class="FUAInputOnOneLine">
                            <input type="submit" name="submit_staging" value="SAVE" class="FUASaveButton">
                        </div>
                        <div class="FASCPSLine">
                            <table class="FAtable">
                                <tr>
                                    <td>BEFORE</td>
                                    <td>
                                        <?php
                                        if(!empty($stagingImageFilesArray['BeforeLivingRoom']["FileName"]))
                                        echo '<img up="stagingb1" src="' . get_home_url() . "/" . $stagingImageFilesArray['BeforeLivingRoom']["FileName"] . '" class="FAImage">';
                                        else
                                        echo '<label up="stagingb1" class="uploadLabel">LIVING ROOM</label>';
                                        ?>
                                        <img upimg="stagingb1" src="" class="largeimg" />
                                    </td>
                                    <td>
                                        <?php
                                        if(!empty($stagingImageFilesArray['BeforeDinningRoom']["FileName"]))
                                        echo '<img up="stagingb2" src="' . get_home_url() . "/" . $stagingImageFilesArray['BeforeDinningRoom']["FileName"] . '" class="FAImage">';
                                        else
                                        echo '<label up="stagingb2" class="uploadLabel">DINING ROOM</label>';
                                        ?>
                                        <img upimg="stagingb2" src="" class="largeimg" />
                                    </td>
                                    <td>
                                        <?php
                                        if(!empty($stagingImageFilesArray['BeforeMasterRoom']["FileName"]))
                                        echo '<img up="stagingb3" src="' . get_home_url() . "/" . $stagingImageFilesArray['BeforeMasterRoom']["FileName"] . '" class="FAImage">';
                                        else
                                        echo '<label up="stagingb3" class="uploadLabel">MASTER ROOM</label>';
                                        ?>
                                        <img upimg="stagingb3" src="" class="largeimg" />
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><input style="display:none" id="stagingb1" type="file" name="upload_staging_before_living_room" class="FUAChooseFileButton"></td>
                                    <td><input style="display:none" id="stagingb2" type="file" name="upload_staging_before_dinning_room" class="FUAChooseFileButton"></td>
                                    <td><input style="display:none" id="stagingb3" type="file" name="upload_staging_before_master_room" class="FUAChooseFileButton"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="FASCPTLine">
                            <table class="FAtable">
                                <tr>
                                    <td>AFTER&nbsp;&nbsp;&nbsp;</td>
                                    <td>
                                        <?php
                                        if(!empty($stagingImageFilesArray['AfterLivingRoom']["FileName"]))
                                        echo '<img up="staa1" src="' . get_home_url() . "/" . $stagingImageFilesArray['AfterLivingRoom']["FileName"] . '" class="FAImage">';
                                        else
                                        echo '<label up="staa1" class="uploadLabel">LIVING ROOM</label>';
                                        ?>
                                        <img upimg="staa1" src="" class="largeimg" />
                                    </td>
                                    <td>
                                        <?php
                                        if(!empty($stagingImageFilesArray['AfterDinningRoom']["FileName"]))
                                        echo '<img up="staa2" src="' . get_home_url() . "/" . $stagingImageFilesArray['AfterDinningRoom']["FileName"] . '" class="FAImage">';
                                        else
                                        echo '<label up="staa2" class="uploadLabel">DINING ROOM</label>';
                                        ?>
                                        <img upimg="staa2" src="" class="largeimg" />
                                    </td>
                                    <td>
                                        <?php
                                        if(!empty($stagingImageFilesArray['AfterMasterRoom']["FileName"]))
                                        echo '<img up="staa3" src="' . get_home_url() . "/" . $stagingImageFilesArray['AfterMasterRoom']["FileName"] . '" class="FAImage">';
                                        else
                                        echo '<label up="staa3" class="uploadLabel">MASTER ROOM</label>';
                                        ?>
                                        <img upimg="staa3" src="" class="largeimg" />
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><input style="display:none" id="staa1" type="file" name="upload_staging_after_living_room" class="FUAChooseFileButton"></td>
                                    <td><input style="display:none" id="staa2" type="file" name="upload_staging_after_dinning_room" class="FUAChooseFileButton"></td>
                                    <td><input style="display:none" id="staa3" type="file" name="upload_staging_after_master_room" class="FUAChooseFileButton"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="FATContentPart">
                        <div class="FASCPFLine">
                            <p class="FAFSubTitle">CLEAN UP</p>
                            <p class="FASubTitleUpload">
                                <?php
                                if(!empty($cleanUpImageFilesArray['Invoice']["FileName"])){
                                echo '<a>Invoice uploaded</a>';
                                }
                                else{
                                echo '<a>No Invoice uploaded</a>';
                                }
                                ?>

                            </p>
                            <label for="cleanupupload" class="FUASaveButton upload">Upload</label>
                            <input style="display:none" id="cleanupupload" type="file" name="upload_clean_up_invoice" class="FUAInputOnOneLine">
                            <input type="submit" name="submit_clean_up" value=" SAVE " class="FUASaveButton">
                        </div>
                        <div class="FASCPSLine">
                            <table class="FAtable">
                                <tr>
                                    <td>BEFORE</td>
                                    <td>
                                        <?php
                                        if(!empty($cleanUpImageFilesArray['BeforeLivingRoom']["FileName"]))
                                        echo '<img up="cleb1" src="' . get_home_url() . "/" . $cleanUpImageFilesArray['BeforeLivingRoom']["FileName"] . '" class="FAImage">';
                                        else
                                        echo '<label up="cleb1" class="uploadLabel">LIVING ROOM</label>';
                                        ?>
                                        <img upimg="cleb1" src="" class="largeimg" />
                                    </td>
                                    <td>
                                        <?php
                                        if(!empty($cleanUpImageFilesArray['BeforeKitchen']["FileName"]))
                                        echo '<img up="cleb2" src="' . get_home_url() . "/" . $cleanUpImageFilesArray['BeforeKitchen']["FileName"] . '" class="FAImage">';
                                        else
                                        echo '<label up="cleb2" class="uploadLabel">KITCHEN</label>';
                                        ?>
                                        <img upimg="cleb2" src="" class="largeimg" />
                                    </td>
                                    <td>
                                        <?php
                                        if(!empty($cleanUpImageFilesArray['BeforeWashRoom']["FileName"]))
                                        echo '<img up="cleb3" src="' . get_home_url() . "/" . $cleanUpImageFilesArray['BeforeWashRoom']["FileName"] . '" class="FAImage">';
                                        else
                                        echo '<label up="cleb3" class="uploadLabel">WASHROOM</label>';
                                        ?>
                                        <img upimg="cleb3" src="" class="largeimg" />
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><input style="display:none" id="cleb1" type="file" name="upload_clean_up_before_living_room" class="FUAChooseFileButton"></td>
                                    <td><input style="display:none" id="cleb2" type="file" name="upload_clean_up_before_kitchen" class="FUAChooseFileButton"></td>
                                    <td><input style="display:none" id="cleb3" type="file" name="upload_clean_up_before_wash_room" class="FUAChooseFileButton"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="FASCPTLine">
                            <table class="FAtable">
                                <tr>
                                    <td>AFTER&nbsp;&nbsp;&nbsp;</td>
                                    <td>
                                        <?php
                                        if(!empty($cleanUpImageFilesArray['AfterLivingRoom']["FileName"]))
                                        echo '<img up="clea1" src="' . get_home_url() . "/" . $cleanUpImageFilesArray['AfterLivingRoom']["FileName"] . '" class="FAImage">';
                                        else
                                        echo '<label up="clea1" class="uploadLabel">LIVING ROOM</label>';
                                        ?>
                                        <img upimg="clea1" src="" class="largeimg" />
                                    </td>
                                    <td>
                                        <?php
                                        if(!empty($cleanUpImageFilesArray['AfterKitchen']["FileName"]))
                                        echo '<img up="clea2" src="' . get_home_url() . "/" . $cleanUpImageFilesArray['AfterKitchen']["FileName"] . '" class="FAImage">';
                                        else
                                        echo '<label up="clea2" class="uploadLabel">KITCHEN</label>';
                                        ?>
                                        <img upimg="clea2" src="" class="largeimg" />
                                    </td>
                                    <td>
                                        <?php
                                        if(!empty($cleanUpImageFilesArray['AfterWashRoom']["FileName"]))
                                        echo '<img up="clea3" src="' . get_home_url() . "/" . $cleanUpImageFilesArray['AfterWashRoom']["FileName"] . '" class="FAImage">';
                                        else
                                        echo '<label up="clea3" class="uploadLabel">WASHROOM</label>';
                                        ?>
                                        <img upimg="clea3" src="" class="largeimg" />
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><input style="display:none" id="clea1" type="file" name="upload_clean_up_after_living_room" class="FUAChooseFileButton"></td>
                                    <td><input style="display:none" id="clea2" type="file" name="upload_clean_up_after_kitchen" class="FUAChooseFileButton"></td>
                                    <td><input style="display:none" id="clea3" type="file" name="upload_clean_up_after_wash_room" class="FUAChooseFileButton"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="FAFoContentPart">
                        <div class="FASCPFLine">
                            <p class="FAFSubTitle">TOUCH UP</p>
                            <p class="FASubTitleUpload">
                                <?php
                                if(!empty($touchUpImageFilesArray['Invoice']["FileName"])){
                                echo '<a>Invoice uploaded</a>';
                                }
                                else{
                                echo '<a>No Invoice uploaded</a>';
                                }
                                ?>

                            </p>
                            <label for="touchupupload" class="FUASaveButton upload">Upload</label>
                            <input style="display:none" id="touchupupload" type="file" name="upload_touch_up_invoice" class="FUAInputOnOneLine">
                            <input type="submit" name="submit_touch_up" value=" SAVE " class="FUASaveButton">
                        </div>
                        <div class="FASCPSLine">
                            <table class="FAtable">
                                <tr>
                                    <td>BEFORE</td>
                                    <td>
                                        <?php
                                        if(!empty($touchUpImageFilesArray['Before1']["FileName"]))
                                        echo '<img up="toub1" src="' . get_home_url() . "/" . $touchUpImageFilesArray['Before1']["FileName"] . '" class="FAImageTouchUp">';
                                        else
                                        echo '<label up="toub1" class="uploadLabel imgsmall">1</label>';
                                        ?>
                                        <img upimg="toub1" src="" class="smallimg" />
                                    </td>
                                    <td>
                                        <?php
                                        if(!empty($touchUpImageFilesArray['Before2']["FileName"]))
                                        echo '<img up="toub2" src="' . get_home_url() . "/" . $touchUpImageFilesArray['Before2']["FileName"] . '" class="FAImageTouchUp">';
                                        else
                                        echo '<label up="toub2" class="uploadLabel imgsmall">2</label>';
                                        ?>
                                        <img upimg="toub2" src="" class="smallimg" />
                                    </td>
                                    <td>
                                        <?php
                                        if(!empty($touchUpImageFilesArray['Before3']["FileName"]))
                                        echo '<img up="toub3" src="' . get_home_url() . "/" . $touchUpImageFilesArray['Before3']["FileName"] . '" class="FAImageTouchUp">';
                                        else
                                        echo '<label up="toub3" class="uploadLabel imgsmall">3</label>';
                                        ?>
                                        <img upimg="toub3" src="" class="smallimg" />
                                    </td>
                                    <td>
                                        <?php
                                        if(!empty($touchUpImageFilesArray['Before4']["FileName"]))
                                        echo '<img up="toub4" src="' . get_home_url() . "/" . $touchUpImageFilesArray['Before4']["FileName"] . '" class="FAImageTouchUp">';
                                        else
                                        echo '<label up="toub4" class="uploadLabel imgsmall">4</label>';
                                        ?>
                                        <img upimg="toub4" src="" class="smallimg" />
                                    </td>
                                    <td>
                                        <?php
                                        if(!empty($touchUpImageFilesArray['Before5']["FileName"]))
                                        echo '<img up="toub5" src="' . get_home_url() . "/" . $touchUpImageFilesArray['Before5']["FileName"] . '" class="FAImageTouchUp">';
                                        else
                                        echo '<label up="toub5" class="uploadLabel imgsmall">5</label>';
                                        ?>
                                        <img upimg="toub5" src="" class="smallimg" />
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><input style="display:none" id="toub1" type="file" name="upload_touch_up_before_1" class="FUAChooseFileButtonTouchUp"></td>
                                    <td><input style="display:none" id="toub2" type="file" name="upload_touch_up_before_2" class="FUAChooseFileButtonTouchUp"></td>
                                    <td><input style="display:none" id="toub3" type="file" name="upload_touch_up_before_3" class="FUAChooseFileButtonTouchUp"></td>
                                    <td><input style="display:none" id="toub4" type="file" name="upload_touch_up_before_4" class="FUAChooseFileButtonTouchUp"></td>
                                    <td><input style="display:none" id="toub5" type="file" name="upload_touch_up_before_5" class="FUAChooseFileButtonTouchUp"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="FASCPTLine">
                            <table class="FAtable">
                                <tr>
                                    <td>AFTER&nbsp;&nbsp;&nbsp;</td>
                                    <td>
                                        <?php
                                        if(!empty($touchUpImageFilesArray['After1']["FileName"]))
                                        echo '<img up="toua1" src="' . get_home_url() . "/" . $touchUpImageFilesArray['After1']["FileName"] . '" class="FAImageTouchUp">';
                                        else
                                        echo '<label up="toua1" class="uploadLabel imgsmall">1</label>';
                                        ?>
                                        <img upimg="toua1" src="" class="smallimg" />
                                    </td>
                                    <td>
                                        <?php
                                        if(!empty($touchUpImageFilesArray['After2']["FileName"]))
                                        echo '<img up="toua2" src="' . get_home_url() . "/" . $touchUpImageFilesArray['After2']["FileName"] . '" class="FAImageTouchUp">';
                                        else
                                        echo '<label up="toua2" class="uploadLabel imgsmall">2</label>';
                                        ?>
                                        <img upimg="toua2" src="" class="smallimg" />
                                    </td>
                                    <td>
                                        <?php
                                        if(!empty($touchUpImageFilesArray['After3']["FileName"]))
                                        echo '<img up="toua3" src="' . get_home_url() . "/" . $touchUpImageFilesArray['After3']["FileName"] . '" class="FAImageTouchUp">';
                                        else
                                        echo '<label up="toua3" class="uploadLabel imgsmall">3</label>';
                                        ?>
                                        <img upimg="toua3" src="" class="smallimg" />
                                    </td>
                                    <td>
                                        <?php
                                        if(!empty($touchUpImageFilesArray['After4']["FileName"]))
                                        echo '<img up="toua4" src="' . get_home_url() . "/" . $touchUpImageFilesArray['After4']["FileName"] . '" class="FAImageTouchUp">';
                                        else
                                        echo '<label up="toua4" class="uploadLabel imgsmall">4</label>';
                                        ?>
                                        <img upimg="toua4" src="" class="smallimg" />
                                    </td>
                                    <td>
                                        <?php
                                        if(!empty($touchUpImageFilesArray['After5']["FileName"]))
                                        echo '<img up="toua5" src="' . get_home_url() . "/" . $touchUpImageFilesArray['After5']["FileName"] . '" class="FAImageTouchUp">';
                                        else
                                        echo '<label up="toua5" class="uploadLabel imgsmall">5</label>';
                                        ?>
                                        <img upimg="toua5" src="" class="smallimg" />
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><input style="display:none" id="toua1" type="file" name="upload_touch_up_after_1" class="FUAChooseFileButtonTouchUp"></td>
                                    <td><input style="display:none" id="toua2" type="file" name="upload_touch_up_after_2" class="FUAChooseFileButtonTouchUp"></td>
                                    <td><input style="display:none" id="toua3" type="file" name="upload_touch_up_after_3" class="FUAChooseFileButtonTouchUp"></td>
                                    <td><input style="display:none" id="toua4" type="file" name="upload_touch_up_after_4" class="FUAChooseFileButtonTouchUp"></td>
                                    <td><input style="display:none" id="toua5" type="file" name="upload_touch_up_after_5" class="FUAChooseFileButtonTouchUp"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="FAFiContentPart">
                        <div class="FASCPFLine">
                            <p class="FAFSubTitle">YARD WORK</p>
                            <p class="FASubTitleUpload">
                                <?php
                                if(!empty($yardWorkImageFilesArray['Invoice']["FileName"])){
                                echo '<a>Invoice uploaded</a>';
                                }
                                else{
                                echo '<a>No Invoice uploaded</a>';
                                }
                                ?>

                            </p>
                            <label for="yarkworkupload" class="FUASaveButton upload">Upload</label>
                            <input style="display:none" id="yarkworkupload" type="file" name="upload_yard_work_invoice" class="FUAInputOnOneLine">
                            <input type="submit" name="submit_yard_work" value=" SAVE " class="FUASaveButton">
                        </div>
                        <div class="FASCPSLine">
                            <table class="FAtable">
                                <tr>
                                    <td>BEFORE</td>
                                    <td>
                                        <?php
                                        if(!empty($yardWorkImageFilesArray['BeforeFrontYard']["FileName"]))
                                        echo '<img up="yarb1" src="' . get_home_url() . "/" . $yardWorkImageFilesArray['BeforeFrontYard']["FileName"] . '" class="FAImage">';
                                        else
                                        echo '<label up="yarb1" class="uploadLabel">FRONT YARD</label>';
                                        ?>
                                        <img upimg="yarb1" src=""  class="largeimg"/>
                                    </td>
                                    <td>
                                        <?php
                                        if(!empty($yardWorkImageFilesArray['BeforeBackYard']["FileName"]))
                                        echo '<img up="yarb2" src="' . get_home_url() . "/" . $yardWorkImageFilesArray['BeforeBackYard']["FileName"] . '" class="FAImage">';
                                        else
                                        echo '<label up="yarb2" class="uploadLabel">BACK YARD</label>';
                                        ?>
                                        <img upimg="yarb2" src="" class="largeimg" />
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><input style="display:none" id="yarb1" type="file" name="upload_yard_work_before_front" class="FUAChooseFileButton"></td>
                                    <td><input style="display:none" id="yarb2" type="file" name="upload_yard_work_before_back" class="FUAChooseFileButton"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="FASCPTLine">
                            <table class="FAtable">
                                <tr>
                                    <td>AFTER&nbsp;&nbsp;&nbsp;</td>
                                    <td>
                                        <?php
                                        if(!empty($yardWorkImageFilesArray['AfterFrontYard']["FileName"]))
                                        echo '<img up="yara1" src="' . get_home_url() . "/" . $yardWorkImageFilesArray['AfterFrontYard']["FileName"] . '" class="FAImage">';
                                        else
                                        echo '<label up="yara1" class="uploadLabel">FRONT YARD</label>';
                                        ?>
                                        <img upimg="yara1" src="" class="largeimg" />
                                    </td>
                                    <td>
                                        <?php
                                        if(!empty($yardWorkImageFilesArray['AfterBackYard']["FileName"]))
                                        echo '<img up="yara2" src="' . get_home_url() . "/" . $yardWorkImageFilesArray['AfterBackYard']["FileName"] . '" class="FAImage">';
                                        else
                                        echo '<label up="yara2" class="uploadLabel">BACK YARD</label>';
                                        ?>
                                        <img upimg="yara2" src=""  class="largeimg"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><input style="display:none" id="yara1" type="file" name="upload_yard_work_after_front" class="FUAChooseFileButton"></td>
                                    <td><input style="display:none" id="yara2" type="file" name="upload_yard_work_after_back" class="FUAChooseFileButton"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="FUSixContentPartNew">
                        <div class="FASCPFLine">
                            <p class="FAFSubTitle">INSPECTION</p>
                            <p class="FASubTitleInsoection">
                                INSPECTION REPORT*<br>
                                <?php
                                if(!empty($inspectionImageFilesArray['Report']["FileName"])){
                                echo '<a>Report uploaded</a>';
                                }
                                else{
                                echo '<a>No Report uploaded</a>';
                                }
                                ?>
                                <label for="inspectionupload" class="FUASaveButton upload">Upload</label>
                                <input style="display:none" id="inspectionupload" type="file" name="upload_inspection_report" class="FUAChooseFileButton inspectionStyle">
                            </p>
                            <p class="FASubTitleInvoice">
                                INVOICE*<br>
                                <?php
                                if(!empty($inspectionImageFilesArray['Invoice']["FileName"])){
                                echo '<a>Invoice uploaded</a>';
                                }
                                else{
                                echo '<a>No Invoice uploaded</a>';
                                }
                                ?>
                                <label for="inspectioninvoiceupload" class="FUASaveButton upload">Upload</label>
                                <input style="display:none" id="inspectioninvoiceupload" type="file" name="upload_inspection_invoice" class="FUAChooseFileButton inspectionStyle">
                            </p>
                            <input type="submit" name="submit_inspection" value=" SAVE " class="FUASaveButton inspectionButtonStyle">
                        </div>
                    </div>
                    <div class="FASixContentPart">
                        <div class="FASCPFLine">
                            <p class="FAFSubTitle">STORAGE</p>
                            <p class="FASubTitleStoageInvoice">INVOICE*</p>
                            <?php
                            if(!empty($storageImageFilesArray['Invoice']["FileName"])){
                            echo '<a>Invoice uploaded</a>';
                            }
                            else{
                            echo '<a>No Invoice uploaded</a>';
                            }
                            ?>
                            <label for="storageupload" class="FUASaveButton upload">Upload</label>
                            <input style="display:none" id="storageupload" type="file" name="upload_storage_invoice" class="FUAChooseFileButton storageInputFileStyle">
                            <input type="submit" name="submit_storage" value=" SAVE " class="FUASaveButton">
                        </div>
                    </div>
                    <div class="FASevenContentPart">
                        <div class="FASCPFLine">
                            <p class="FAFSubTitle">RELOCATION HOME</p>
                            <p class="FASubTitleStoageInvoice">INVOICE*</p>
                            <?php
                            if(!empty($relocateHomeImageFilesArray['Invoice']["FileName"])){
                            echo '<a>Invoice uploaded</a>';
                            }
                            else{
                            echo '<a>No Invoice uploaded</a>';
                            }
                            ?>
                            <label for="relocationupload" class="FUASaveButton upload">Upload</label>
                            <input style="display:none" id="relocationupload" type="file" name="upload_relocate_home_invoice" class="FUAChooseFileButton storageInputFileStyle">
                            <input type="submit" name="submit_relocate_home" value=" SAVE " class="FUASaveButton">
                        </div>
                    </div>
                </form>
            </div></br></br></br>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>
        $('img').on('click', function (evt) {
            if(!!this.attributes.up)
            $('#' + this.attributes.up.value).click();

        if(!!this.attributes.upimg)
            $('#' + this.attributes.upimg.value).click();
        });
        $('.uploadLabel').on('click', function (evt) {
            $('#' + this.attributes.up.value).click();
        });


        $('.largeimg').hide();
        $('.smallimg').hide();



        $('input[type=file]').on('change',function(evt,a,b){
                var id = this.id;
                var label = $('label[up='+id+']');
                var serverimg = $('img[up='+id+']');
                var me = this;
                if(label.length > 0){
                    var img = $('img[upimg='+id+']');
                    if (me.files && me.files[0] && img.length>0) {
                        var reader = new FileReader();

                        reader.onload = function (e) {
                            img.show();
                            label.hide();
                            img.attr('src', e.target.result);
                        }

                        reader.readAsDataURL(me.files[0]);
                    }
                }else if(serverimg.length>0){
                   var img = $('img[upimg='+id+']');
                    if (me.files && me.files[0] && img.length>0) {
                        var reader = new FileReader();

                        reader.onload = function (e) {
                            serverimg.hide();
                            img.show();
                            img.attr('src', e.target.result);
                        }

                        reader.readAsDataURL(me.files[0]);
                    } 
                }
        });
    </script>
</body>



