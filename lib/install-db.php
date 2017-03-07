
<?php


function modula_lite_install_db() 
{
  global $wpdb;			  

  $ModulaGalleries = $wpdb->ModulaGalleries;
  $ModulaImages = $wpdb->ModulaImages;
  
  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		
		
  $sql = "CREATE TABLE $ModulaGalleries (
	 	Id INT NOT NULL AUTO_INCREMENT, 
		configuration VARCHAR( 5000 ) NOT NULL, 
		
        UNIQUE KEY id (id)
  ) DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci;";
	
  dbDelta($sql);

  $sql = "CREATE TABLE  $ModulaImages (
		Id INT NOT NULL AUTO_INCREMENT, 
		gid INT NOT NULL, 
		imageId INT NOT NULL, 
		imagePath LONGTEXT NOT NULL, 
		link LONGTEXT NULL,
		target VARCHAR(50) NULL,
		filters VARCHAR( 1500 ) NULL,
		description LONGTEXT NOT NULL,
        title LONGTEXT NOT NULL, 
		sortOrder INT NOT NULL,  
		valign VARCHAR(50) DEFAULT \"middle\" NOT NULL,
		halign VARCHAR(50) DEFAULT \"center\" NOT NULL,
		UNIQUE KEY id (Id) 
	) DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci";

	dbDelta($sql);

}
