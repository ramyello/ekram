<?php
/**
 * Created by Mohammad reza Moshaver - Kaveh Zarifi.
 * zarifikaveh@gmail.com
 * Date: 6/22/2020 AD
 * Time: 15:36
 */

$ROOT = dirname(dirname(dirname(__FILE__)));

require_once($ROOT . '/class/General/General.class.php');
require_once($ROOT . '/class/Database/Database.class.php');
require_once($ROOT . '/class/Goods/Goods.class.php');
require_once($ROOT . '/class/Store/Store.class.php');
require_once($ROOT . '/class/Financial/Financial.class.php');

class Buy
{

    public function __construct()
    {

    }

    public function AddOrders($Connection, $UserID, $Detail)
        {
    
            if (empty($Connection)) {
                $Connection = new Database;
            }
    
     
            $QUERY = $Connection->Insert('orders', array(), array(array('NULL', $UserID, $Detail, '1')));
            if ($QUERY['status']) {
    
                $Result['status'] = true;
                $Result['msg'] = 'عملیات با موفقیت انجام شد!';
                $Result['key'] = $QUERY['key'];
                $Result['error'] = '';
    
            } else {
                $Result['status'] = false;
                $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
                $Result['error'] = $QUERY['error'];
                $Result['key'] = '';
            }
    
            return $Result;
        }
   public function SelectOrders($Connection, $ID, $UserID, $Status, $ORDER_BY, $ORDER_TYPE, $LIMIT)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        $Condition = '';
        if ($ID != '') {
            $Condition = " (`ID`='$ID')";
        }
        if ($UserID != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`UserID`='$UserID')";
        }
        if ($Status != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`Status`='$Status')";
        }

        $Query = $Connection->Select('orders', array('*'), $Condition, $ORDER_BY, $ORDER_TYPE, $LIMIT);

        $i = '1';
        while ($row = mysqli_fetch_assoc($Query)) {

            if($row['Status'] == '1'){
                $Status = 'فعال';
            }
            elseif($row['Status'] == '0'){
                $Status = 'غیرفعال';
            }

            $Result[$i]['ID'] = $row['ID'];
            $Result[$i]['UserID'] = $row['UserID'];
            $Result[$i]['Detail'] = $row['Detail'];
            $Result[$i]['Status'] = $Status;
            $Result[$i]['StatusFlag'] = $row['Status'];

            $i++;
        }

        if (isset($Result)) {
            return $Result;
        }

        return array();

    }


    /*
     * Rows: array( array(GoodsID,UnitID,UnitQty,Price,RowDiscountPercent,RowDiscount) )
     * ShipmentCostType: 1 => by Seller
     * ShipmentCostType: 2 => by Buyer
     */
    public function AddBuy($Connection, $Date, $IndividualID, $StoreID, $TotalPrice, $VolumePercentDiscount, $VolumeDiscount, $TotalVolumeDiscount, $TotalRowsDiscount, $ShipmentCost, $ShipmentCostType, $FinalPrice, $Desc, $ReferenceNo, $AdminID, array $Rows)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }
        $General = new General();
        $Goods = new Goods();
        $Store = new Store();

        if (empty($Rows)) {
            $Result['status'] = false;
            $Result['msg'] = 'برگه خرید خالی است!';
            $Result['error'] = '';
            $Result['key'] = '';

            return $Result;
        }

        $Settings = $General->GetSettings($Connection);

        if($Settings['sal_PrimaryCurrencyUnit'] == ''){
            $Result['status'] = false;
            $Result['msg'] = 'واحد پولی پیشفرض تعریف نشده است!';
            $Result['error'] = '';
            $Result['key'] = '';

            return $Result;
        }

        $CalculatedTotalPrice = 0;
        $CalculatedTotalRowsDiscount = 0;

        ###### Collect and check rows ######
        foreach ($Rows as $Key => $KeyValue){               //Key: ArrayIndex, KeyValue: RowData
            $GoodsInfo = $Goods->SelectGoods($Connection,$KeyValue['GoodsID'],'','','','','',array(),'','','1');
            if($GoodsInfo['1']['BaseUnitID'] != $KeyValue['UnitID']){
                $Result['status'] = false;
                $Result['msg'] = 'واحد کالا در ردیف ' . ($Key + 1) . ' صحیح نیست.';
                $Result['error'] = '';
                $Result['key'] = '';

                return $Result;
            }

            $RowTotalPrice = $KeyValue['Price'] * $KeyValue['UnitQty'];

            $RowDiscountPercentValue = (($RowTotalPrice - $KeyValue['RowDiscount']) * $KeyValue['RowDiscountPercent'])/100;
            $RowTotalDiscount = $RowDiscountPercentValue + $KeyValue['RowDiscount'];

            if($TotalVolumeDiscount > 0) {
                $RowFinalPrice = $RowTotalPrice - $RowTotalDiscount;

                $RowQuota = (100 * $RowFinalPrice)/$FinalPrice;

                $RowOverHeadProfit = ($TotalVolumeDiscount * $RowQuota)/100;
            }
            else{
                $RowOverHeadProfit = 0;
            }

            if($ShipmentCost > 0 AND $ShipmentCostType == '2'){
                $RowFinalPrice = $RowTotalPrice - $RowTotalDiscount;

                $RowQuota = (100 * $RowFinalPrice)/$FinalPrice;

                $RowOverHeadCost = ($ShipmentCost * $RowQuota)/100;
            }
            else{
                $RowOverHeadCost = 0;
            }

            $RowsToInsert[] = array('PT' => '1', 'Date' => $Date, 'GoodsID' => $KeyValue['GoodsID'], 'GoodsSeriesID' => '1', 'StoreID' => $StoreID, 'BaseUnitID' => $KeyValue['UnitID'], 'BaseUnitQty' => $KeyValue['UnitQty'], 'UnitID' => $KeyValue['UnitID'], 'UnitQty' => $KeyValue['UnitQty'], 'Type' => '1', 'PriceUnitID' => $Settings['sal_PrimaryCurrencyUnit'], 'Price' => $KeyValue['Price'], 'RowDiscountPercent' => $KeyValue['RowDiscountPercent'], 'RowDiscount' => $KeyValue['RowDiscount'], 'RowTotalDiscount' => $RowTotalDiscount, 'OverHeadCost' => $RowOverHeadCost, 'OverHeadProfit' => $RowOverHeadProfit, 'RowNo' => ($Key+1));

            $CalculatedTotalPrice += $RowTotalPrice;
            $CalculatedTotalRowsDiscount += $RowTotalDiscount;
        }
        ###### Collect and check rows ######

        ###### Calculate volume discount and Final price ######
        $CalculatedVolumePercentDiscount = ( ($TotalPrice - $TotalRowsDiscount - $VolumeDiscount) * $VolumePercentDiscount )/100;
        $CalculatedTotalVolumeDiscount = $VolumeDiscount + $CalculatedVolumePercentDiscount;

        if($ShipmentCostType == '1'){
            $CalculatedFinalPrice = $TotalPrice - $TotalRowsDiscount - $CalculatedTotalVolumeDiscount - $ShipmentCost;
        }
        elseif($ShipmentCostType == '2'){
            $CalculatedFinalPrice = $TotalPrice - $TotalRowsDiscount - $CalculatedTotalVolumeDiscount + $ShipmentCost;
        }
        ###### Calculate volume discount and Final price ######

        ###### Check values ######
        if($CalculatedTotalPrice != $TotalPrice){
            $Result['status'] = false;
            $Result['msg'] = 'مبلغ کل صحیح نیست.';
            $Result['error'] = '';
            $Result['key'] = '';

            return $Result;
        }
        if($CalculatedTotalRowsDiscount != $TotalRowsDiscount){
            $Result['status'] = false;
            $Result['msg'] = 'جمع تخفیفات سطری صحیح نیست.';
            $Result['error'] = '';
            $Result['key'] = '';

            return $Result;
        }
        if($CalculatedTotalVolumeDiscount != $TotalVolumeDiscount){
            $Result['status'] = false;
            $Result['msg'] = 'جمع تخفیفات حجمی صحیح نیست.';
            $Result['error'] = '';
            $Result['key'] = '';

            return $Result;
        }
        if($CalculatedFinalPrice != $FinalPrice){
            $Result['status'] = false;
            $Result['msg'] = 'مبلغ قابل پرداخت صحیح نیست.';
            $Result['error'] = '';
            $Result['key'] = '';

            return $Result;
        }
        ###### Check values ######

        $GetDocNo = $Connection->Select('buy.buy',array('DocNo'),"`Type` = '1'",'DocNo','DESC','1');
        if(mysqli_num_rows($GetDocNo) > 0){
            $RowGetDocNo = mysqli_fetch_assoc($GetDocNo);
            $DocNo = $RowGetDocNo['DocNo'] + 1;
        }
        else{
            $DocNo = 1;
        }

        $CT = time();

        $Connection->StartTransaction();

        $QUERY = $Connection->Insert('buy.buy', array(), array(array('NULL','1', $DocNo, $Date, $IndividualID, $StoreID, $TotalPrice, $VolumePercentDiscount, $VolumeDiscount, $TotalVolumeDiscount, $TotalRowsDiscount, $ShipmentCost, $ShipmentCostType, $Desc, $ReferenceNo, $AdminID, $CT)));
        if ($QUERY['status']) {
            $BuyID = $QUERY['key'];

            $InsertRows = $Store->AddTransaction($Connection,$RowsToInsert,'BuyID',$BuyID);
            if($InsertRows['status']) {

                $AddVoucher = $Connection->Insert('fin.transaction',array('Type','Amount','CT','IndividualID','BuyID'),array(array('1',$FinalPrice,$Date,$IndividualID,$BuyID)));
                if($AddVoucher['status']) {
                    $Result['status'] = true;
                    $Result['msg'] = 'عملیات با موفقیت انجام شد!';
                    $Result['key'] = $BuyID;
                    $Result['error'] = '';

                    $Connection->Commit();

                    return $Result;
                }

                $Result['status'] = false;
                $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید (مرحله 3)';
                $Result['error'] = $InsertRows['error'];
                $Result['key'] = '';

                $Connection->RollBack();

                return $Result;

            }

            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید (مرحله 2)';
            $Result['error'] = $InsertRows['error'];
            $Result['key'] = '';

            $Connection->RollBack();

            return $Result;

        }

        $Result['status'] = false;
        $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید (مرحله 1)';
        $Result['error'] = $QUERY['error'];
        $Result['key'] = '';

        $Connection->RollBack();

        return $Result;

    }

    /*
     * Rows: array( array(GoodsID,UnitID,UnitQty,Price,RowDiscountPercent,RowDiscount) )
     * ShipmentCostType: 1 => by Seller
     * ShipmentCostType: 2 => by Buyer
     */
    public function AddRevertOfBuy($Connection, $Date, $IndividualID, $StoreID, $TotalPrice, $VolumePercentDiscount, $VolumeDiscount, $TotalVolumeDiscount, $TotalRowsDiscount, $ShipmentCost, $ShipmentCostType, $FinalPrice, $Desc, $AdminID, array $Rows)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }
        $General = new General();
        $Goods = new Goods();
        $Store = new Store();

        if (empty($Rows)) {
            $Result['status'] = false;
            $Result['msg'] = 'برگه برگشت از خرید خالی است!';
            $Result['error'] = '';
            $Result['key'] = '';

            return $Result;
        }

        $Settings = $General->GetSettings($Connection);

        if($Settings['sal_PrimaryCurrencyUnit'] == ''){
            $Result['status'] = false;
            $Result['msg'] = 'واحد پولی پیشفرض تعریف نشده است!';
            $Result['error'] = '';
            $Result['key'] = '';

            return $Result;
        }

        $CalculatedTotalPrice = 0;
        $CalculatedTotalRowsDiscount = 0;

        ###### Collect and check rows ######
        foreach ($Rows as $Key => $KeyValue){               //Key: ArrayIndex, KeyValue: RowData
            $GoodsInfo = $Goods->SelectGoods($Connection,$KeyValue['GoodsID'],'','','','','',array(),'','','1');
            if($GoodsInfo['1']['BaseUnitID'] != $KeyValue['UnitID']){
                $Result['status'] = false;
                $Result['msg'] = 'واحد کالا در ردیف ' . ($Key + 1) . ' صحیح نیست.';
                $Result['error'] = '';
                $Result['key'] = '';

                return $Result;
            }

            $RowTotalPrice = $KeyValue['Price'] * $KeyValue['UnitQty'];

            $RowDiscountPercentValue = (($RowTotalPrice - $KeyValue['RowDiscount']) * $KeyValue['RowDiscountPercent'])/100;
            $RowTotalDiscount = $RowDiscountPercentValue + $KeyValue['RowDiscount'];

            if($TotalVolumeDiscount > 0) {
                $RowFinalPrice = $RowTotalPrice - $RowTotalDiscount;

                $RowQuota = (100 * $RowFinalPrice)/$FinalPrice;

                $RowOverHeadCost = ($TotalVolumeDiscount * $RowQuota)/100;
            }
            else{
                $RowOverHeadCost = 0;
            }

            if($ShipmentCost > 0 AND $ShipmentCostType == '2'){
                $RowFinalPrice = $RowTotalPrice - $RowTotalDiscount;

                $RowQuota = (100 * $RowFinalPrice)/$FinalPrice;

                $RowOverHeadProfit = ($ShipmentCost * $RowQuota)/100;
            }
            else{
                $RowOverHeadProfit = 0;
            }

            $RowsToInsert[] = array('PT' => '6', 'Date' => $Date, 'GoodsID' => $KeyValue['GoodsID'], 'GoodsSeriesID' => '1', 'StoreID' => $StoreID, 'BaseUnitID' => $KeyValue['UnitID'], 'BaseUnitQty' => $KeyValue['UnitQty'], 'UnitID' => $KeyValue['UnitID'], 'UnitQty' => $KeyValue['UnitQty'], 'Type' => '0', 'PriceUnitID' => $Settings['sal_PrimaryCurrencyUnit'], 'Price' => $KeyValue['Price'], 'RowDiscountPercent' => $KeyValue['RowDiscountPercent'], 'RowDiscount' => $KeyValue['RowDiscount'], 'RowTotalDiscount' => $RowTotalDiscount, 'OverHeadCost' => $RowOverHeadCost, 'OverHeadProfit' => $RowOverHeadProfit, 'RowNo' => ($Key+1));

            $CalculatedTotalPrice += $RowTotalPrice;
            $CalculatedTotalRowsDiscount += $RowTotalDiscount;
        }
        ###### Collect and check rows ######

        ###### Calculate volume discount and Final price ######
        $CalculatedVolumePercentDiscount = ( ($TotalPrice - $TotalRowsDiscount - $VolumeDiscount) * $VolumePercentDiscount )/100;
        $CalculatedTotalVolumeDiscount = $VolumeDiscount + $CalculatedVolumePercentDiscount;

        if($ShipmentCostType == '1'){
            $CalculatedFinalPrice = $TotalPrice - $TotalRowsDiscount - $CalculatedTotalVolumeDiscount + $ShipmentCost;
        }
        elseif($ShipmentCostType == '2'){
            $CalculatedFinalPrice = $TotalPrice - $TotalRowsDiscount - $CalculatedTotalVolumeDiscount - $ShipmentCost;
        }
        ###### Calculate volume discount and Final price ######

        ###### Check values ######
        if($CalculatedTotalPrice != $TotalPrice){
            $Result['status'] = false;
            $Result['msg'] = 'مبلغ کل صحیح نیست.';
            $Result['error'] = '';
            $Result['key'] = '';

            return $Result;
        }
        if($CalculatedTotalRowsDiscount != $TotalRowsDiscount){
            $Result['status'] = false;
            $Result['msg'] = 'جمع تخفیفات سطری صحیح نیست.';
            $Result['error'] = '';
            $Result['key'] = '';

            return $Result;
        }
        if($CalculatedTotalVolumeDiscount != $TotalVolumeDiscount){
            $Result['status'] = false;
            $Result['msg'] = 'جمع تخفیفات حجمی صحیح نیست.';
            $Result['error'] = '';
            $Result['key'] = '';

            return $Result;
        }
        if($CalculatedFinalPrice != $FinalPrice){
            $Result['status'] = false;
            $Result['msg'] = 'مبلغ قابل پرداخت صحیح نیست.';
            $Result['error'] = '';
            $Result['key'] = '';

            return $Result;
        }
        ###### Check values ######

        $GetDocNo = $Connection->Select('buy.buy',array('DocNo'),"`Type` = '0'",'DocNo','DESC','1');
        if(mysqli_num_rows($GetDocNo) > 0){
            $RowGetDocNo = mysqli_fetch_assoc($GetDocNo);
            $DocNo = $RowGetDocNo['DocNo'] + 1;
        }
        else{
            $DocNo = 1;
        }

        $CT = time();

        $Connection->StartTransaction();

        $QUERY = $Connection->Insert('buy.buy', array(), array(array('NULL','0', $DocNo, $Date, $IndividualID, $StoreID, $TotalPrice, $VolumePercentDiscount, $VolumeDiscount, $TotalVolumeDiscount, $TotalRowsDiscount, $ShipmentCost, $ShipmentCostType, $Desc, '', $AdminID, $CT)));
        if ($QUERY['status']) {
            $BuyID = $QUERY['key'];

            $InsertRows = $Store->AddTransaction($Connection,$RowsToInsert,'BuyID',$BuyID);
            if($InsertRows['status']) {

                $AddVoucher = $Connection->Insert('fin.transaction',array('Type','Amount','CT','IndividualID','BuyID'),array(array('0',$FinalPrice,$Date,$IndividualID,$BuyID)));
                if($AddVoucher['status']) {
                    $Result['status'] = true;
                    $Result['msg'] = 'عملیات با موفقیت انجام شد!';
                    $Result['key'] = $BuyID;
                    $Result['error'] = '';

                    $Connection->Commit();

                    return $Result;
                }

                $Result['status'] = false;
                $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید (مرحله 3)';
                $Result['error'] = $InsertRows['error'];
                $Result['key'] = '';

                $Connection->RollBack();

                return $Result;

            }

            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید (مرحله 2) <br> ' . $InsertRows['error'];
            $Result['error'] = $InsertRows['error'];
            $Result['key'] = '';

            $Connection->RollBack();

            return $Result;

        }

        $Result['status'] = false;
        $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید (مرحله 1)';
        $Result['error'] = $QUERY['error'];
        $Result['key'] = '';

        $Connection->RollBack();

        return $Result;

    }

    /*
     * Rows: array( array(RowID,GoodsID,UnitID,UnitQty,Price,RowDiscountPercent,RowDiscount) )
     * ShipmentCostType: 1 => by Seller
     * ShipmentCostType: 2 => by Buyer
     */
    public function EditBuy($Connection, $ID, $Date, $IndividualID, $StoreID, $TotalPrice, $VolumePercentDiscount, $VolumeDiscount, $TotalVolumeDiscount, $TotalRowsDiscount, $ShipmentCost, $ShipmentCostType, $FinalPrice, $Desc, $ReferenceNo, array $Rows)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }
        $Goods = new Goods();
        $Store = new Store();

        if (empty($Rows)) {
            $Result['status'] = false;
            $Result['msg'] = 'برگه خرید خالی است!';
            $Result['error'] = '';
            $Result['key'] = '';

            return $Result;
        }

        $OldRows = $Store->SelectTransaction($Connection,'',array(),'','',array(),array(),array(),'','BuyID',$ID,'','','');
        foreach ($OldRows as $Key => $KeyValue){                //Key: ArrayIndex, KeyValue: RowInfo
            $OldRowsID[$KeyValue['ID']] = $KeyValue['ID'];
            $PriceUnitID = $KeyValue['PriceUnitID'];
        }

        $Connection->StartTransaction();

        $CalculatedTotalPrice = 0;
        $CalculatedTotalRowsDiscount = 0;

        ###### Collect and check rows, find new rows, update rows and find deleted rows  ######
        foreach ($Rows as $Key => $KeyValue){               //Key: ArrayIndex, KeyValue: RowData
            $GoodsInfo = $Goods->SelectGoods($Connection,$KeyValue['GoodsID'],'','','','','',array(),'','','1');
            if($GoodsInfo['1']['BaseUnitID'] != $KeyValue['UnitID']){
                $Result['status'] = false;
                $Result['msg'] = 'واحد کالا در ردیف ' . ($Key + 1) . ' صحیح نیست.';
                $Result['error'] = '';
                $Result['key'] = '';

                $Connection->RollBack();

                return $Result;
            }

            $RowTotalPrice = $KeyValue['Price'] * $KeyValue['UnitQty'];

            $RowDiscountPercentValue = (($RowTotalPrice - $KeyValue['RowDiscount']) * $KeyValue['RowDiscountPercent'])/100;
            $RowTotalDiscount = $RowDiscountPercentValue + $KeyValue['RowDiscount'];

            if($TotalVolumeDiscount > 0) {
                $RowFinalPrice = $RowTotalPrice - $RowTotalDiscount;

                $RowQuota = (100 * $RowFinalPrice)/$FinalPrice;

                $RowOverHeadProfit = ($TotalVolumeDiscount * $RowQuota)/100;
            }
            else{
                $RowOverHeadProfit = 0;
            }

            if($ShipmentCost > 0 AND $ShipmentCostType == '2'){
                $RowFinalPrice = $RowTotalPrice - $RowTotalDiscount;

                $RowQuota = (100 * $RowFinalPrice)/$FinalPrice;

                $RowOverHeadCost = ($ShipmentCost * $RowQuota)/100;
            }
            else{
                $RowOverHeadCost = 0;
            }

            if($KeyValue['RowID'] == '') {
                $RowsToInsert[0] = array('PT' => '1', 'Date' => $Date, 'GoodsID' => $KeyValue['GoodsID'], 'GoodsSeriesID' => '1', 'StoreID' => $StoreID, 'BaseUnitID' => $KeyValue['UnitID'], 'BaseUnitQty' => $KeyValue['UnitQty'], 'UnitID' => $KeyValue['UnitID'], 'UnitQty' => $KeyValue['UnitQty'], 'Type' => '1', 'PriceUnitID' => $PriceUnitID, 'Price' => $KeyValue['Price'], 'RowDiscountPercent' => $KeyValue['RowDiscountPercent'], 'RowDiscount' => $KeyValue['RowDiscount'], 'RowTotalDiscount' => $RowTotalDiscount, 'OverHeadCost' => $RowOverHeadCost, 'OverHeadProfit' => $RowOverHeadProfit, 'RowNo' => ($Key + 1));
                $InsertRows = $Store->AddTransaction($Connection,$RowsToInsert,'BuyID',$ID);
                if(!$InsertRows['status']){
                    $Result['status'] = false;
                    $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید (مرحله 1)';
                    $Result['error'] = $InsertRows['error'];
                    $Result['key'] = '';

                    $Connection->RollBack();

                    return $Result;
                }
            }
            elseif(in_array($KeyValue['RowID'],$OldRowsID)){
                $RowID = $KeyValue['RowID'];
                $UpdateRow = $Connection->Update('inv.store_transactions',array('Date' => $Date, 'GoodsID' => $KeyValue['GoodsID'], 'GoodsSeriesID' => '1', 'StoreID' => $StoreID, 'BaseUnitID' => $KeyValue['UnitID'], 'BaseUnitQty' => $KeyValue['UnitQty'], 'UnitID' => $KeyValue['UnitID'], 'UnitQty' => $KeyValue['UnitQty'], 'Price' => $KeyValue['Price'], 'RowDiscountPercent' => $KeyValue['RowDiscountPercent'], 'RowDiscount' => $KeyValue['RowDiscount'], 'RowTotalDiscount' => $RowTotalDiscount, 'OverHeadCost' => $RowOverHeadCost, 'OverHeadProfit' => $RowOverHeadProfit, 'RowNo' => ($Key + 1)),"`ID` = '$RowID'");
                if(!$UpdateRow['status']){
                    $Result['status'] = false;
                    $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید (مرحله 2)';
                    $Result['error'] = $UpdateRow['error'];
                    $Result['key'] = '';

                    $Connection->RollBack();

                    return $Result;
                }

                unset($OldRowsID[$RowID]);
            }

            $CalculatedTotalPrice += $RowTotalPrice;
            $CalculatedTotalRowsDiscount += $RowTotalDiscount;
        }
        foreach ($OldRowsID as $Key => $KeyValue){                //Key: RowID
            $RowsToDelete[] = $Key;
        }
        if(isset($RowsToDelete) AND !empty($RowsToDelete)){             //Delete rows
            $DeleteRows = $Store->DeleteTransaction($Connection,$RowsToDelete,'','');
            if(!$DeleteRows['status']){
                $Result['status'] = false;
                $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید (مرحله 3)';
                $Result['error'] = $DeleteRows['error'];
                $Result['key'] = '';

                $Connection->RollBack();

                return $Result;
            }
        }
        ###### Collect and check rows, find new rows, update rows and find deleted rows  ######

        ###### Calculate volume discount and Final price ######
        $CalculatedVolumePercentDiscount = ( ($TotalPrice - $TotalRowsDiscount - $VolumeDiscount) * $VolumePercentDiscount )/100;
        $CalculatedTotalVolumeDiscount = $VolumeDiscount + $CalculatedVolumePercentDiscount;

        if($ShipmentCostType == '1'){
            $CalculatedFinalPrice = $TotalPrice - $TotalRowsDiscount - $CalculatedTotalVolumeDiscount - $ShipmentCost;
        }
        elseif($ShipmentCostType == '2'){
            $CalculatedFinalPrice = $TotalPrice - $TotalRowsDiscount - $CalculatedTotalVolumeDiscount + $ShipmentCost;
        }
        ###### Calculate volume discount and Final price ######

        ###### Check values ######
        if($CalculatedTotalPrice != $TotalPrice){
            $Result['status'] = false;
            $Result['msg'] = 'مبلغ کل صحیح نیست.';
            $Result['error'] = '';
            $Result['key'] = '';

            return $Result;
        }
        if($CalculatedTotalRowsDiscount != $TotalRowsDiscount){
            $Result['status'] = false;
            $Result['msg'] = 'جمع تخفیفات سطری صحیح نیست.';
            $Result['error'] = '';
            $Result['key'] = '';

            return $Result;
        }
        if($CalculatedTotalVolumeDiscount != $TotalVolumeDiscount){
            $Result['status'] = false;
            $Result['msg'] = 'جمع تخفیفات حجمی صحیح نیست.';
            $Result['error'] = '';
            $Result['key'] = '';

            return $Result;
        }
        if($CalculatedFinalPrice != $FinalPrice){
            $Result['status'] = false;
            $Result['msg'] = 'مبلغ قابل پرداخت صحیح نیست.';
            $Result['error'] = '';
            $Result['key'] = '';

            return $Result;
        }
        ###### Check values ######

        $QUERY = $Connection->Update('buy.buy', array('Date' => $Date, 'IndividualID' => $IndividualID, 'StoreID' => $StoreID, 'TotalPrice' => $TotalPrice, 'VolumePercentDiscount' => $VolumePercentDiscount, 'VolumeDiscount' => $VolumeDiscount, 'TotalVolumeDiscount' => $TotalVolumeDiscount, 'TotalRowsDiscount' => $TotalRowsDiscount, 'ShipmentCost' => $ShipmentCost, 'ShipmentCostType' => $ShipmentCostType, 'Desc' => $Desc, 'ReferenceNo' => $ReferenceNo), "`ID` = '$ID'");
        if ($QUERY['status']) {

            $UpdateVoucher = $Connection->Update('fin.transaction',array('Amount' => $FinalPrice, 'CT' => $Date, 'IndividualID' => $IndividualID),"`BuyID` = '$ID'");
            if ($UpdateVoucher['status']) {
                $Result['status'] = true;
                $Result['msg'] = 'عملیات با موفقیت انجام شد!';
                $Result['key'] = $ID;
                $Result['error'] = '';

                $Connection->Commit();

                return $Result;
            }

            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید (مرحله 5)';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = '';

            $Connection->RollBack();

            return $Result;

        }

        $Result['status'] = false;
        $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید (مرحله 4)';
        $Result['error'] = $QUERY['error'];
        $Result['key'] = '';

        $Connection->RollBack();

        return $Result;
    }

    /*
     * Rows: array( array(RowID,GoodsID,UnitID,UnitQty,Price,RowDiscountPercent,RowDiscount) )
     * ShipmentCostType: 1 => by Seller
     * ShipmentCostType: 2 => by Buyer
     */
    public function EditRevertOfBuy($Connection, $ID, $Date, $IndividualID, $StoreID, $TotalPrice, $VolumePercentDiscount, $VolumeDiscount, $TotalVolumeDiscount, $TotalRowsDiscount, $ShipmentCost, $ShipmentCostType, $FinalPrice, $Desc, array $Rows)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }
        $Goods = new Goods();
        $Store = new Store();

        if (empty($Rows)) {
            $Result['status'] = false;
            $Result['msg'] = 'برگه برگشت از خرید خالی است!';
            $Result['error'] = '';
            $Result['key'] = '';

            return $Result;
        }

        $OldRows = $Store->SelectTransaction($Connection,'',array(),'','',array(),array(),array(),'','BuyID',$ID,'','','');
        foreach ($OldRows as $Key => $KeyValue){                //Key: ArrayIndex, KeyValue: RowInfo
            $OldRowsID[$KeyValue['ID']] = $KeyValue['ID'];
            $PriceUnitID = $KeyValue['PriceUnitID'];
        }

        $Connection->StartTransaction();

        $CalculatedTotalPrice = 0;
        $CalculatedTotalRowsDiscount = 0;

        ###### Collect and check rows, find new rows, update rows and find deleted rows  ######
        foreach ($Rows as $Key => $KeyValue){               //Key: ArrayIndex, KeyValue: RowData
            $GoodsInfo = $Goods->SelectGoods($Connection,$KeyValue['GoodsID'],'','','','','',array(),'','','1');
            if($GoodsInfo['1']['BaseUnitID'] != $KeyValue['UnitID']){
                $Result['status'] = false;
                $Result['msg'] = 'واحد کالا در ردیف ' . ($Key + 1) . ' صحیح نیست.';
                $Result['error'] = '';
                $Result['key'] = '';

                $Connection->RollBack();

                return $Result;
            }

            $RowTotalPrice = $KeyValue['Price'] * $KeyValue['UnitQty'];

            $RowDiscountPercentValue = (($RowTotalPrice - $KeyValue['RowDiscount']) * $KeyValue['RowDiscountPercent'])/100;
            $RowTotalDiscount = $RowDiscountPercentValue + $KeyValue['RowDiscount'];

            if($TotalVolumeDiscount > 0) {
                $RowFinalPrice = $RowTotalPrice - $RowTotalDiscount;

                $RowQuota = (100 * $RowFinalPrice)/$FinalPrice;

                $RowOverHeadCost = ($TotalVolumeDiscount * $RowQuota)/100;
            }
            else{
                $RowOverHeadCost = 0;
            }

            if($ShipmentCost > 0 AND $ShipmentCostType == '2'){
                $RowFinalPrice = $RowTotalPrice - $RowTotalDiscount;

                $RowQuota = (100 * $RowFinalPrice)/$FinalPrice;

                $RowOverHeadProfit = ($ShipmentCost * $RowQuota)/100;
            }
            else{
                $RowOverHeadProfit = 0;
            }

            if($KeyValue['RowID'] == '') {
                $RowsToInsert[0] = array('PT' => '6', 'Date' => $Date, 'GoodsID' => $KeyValue['GoodsID'], 'GoodsSeriesID' => '1', 'StoreID' => $StoreID, 'BaseUnitID' => $KeyValue['UnitID'], 'BaseUnitQty' => $KeyValue['UnitQty'], 'UnitID' => $KeyValue['UnitID'], 'UnitQty' => $KeyValue['UnitQty'], 'Type' => '0', 'PriceUnitID' => $PriceUnitID, 'Price' => $KeyValue['Price'], 'RowDiscountPercent' => $KeyValue['RowDiscountPercent'], 'RowDiscount' => $KeyValue['RowDiscount'], 'RowTotalDiscount' => $RowTotalDiscount, 'OverHeadCost' => $RowOverHeadCost, 'OverHeadProfit' => $RowOverHeadProfit, 'RowNo' => ($Key + 1));
                $InsertRows = $Store->AddTransaction($Connection,$RowsToInsert,'BuyID',$ID);
                if(!$InsertRows['status']){
                    $Result['status'] = false;
                    $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید (مرحله 1) <br> ' . $InsertRows['error'];
                    $Result['error'] = $InsertRows['error'];
                    $Result['key'] = '';

                    $Connection->RollBack();

                    return $Result;
                }
            }
            elseif(in_array($KeyValue['RowID'],$OldRowsID)){
                $RowID = $KeyValue['RowID'];
                $UpdateRow = $Connection->Update('inv.store_transactions',array('Date' => $Date, 'GoodsID' => $KeyValue['GoodsID'], 'GoodsSeriesID' => '1', 'StoreID' => $StoreID, 'BaseUnitID' => $KeyValue['UnitID'], 'BaseUnitQty' => $KeyValue['UnitQty'], 'UnitID' => $KeyValue['UnitID'], 'UnitQty' => $KeyValue['UnitQty'], 'Price' => $KeyValue['Price'], 'RowDiscountPercent' => $KeyValue['RowDiscountPercent'], 'RowDiscount' => $KeyValue['RowDiscount'], 'RowTotalDiscount' => $RowTotalDiscount, 'OverHeadCost' => $RowOverHeadCost, 'OverHeadProfit' => $RowOverHeadProfit, 'RowNo' => ($Key + 1)),"`ID` = '$RowID'");
                if(!$UpdateRow['status']){
                    $Result['status'] = false;
                    $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید (مرحله 2) <br> ' . $UpdateRow['error'];
                    $Result['error'] = $UpdateRow['error'];
                    $Result['key'] = '';

                    $Connection->RollBack();

                    return $Result;
                }

                unset($OldRowsID[$RowID]);
            }

            $CalculatedTotalPrice += $RowTotalPrice;
            $CalculatedTotalRowsDiscount += $RowTotalDiscount;
        }
        foreach ($OldRowsID as $Key => $KeyValue){                //Key: RowID
            $RowsToDelete[] = $Key;
        }
        if(isset($RowsToDelete) AND !empty($RowsToDelete)){             //Delete rows
            $DeleteRows = $Store->DeleteTransaction($Connection,$RowsToDelete,'','');
            if(!$DeleteRows['status']){
                $Result['status'] = false;
                $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید (مرحله 3) <br> ' . $DeleteRows['error'];
                $Result['error'] = $DeleteRows['error'];
                $Result['key'] = '';

                $Connection->RollBack();

                return $Result;
            }
        }
        ###### Collect and check rows, find new rows, update rows and find deleted rows  ######

        ###### Calculate volume discount and Final price ######
        $CalculatedVolumePercentDiscount = ( ($TotalPrice - $TotalRowsDiscount - $VolumeDiscount) * $VolumePercentDiscount )/100;
        $CalculatedTotalVolumeDiscount = $VolumeDiscount + $CalculatedVolumePercentDiscount;

        if($ShipmentCostType == '1'){
            $CalculatedFinalPrice = $TotalPrice - $TotalRowsDiscount - $CalculatedTotalVolumeDiscount + $ShipmentCost;
        }
        elseif($ShipmentCostType == '2'){
            $CalculatedFinalPrice = $TotalPrice - $TotalRowsDiscount - $CalculatedTotalVolumeDiscount - $ShipmentCost;
        }
        ###### Calculate volume discount and Final price ######

        ###### Check values ######
        if($CalculatedTotalPrice != $TotalPrice){
            $Result['status'] = false;
            $Result['msg'] = 'مبلغ کل صحیح نیست.';
            $Result['error'] = '';
            $Result['key'] = '';

            return $Result;
        }
        if($CalculatedTotalRowsDiscount != $TotalRowsDiscount){
            $Result['status'] = false;
            $Result['msg'] = 'جمع تخفیفات سطری صحیح نیست.';
            $Result['error'] = '';
            $Result['key'] = '';

            return $Result;
        }
        if($CalculatedTotalVolumeDiscount != $TotalVolumeDiscount){
            $Result['status'] = false;
            $Result['msg'] = 'جمع تخفیفات حجمی صحیح نیست.';
            $Result['error'] = '';
            $Result['key'] = '';

            return $Result;
        }
        if($CalculatedFinalPrice != $FinalPrice){
            $Result['status'] = false;
            $Result['msg'] = 'مبلغ قابل پرداخت صحیح نیست.';
            $Result['error'] = '';
            $Result['key'] = '';

            return $Result;
        }
        ###### Check values ######

        $QUERY = $Connection->Update('buy.buy', array('Date' => $Date, 'IndividualID' => $IndividualID, 'StoreID' => $StoreID, 'TotalPrice' => $TotalPrice, 'VolumePercentDiscount' => $VolumePercentDiscount, 'VolumeDiscount' => $VolumeDiscount, 'TotalVolumeDiscount' => $TotalVolumeDiscount, 'TotalRowsDiscount' => $TotalRowsDiscount, 'ShipmentCost' => $ShipmentCost, 'ShipmentCostType' => $ShipmentCostType, 'Desc' => $Desc), "`ID` = '$ID'");
        if ($QUERY['status']) {

            $UpdateVoucher = $Connection->Update('fin.transaction',array('Amount' => $FinalPrice, 'CT' => $Date, 'IndividualID' => $IndividualID),"`BuyID` = '$ID'");
            if ($UpdateVoucher['status']) {
                $Result['status'] = true;
                $Result['msg'] = 'عملیات با موفقیت انجام شد!';
                $Result['key'] = $ID;
                $Result['error'] = '';

                $Connection->Commit();

                return $Result;
            }

            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید (مرحله 5)';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = '';

            $Connection->RollBack();

            return $Result;

        }

        $Result['status'] = false;
        $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید (مرحله 4)';
        $Result['error'] = $QUERY['error'];
        $Result['key'] = '';

        $Connection->RollBack();

        return $Result;
    }


    public function DeleteBuy($Connection, $ID)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        $QUERY = $Connection->Delete('buy.buy', "`ID` = '$ID'");
        if ($QUERY['status']) {

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['error'] = '';
            $Result['key'] = '';

        } else {
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = '';
        }

        return $Result;

    }

    /*
     * Type: 1 => Buy
     * Type: 0 => RevertOfBuy
     */
    public function SelectBuy($Connection, $ID, $Type, $DocNo_FROM, $DocNo_TO, $Date_FROM, $Date_TO, array $IndividualID, array $StoreID, $Desc, $ReferenceNo, $ORDER_BY, $ORDER_TYPE, $LIMIT)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }
        $Financial = new Financial();
        $Store = new Store();
        $General = new General();

        $Settings = $General->GetSettings($Connection);

        $Condition = '';
        if ($ID != '') {
            $Condition = " (`ID`='$ID')";
        }
        if ($Type != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`Type`='$Type')";
        }
        if ($DocNo_FROM != '' AND $DocNo_TO != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`DocNo` BETWEEN '$DocNo_FROM' AND '$DocNo_TO')";
        }
        elseif($DocNo_FROM != ''){
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`DocNo` >= '$DocNo_FROM')";
        }
        elseif($DocNo_TO != ''){
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`DocNo` <= '$DocNo_TO')";
        }
        if ($Date_FROM != '' AND $Date_TO != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`Date` BETWEEN '$Date_FROM' AND '$Date_TO')";
        }
        elseif($Date_FROM != ''){
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`Date` >= '$Date_FROM')";
        }
        elseif($Date_TO != ''){
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`Date` <= '$Date_TO')";
        }
        if (!empty($IndividualID)) {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }

            $Values = '';
            foreach ($IndividualID as $Key => $KeyValue){             //Key:ArrayIndex, KeyValue: Value
                if($Values != ''){
                    $Values .= ',';
                }
                $Values .= "'$KeyValue'";
            }

            $Condition .= "(`IndividualID` IN($Values))";
        }
        if (!empty($StoreID)) {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }

            $Values = '';
            foreach ($StoreID as $Key => $KeyValue){             //Key:ArrayIndex, KeyValue: Value
                if($Values != ''){
                    $Values .= ',';
                }
                $Values .= "'$KeyValue'";
            }

            $Condition .= "(`StoreID` IN($Values))";
        }
        if ($Desc != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`Desc` LIKE '%$Desc%')";
        }
        if ($ReferenceNo != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`ReferenceNo`='$ReferenceNo')";
        }

        $Query = $Connection->Select('buy.buy', array('*'), $Condition, $ORDER_BY, $ORDER_TYPE, $LIMIT);

        $i = '1';
        while ($row = mysqli_fetch_assoc($Query)) {
            $IndividualInfo = $Financial->SelectIndividual($Connection,$row['IndividualID'],'','','','1');
            $StoreInfo = $Store->SelectStore($Connection,$row['StoreID'],'','','','1');

            if($row['ShipmentCostType'] == '1'){
                $ShipmentCostType = 'به عهده فروشنده';
            }
            if($row['ShipmentCostType'] == '2'){
                $ShipmentCostType = 'به عهده خریدار';
            }

            $Result[$i]['ID'] = $row['ID'];
            $Result[$i]['TypeFlag'] = $row['Type'];
            $Result[$i]['DocNo'] = $row['DocNo'];
            $Result[$i]['Date_STR'] = $row['Date'];
            $Result[$i]['JalaliDate'] = jdate('Y/m/d',$row['Date'],'','','en');
            $Result[$i]['Date'] = date('Y/m/d',$row['Date']);
            $Result[$i]['IndividualID'] = $row['IndividualID'];
            $Result[$i]['IndividualName'] = $IndividualInfo['1']['Name'];
            $Result[$i]['StoreID'] = $row['StoreID'];
            $Result[$i]['StoreName'] = $StoreInfo['1']['Name'];
            $Result[$i]['StoreCode'] = $StoreInfo['1']['Code'];
            $Result[$i]['TotalPrice'] = $row['TotalPrice'];
            $Result[$i]['TotalPriceNumberFormat'] = number_format($row['TotalPrice'],$Settings['bas_CurrencyDecimalCount'],'.',',');
            $Result[$i]['VolumePercentDiscount'] = $row['VolumePercentDiscount'];
            $Result[$i]['VolumePercentDiscountValue'] = $row['TotalVolumeDiscount'] - $row['VolumeDiscount'];
            $Result[$i]['VolumePercentDiscountValueNumberFormat'] = number_format($Result[$i]['VolumePercentDiscountValue'],$Settings['bas_CurrencyDecimalCount'],'.',',');
            $Result[$i]['VolumeDiscount'] = $row['VolumeDiscount'];
            $Result[$i]['VolumeDiscountNumberFormat'] = number_format($row['VolumeDiscount'],$Settings['bas_CurrencyDecimalCount'],'.',',');
            $Result[$i]['TotalVolumeDiscount'] = $row['TotalVolumeDiscount'];
            $Result[$i]['TotalVolumeDiscountNumberFormat'] = number_format($row['TotalVolumeDiscount'],$Settings['bas_CurrencyDecimalCount'],'.',',');
            $Result[$i]['TotalRowsDiscount'] = $row['TotalRowsDiscount'];
            $Result[$i]['TotalRowsDiscountNumberFormat'] = number_format($row['TotalRowsDiscount'],$Settings['bas_CurrencyDecimalCount'],'.',',');
            $Result[$i]['ShipmentCost'] = $row['ShipmentCost'];
            $Result[$i]['ShipmentCostNumberFormat'] = number_format($row['ShipmentCost'],$Settings['bas_CurrencyDecimalCount'],'.',',');
            $Result[$i]['ShipmentCostType'] = $ShipmentCostType;
            $Result[$i]['ShipmentCostTypeFlag'] = $row['ShipmentCostType'];
            if($row['Type'] == '1'){
                if($row['ShipmentCostType'] == '1'){
                    $Result[$i]['FinalPrice'] = $row['TotalPrice'] - $row['TotalVolumeDiscount'] - $row['TotalRowsDiscount'] - $row['ShipmentCost'];
                }
                elseif($row['ShipmentCostType'] == '2'){
                    $Result[$i]['FinalPrice'] = $row['TotalPrice'] - $row['TotalVolumeDiscount'] - $row['TotalRowsDiscount'] + $row['ShipmentCost'];
                }
            }
            elseif($row['Type'] == '0'){
                if($row['ShipmentCostType'] == '1'){
                    $Result[$i]['FinalPrice'] = $row['TotalPrice'] - $row['TotalVolumeDiscount'] - $row['TotalRowsDiscount'] + $row['ShipmentCost'];
                }
                elseif($row['ShipmentCostType'] == '2'){
                    $Result[$i]['FinalPrice'] = $row['TotalPrice'] - $row['TotalVolumeDiscount'] - $row['TotalRowsDiscount'] - $row['ShipmentCost'];
                }
            }
            $Result[$i]['FinalPriceNumberFormat'] = number_format($Result[$i]['FinalPrice'],$Settings['bas_CurrencyDecimalCount'],'.',',');
            $Result[$i]['Desc'] = $row['Desc'];
            $Result[$i]['ReferenceNo'] = $row['ReferenceNo'];

            $TotalQty = 0;

            $GetRows = $Store->SelectTransaction($Connection,'',array(),'','',array(),array(),array(),'','BuyID',$row['ID'],'RowNo','ASC','');
            for($x = 1, $xMax = count($GetRows); $x <= $xMax; $x++){
                $Result[$i]['Rows'][$x]['ID'] = $GetRows[$x]['ID'];
                $Result[$i]['Rows'][$x]['GoodsID'] = $GetRows[$x]['GoodsID'];
                $Result[$i]['Rows'][$x]['GoodsName'] = $GetRows[$x]['GoodsName'];
                $Result[$i]['Rows'][$x]['GoodsSeriesID'] = $GetRows[$x]['GoodsSeriesID'];
                $Result[$i]['Rows'][$x]['BaseUnitID'] = $GetRows[$x]['BaseUnitID'];
                $Result[$i]['Rows'][$x]['BaseUnitName'] = $GetRows[$x]['BaseUnitName'];
                $Result[$i]['Rows'][$x]['BaseUnitSymbol'] = $GetRows[$x]['BaseUnitSymbol'];
                $Result[$i]['Rows'][$x]['BaseUnitQty'] = $GetRows[$x]['BaseUnitQty'];
                $Result[$i]['Rows'][$x]['BaseUnitQtyNumberFormat'] = $GetRows[$x]['BaseUnitQtyNumberFormat'];
                $Result[$i]['Rows'][$x]['UnitID'] = $GetRows[$x]['UnitID'];
                $Result[$i]['Rows'][$x]['UnitName'] = $GetRows[$x]['UnitName'];
                $Result[$i]['Rows'][$x]['UnitSymbol'] = $GetRows[$x]['UnitSymbol'];
                $Result[$i]['Rows'][$x]['UnitQty'] = $GetRows[$x]['UnitQty'];
                $Result[$i]['Rows'][$x]['UnitQtyNumberFormat'] = $GetRows[$x]['UnitQtyNumberFormat'];
                $Result[$i]['Rows'][$x]['Price'] = $GetRows[$x]['Price'];
                $Result[$i]['Rows'][$x]['PriceNumberFormat'] = $GetRows[$x]['PriceNumberFormat'];
                $Result[$i]['Rows'][$x]['RowDiscountPercent'] = $GetRows[$x]['RowDiscountPercent'];
                $Result[$i]['Rows'][$x]['RowDiscount'] = $GetRows[$x]['RowDiscount'];
                $Result[$i]['Rows'][$x]['RowDiscountNumberFormat'] = $GetRows[$x]['RowDiscountNumberFormat'];
                $Result[$i]['Rows'][$x]['RowTotalDiscount'] = $GetRows[$x]['RowTotalDiscount'];
                $Result[$i]['Rows'][$x]['RowTotalDiscountNumberFormat'] = $GetRows[$x]['RowTotalDiscountNumberFormat'];
                $Result[$i]['Rows'][$x]['RowNo'] = $GetRows[$x]['RowNo'];
                $Result[$i]['Rows'][$x]['RowTotalPrice'] = ($Result[$i]['Rows'][$x]['Price'] * $Result[$i]['Rows'][$x]['UnitQty']) - $Result[$i]['Rows'][$x]['RowTotalDiscount'];
                $Result[$i]['Rows'][$x]['RowTotalPriceNumberFormat'] = number_format($Result[$i]['Rows'][$x]['RowTotalPrice'],$Settings['bas_CurrencyDecimalCount'],'.',',');

                $TotalQty += $Result[$i]['Rows'][$x]['UnitQty'];
            }

            $Result[$i]['TotalQty'] = $TotalQty;

            $i++;
        }

        if (isset($Result)) {
            return $Result;
        }

        return array();

    }

}
