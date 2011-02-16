<?php
/*
 * Prestashop Facebook OpenGraph API module
 * Copyright (C) 2011 Miroslav Hruz, miroslav[dot]hruz[at]gmail[dot]com
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */
class FbOpenGraph extends Module
{
	private $_html = '';
	private $_postErrors = array();

	function __construct()
	{
		$this->name = 'fbopengraph';
		$this->tab = 'seo';
		$this->version = '1.0';

		parent::__construct();

		$this->displayName = $this->l('Facebook OpenGraph API extension');
		$this->description = $this->l('Uses OpenGraph META tags to improve semantic search');
	}

 	public function	install()
	{
		return (Configuration::updateValue('FACEBOOK_ADMINID', 10) AND parent::install() AND $this->registerHook('header'));
	}


	function uninstall()
	{
		return parent::uninstall();
	}
	
	private function _displayForm()
	{
  	$output .=
		'<form action="'.$_SERVER['REQUEST_URI'].'" method="post">
			<fieldset><legend><img src="'.$this->_path.'logo.gif" alt="" title="" />'.$this->l('Settings').'</legend>
				<p>'.$this->l('Facebook Admin ID').'</p><br />
				<label>'.$this->l('Your Facebook ID').'</label>
				<div class="margin-form">
					<input type="text" size="10" name="nbr" value="'.Tools::getValue('nbr', Configuration::get('FACEBOOK_ADMINID')).'" />
					<p class="clear">'.$this->l('Facebook Id').'</p>
					<h3><a href="http://www.facebook.com/whatismyid">'.$this->l('Whats my ID?').'</a></h3>
				</div>
				<center><input type="submit" name="submitFbOpenGraph" value="'.$this->l('Save').'" class="button" /></center>
			</fieldset>
		</form>';
		return $output;
	}
		
	function getContent()
	{
		$output .= '<h2>'.$this->l('Facebook OpenGraph API settings').'</h2>';
		if (Tools::isSubmit('submitFbOpenGraph'))
		{
			if (!$nbr = Tools::getValue('nbr') OR empty($nbr))
				$output .= '<div class="alert error">'.$this->l('You should fill facebook id field').'</div>';
			elseif ((int)($nbr) == 0)
				$output .= '<div class="alert error">'.$this->l('Invalid number.').'</div>';
			else
			{
				Configuration::updateValue('FACEBOOK_ADMINID', (int)($nbr));
				$output .= '<div class="conf confirm"><img src="../img/admin/ok.gif" alt="'.$this->l('Confirmation').'" />'.$this->l('Settings updated').'</div>';
			}
		}
		return $output.$this->_displayForm();
	}
	
  function endsWith($haystack,$needle,$case=true) 
   {
    if($case){
      return (strcmp(substr($haystack, strlen($haystack) - strlen($needle)),$needle)===0);
    }
    return (strcasecmp(substr($haystack, strlen($haystack) - strlen($needle)),$needle)===0);
   }
	
	function isProductPage() 
  {
    return self::endsWith($_SERVER['PHP_SELF'], '/product.php');  
  }
	
	public function hookHeader($params) {
	   global $smarty;
	   
	   //to debug this change from 0 to 1
	   $_DEBUG = 0;
	   
	   $actualUrl = 'http://' . $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	   $smarty->assign('actualUrl', $actualUrl);
	   if ($_DEBUG == 1) {
      	echo 'ActualUrl: '.$actualUrl.'</br>';
	   }
	   
	   $absoluteBaseUrl = 'http://'.htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8').__PS_BASE_URI__;
	   $smarty->assign('absoluteBaseUrl', $absoluteBaseUrl);
	   if ($_DEBUG == 1) {
	   		echo 'Absolute URL: '.$absoluteBaseUrl.'</br>';
	   }
   
     $smarty->assign('isProductPage', intval(self::isProductPage()));
	   if ($_DEBUG == 1) {
      echo 'IsProductPage: '.intval(self::isProductPage()).'</br>';
     }
     
     //if language is present
     $id_lang = $_GET['id_lang'];
     if (!isset($id_lang)) {
       //if is not present, hardcode lang_id as in www.acidx.cz :)
       //change this to whatever language code you actually use  
       $id_lang = 3;
     }
	   if ($_DEBUG == 1) {
      echo 'IdLang: '.$id_lang.'</br>';
     }     

     
     $id_fb = intval(Configuration::get('FACEBOOK_ADMINID'));
	   if ($_DEBUG == 1) {
      echo 'IdFb: '.$id_fb.'</br>';
     }
     $smarty->assign('id_fb', $id_fb);
  
     if (self::isProductPage()) {
        $id_product = $_GET['id_product'];
        if ($_DEBUG == 1) {
          echo 'IdProduct: '.$id_product.'</br>';
        }
        $smarty->assign('id_product', $id_product);
         
        $productImages = Image::getImages($id_lang, $id_product);
        if ($_DEBUG == 1) {
          echo 'ProductImages: ';
          print_r($productImages);
          echo '<br/>';
        }
        
        if (is_array($productImages) AND sizeof($productImages)) {
          
          $productImage = $productImages[0]['id_image'];
          $smarty->assign('id_image', $productImage);
          if ($_DEBUG == 1) {
            echo 'IdImage: '.$productImage.'<br/>';
          }          
        }      
     }
        
	   return $this->display(__FILE__, 'fbopengraph.tpl');      
  }
}



