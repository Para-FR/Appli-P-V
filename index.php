<?php
/**
 * Created by PhpStorm.
 * User: Para
 * Date: 01/06/2017
 * Time: 16:26
 */
require_once ('./admin/includes/config.php');
if (internauteEstConnecte() || internauteEstConnecteEtEstAdmin()){
    header('Location:./admin/modules/index/index');
}else{
    header('Location:login');
}
