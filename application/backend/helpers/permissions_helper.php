<?

header("Content-Type: text/html; Charset=UTF-8");

$permissions["Genel"] 				= array(
	"admin_overview" 					=> "Yönetici panelini görüntüleyebilir"
);

$permissions["İçerikler"] 				= array(
	"contents_overview" 				=> "Tüm içerikleri görüntüleyebilir", 
	"contents_add" 						=> "İçerik ekleyebilir",
	"contents_edit" 					=> "İçerik düzenleyebilir", 
	"contents_delete" 					=> "İçerik silebilir",
	"contents_categories_overview" 		=> "İçerik kategorilerini görüntüleyebilir",
	"contents_categories_add" 			=> "İçerik kategorisi ekleyebilir",
	"contents_categories_edit"			=> "İçerik kategorisi düzenleyebilir",
	"contents_categories_delete"		=> "İçerik kategorisi silebilir"
);

$permissions["Slaytlar"] 				= array(
	"sliders_overview" 					=> "Tüm slaytları görüntüleyebilir", 
	"sliders_add" 						=> "Slayt ekleyebilir",
	"sliders_edit" 						=> "Slayt düzenleyebilir", 
	"sliders_delete" 					=> "Slayt silebilir",
	"sliders_images_overview" 			=> "Slayt görsellerini görüntüleyebilir",
	"sliders_images_add" 				=> "Slayt görseli ekleyebilir",
	"sliders_images_edit"				=> "Slayt görseli düzenleyebilir/silebilir"
);

$permissions["Kullanıcılar"] 			= array(
	"users_overview" 					=> "Tüm kullanıcıları görüntüleyebilir", 
	"users_add" 						=> "Yeni kullanıcı ekleyebilir",
	"users_edit" 						=> "Kullanıcı düzenleyebilir",
	"users_delete" 						=> "Kullanıcı silebilir",
	"users_groups" 						=> "Kullanıcı gruplarını görüntüleyebilir",
	"users_groups_add" 					=> "Kullanıcı grubu ekleyebilir",
	"users_groups_edit" 				=> "Kullanıcı grubu düzenleyebilir",
	"users_groups_delete" 				=> "Kullanıcı grubu silebilir",
	"users_perms_overview" 				=> "Kullanıcı izinlerini görüntüleyebilir",
	"users_perms_edit" 					=> "Kullanıcı izini düzenleyebilir",
	"users_payments" 					=> "Hesap hareketlerini görüntüleyebilir"
);

$permissions["Menüler"]	 				= array(
	"menus_overview" 					=> "Tüm menüleri görüntüleyebilir", 
	"menus_add" 						=> "Yeni menü ekleyebilir",
	"menus_edit" 						=> "Menü düzenleyebilir",
	"menus_delete" 						=> "Menü silebilir",
	"menus_elements" 					=> "Menü bağlantılarını görüntüleyebilir",
	"menus_elements_add" 				=> "Yeni menü bağlantısı ekleyebilir",
	"menus_elements_edit" 				=> "Menü bağlantısı düzenleyebilir",
	"menu_elements_delete" 				=> "Menü bağlantısı silebilir"
);

$permissions["Ayarlar"] 				= array(
	"settings_global_overview" 			=> "Genel ayarları görüntüleyebilir",
	"settings_global_edit" 				=> "Genel ayarları düzenleyebilir",
	"settings_site_overview" 			=> "Site ayarlarını görüntüleyebilir",
	"settings_site_edit" 				=> "Site ayarlarını düzenleyebilir"
);

$permissions["Site Dilleri"] 			= array(
	"languages_overview" 				=> "Tüm site dillerini görüntüleyebilir",
	"languages_add" 					=> "Yeni site dili ekleyebilir",
	"languages_edit" 					=> "Site dilini düzenleyebilir",
	"languages_delete" 					=> "Site dilini silebilir",
	"languages_export" 					=> "Site dilini dışarı aktarabilir",
	"languages_import" 					=> "Site dilini içeri aktarabilir",
	"languages_phrase_add" 				=> "Yeni dil değişkeni ekleyebilir",
	"languages_phrase_edit" 			=> "Dil değişkeni düzenleyebilir",
	"languages_phrase_delete" 			=> "Dil değişkeni silebilir"
);

$permissions["Çöp Kutusu"] 				= array(
	"trash_overview" 					=> "Çöp kutusunu görüntüleyebilir",
	"trash_edit" 						=> "Çöp kutusundaki verileri kurtarabilir"
);

$GLOBALS['permissions'] = $permissions;
?>