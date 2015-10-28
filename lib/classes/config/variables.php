<?php
define("SSL_INSTALLED",1);
if($_SERVER['SERVER_NAME'] == 'localhost'){
	define("SITE_ADDRESS","http://".$_SERVER['SERVER_NAME']."/BSC1.0/");
}else{
	if(SSL_INSTALLED == 1 && $_SERVER['SERVER_NAME'] != 'dev.businesssupportcenter.com2'){
		$http = "https";
	}else{
		$http = "http";
	}
	define("SITE_ADDRESS",$http."://".$_SERVER['SERVER_NAME']."/");     
}
define('SALT', 'xerly_os_salt_by_intuchworl');
define("SITE_ICONS_PATH",SITE_ADDRESS."admin/images/");
define("SITE_HEADIMAGES_PATH",SITE_ICONS_PATH."header/");
define("SITE_NAME","BusinessSupportCenter.Com");
# define the database tables name
define("ORDERINVOICEHISTORY","OrderInvoiceHistory");
define("CLIENTSNOTES","ClientsNotes");
define("TAGS","Tag");
define("CLIENTTAGS","ClientTags");
define("ORDERFORM","OrderForm");
define("TIMEZONES","TimeZones");
define("ECTASKPRODUCTDATA","EcTaskProductData");
define("ECMERCHANTACCTRANSACTIONS","MerchantAccTransactions");
define("ECMANAGEMERCHANTACC","ManageMerchantAcc");
define("ECORDERDETAIL","OrderDetail");
define("ECORDERITEM","OrderItem");
define("PRODUCT","Product");
define("PRODUCTSTASKS","ProductsTasks");
define("PACKGESPRODUCTS","PackgesProducts");
define("TASKS","Tasks");
define("ECCHECKLIST","Ecchecklist");
define("TASKTOCHECKLIST","TaskChecklist");
define("PACKGES","Packges");
define("VENDORS","Vendors");
define("USERS","Users");
define("Users","Users");
define("MEMBERS","Member");
define("GROUPS","Group");
define("GROUP_USERS","Group_Users");
define("REVISION","Revision");
define("HUBFLXMEMBERS","HubFlxMember");
define("WEBSITES","Websites");
define("DEBUG","0");
define("RUNTIME_ERROR_FUNCTION","mysql_die");
define("DEBUG_FUNCTION","log_file");
define("COMPANY","Company");
define("ECCITATIONDATA","EcCitationData");
define("CLIENTS","Clients");
define("PAYMENTACCEPTED","PaymentAccepted");
define("WEBSITESERVER","WebsiteServer");
define("ECGYBDATA","EcGYBData");
define("CLIENTCCINFORMATION","ClientCCInformation");
define("PRODUCTPRICE","ProductPrice");
define("LOGINDETAIL","LoginDetail");
define("PRODUCTCATEGORY","ProductCategory");
define("USERTIMECARD","TimeCardUser");
define("BUSINESSCATEGORY","BusinessCategory");
define("ZONES","Zones");
define("EcTaskCheckListData", "EcTaskCheckListData");
define("EcTaskChecklist","EcTaskChecklist");
define("EcSubTaskChecklist","EcSubTaskChecklist");
# Added on 19th march 2014
# Fetch Sendgrid credentials
define("SENDGRID_USERNAME","220mg");
define("SENDGRID_PASSWORD","detroitLions7");
define("PRODUCTSUBSCRIPTION","ProductSubscription");
define("CITATION_WEBSITES","Citation_Websites");

define("one2pay_myPartnerKey", "3110d29ea2a668578dbc3447e876e0e14be0f2017a9d3c96457ce7f89f49757c");
define("one2pay_myPartnerPassword", "0!pQlAmZ$$");
define("one2pay_API_UserName", "a3f7c01");
define("one2pay_Partner_Email", "Amber@220mg.com");
define("one2pay_AmountCurrency", "USD");

#upto here
# lets start defining the variables which will represent the statuses in Orders page

# we should go on an integer basis.
$statusObj = array();
$statusObj[1] = array(
	"Label" => "Paid",
	"BG"	=> "#78CD51",
	"FG"	=> "#fff"
);
$statusObj[2] = array(
	"Label" => "Payment Plan",
	"BG"	=> "#78CD51",
	"FG"	=> "#fff"
);
$statusObj[3] = array(
	"Label" => "Unpaid",
	"BG"	=> "#F6846C",
	"FG"	=> "#fff"
);
$statusObj[4] = array(
	"Label" => "Closed",
	"BG"	=> "#999",
	"FG"	=> "#000"
);
$statusObj[5] = array(
	"Label" => "Canceled",
	"BG"	=> "#FFEA6A",
	"FG"	=> "#000"
);
$statusObj[6] = array(
	"Label" => "Refunded",
	"BG"	=> "#FFEA6A",
	"FG"	=> "#000"
);
$statusObj[7] = array(
	"Label" => "Partial Refund",
	"BG"	=> "#78CD51",
	"FG"	=> "#fff"
);
$statusObj[8] = array(
	"Label" => "Chargeback",
	"BG"	=> "#FFEA6A",
	"FG"	=> "#000"
);
$statusObj[9] = array(
	"Label" => "Ret. Check",
	"BG"	=> "#FFEA6A",
	"FG"	=> "#000"
);

$statusObj[10] = array(
	"Label" => "Chk NSF/Bad Acct",
	"BG"	=> "#F6846C",
	"FG"	=> "#FFF"
);

$statusObj[11] = array(
	"Label" => "Unknown",
	"BG"	=> "#F6846C",
	"FG"	=> "#FFF"
);

$statusObj[12] = array(
	"Label" => "Canceled Subscription",
	"BG"	=> "#FFEA6A",
	"FG"	=> "#000"
);

$statusObj[13] = array(
	"Label" => "Past Due",
	"BG"	=> "#F6846C",
	"FG"	=> "#fff"
);

/*
1) Paid Green BG, Gray Text
2) Payment Plan - Green BG, Gray Text
3) Unpaid- Red BG, White Text 
4) Closed - Gray BG, Black Text 
5) Canceled - same as closed
6) Refunded - same as closed
7) Partial Refund - sames as Processed
8) Chargeback - Gray BG, Red Text
9) Ret. Check -  Green BG, Gray Text
*/
?>