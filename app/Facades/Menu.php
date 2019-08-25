<?php
namespace App\Facades;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;

class Menu extends Facade
{

    /**
     *Metodo donde crea la estrutura del menu
     * @access public
     * @param array $data [description]
     * @return string
     */
    public static function build_menu( $data = array() )
    {
            $menu = "";
            $submenu = "";
            foreach ($data as $menus) {

                if (strtoupper($menus->tipo) == "SIMPLE" && $menus->estatus == 1) {
                    $menu .= '<li><a href="'.url($menus->link).'"><i class="'.$menus->icon.'"></i> '.$menus->texto.'</a></li>';
                }
                if (strtoupper($menus->tipo) == "PADRE" && $menus->estatus == 1 ) {
                        $menu .= '<li><a><i class="'.$menus->icon.'"></i> '.$menus->texto.' <span class="fa fa-chevron-down"></span></a>';
                        $menu .= '<ul class="nav child_menu">';
                        $menu .= self::_submenus( $data,$menus->id );
                        $menu .= '</ul>';
                        $menu .= '</li>';
                }
            }
            return $menu;

      }

    /**
     * This method is used created submenus
     * @access private
     * @param array data [description]
     * @param bool $id_menu
     * @return bool|string [type] [description]
     */
    private static function _submenus( $data= array(), $id_menu = false )
    {
        if ($id_menu && $data) {
            $submenus = "";
            foreach ($data as $submenu) {
                if (strtoupper($submenu->tipo) == "HIJO" && $submenu->id_padre == $id_menu && $submenu->estatus == 1) {
                    $submenus .= '<li><a href="'.url($submenu->link).'">'.$submenu->texto.'</a></li>';
                }
            }
            return $submenus;
        }
        return false;
    }

    /**
     * This method is build schema the menus
     * @access public
     * @param array $data [description]
     * @return string
     */
    public function buildMenuTle( $data = array() )
    {
          $menu = "";
          foreach ($data as $menus) {
              if (strtoupper($menus->tipo) == "SIMPLE" && $menus->estatus == 1) {

                    $menu .= '<li>';
                    $menu .= '<a href="'.parse_domain()->url.$menus->link.'" >';
                    $menu .= '<i class="'.$menus->icon.'"></i> <span>'.$menus->texto.'</span>';
                    $menu .= '<span class="pull-right-container">';
                    $menu .= '<small class="label pull-right bg-green"></small>';
                    $menu .= '</span>';
                    $menu .= '</a>';
                    $menu .= '</li>';
              }
              if (strtoupper($menus->tipo) == "PADRE" && $menus->estatus == 1 ) {

                    $menu .= '<li class="treeview">';
                    $menu .= '<a href="#">';
                    $menu .= '<i class="'.$menus->icon.'"></i> <span>'.$menus->texto.'</span>';
                    $menu .= '<span class="pull-right-container">';
                    $menu .= '<i class="fa fa-angle-left pull-right"></i></span></a>';
                    $menu .= '<ul class="treeview-menu">';
                    $menu .= $this->_submenusTle( $data,$menus->id );
                    $menu .= '</ul>';
                    $menu .= '</li>';

              }
          }
          return $menu;

    }

    /**
     * This method is used for created submenu to father
     * @access private
     * @param array data [description]
     * @param bool $id_menu
     * @return bool|string [type] [description]
     */
    private function _submenusTle( $data= array(), $id_menu = false )
    {
        if ($id_menu && $data) {
            $submenus = "";
            foreach ($data as $submenu) {
                if (strtoupper($submenu->tipo) == "HIJO" && $submenu->id_padre == $id_menu && $submenu->estatus == 1) {
                    $submenus .= '<li><a href="'.parse_domain()->url.$submenu->link.'"><i class="fa fa-circle-o"></i>'.$submenu->texto.'</a></li>';
                }
            }
            return $submenus;
        }
        return false;
    }




}
