<?php
use Symfony\Component\Form\AbstractType;
use PrestaShopBundle\Form\Admin\Type\SwitchType;


/**
 * Search on TapasRioja DB
 * @category invoices
 *
 * @author Javier Diaz
 * @copyright Javier Diaz / PrestaShop
 * @license http://www.opensource.org/licenses/osl-3.0.php Open-source licence 3.0
 * @version 0.4
 */
class AdminTrsearchController extends ModuleAdminController
{
    public function __construct()
    {
        $this->bootstrap = true;        


        $this->meta_title = 'Search TapasRioja';
        parent::__construct();
        if (!$this->module->active) {
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminHome'));
        }       
    }

    public function renderView()
    {
        $output = $this->context->smarty->fetch(_PS_MODULE_DIR_.$this->module->name.'/views/templates/admin/configure.tpl');  
            $this->addCSS('/modules/' . $this->module->name . '/views/css/back.css', 'all');
        return $output.$this->renderConfigurationForm();        

    }

    public function renderConfigurationForm()    
    {   
        $inputs = array(  
            
            array(
                'type' => 'text',
                'label' => $this->module->l('Nombre/ Empresa', 'AdminTrsearch'),                
                'name' => 'name'
            ),
             array(
                'type' => 'text',
                'label' => $this->module->l('Apellido', 'AdminTrsearch'),                
                'name' => 'surname'
            ),
             array(
                'type' => 'text',
                'prefix' => '<i class="icon-envelope-o"></i>',
                'label' => $this->module->l('Email', 'AdminTrsearch'),                
                'name' => 'email'
            ),
            array(
                'type' => 'text',
                'label' => $this->module->l('Telefono', 'AdminTrsearch'),                
                'name' => 'phone'
            ),
             array(
                'type' => 'text',
                'label' => $this->module->l('DNI/CIF', 'AdminTrsearch'),                
                'name' => 'DNI'
            ),
             array(
                'type' => 'text',
                'label' => $this->module->l('N Factura', 'AdminTrsearch'),                
                'name' => 'invoice'
            ),
             array(
                'type' => 'text',
                'label' => $this->module->l('Ref producto', 'AdminTrsearch'),                
                'name' => 'ref'
            ),
            
            
        );
    

        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->module->l('Busquedas', 'AdminTrsearch'),
                    'icon' => 'icon-cogs'
                ),
                'input' => $inputs,
                'submit' => array(
                    'title' => $this->module->l('View', 'AdminTrsearch'),
                   
                )
            ),
        );


/*
        $fields_form1 = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->module->l('Listado facturas'),
                    'icon' => 'icon-cogs'
                ), 
                
                'input' => array( 
                    array(
                        'type' => 'switch',
                        'label' => $this->module->l('CSV?', 'AdminTrsearch'),
                        'hint' => $this->module->l('No = mostrar en pantalla', 'AdminTrsearch'),
                        'name' => 'csv_active',
                        'values' => array(
                            array('id' => 'active_off', 'value' => 0),
                            array('id' => 'active_on', 'value' => 1),
                        ),
                        'is_bool' => true
                    ),           
                    array(
                        'type' => 'date',
                        'label' => $this->module->l('From', 'AdminTrsearch'),
                        'name' => 'date_from',
                        'maxlength' => 10,
                        'required' => true,
                        'desc' => $this->module->l('Choose first day of interval', 'AdminTrsearch'),
                        'hint' => $this->module->l('Format: 2011-12-31 (inclusive).', 'AdminTrsearch')
                    ),
                    array(
                        'type' => 'date',
                        'label' => $this->module->l('To', 'AdminTrsearch'),
                        'name' => 'date_to',
                        'maxlength' => 10,
                        'required' => true,
                        'desc' => $this->module->l('Choose last day of interval', 'AdminTrsearch'),
                        'hint' => $this->module->l('Format: 2012-12-31 (inclusive).', 'AdminTrsearch')
                    ),

                      
                    ),
                      'submit' => array(
                            'title' => $this->module->l('View', 'AdminTrsearch'),
                            'name' => 'list',
                        )
            )
        );

        
*/


        
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG');
        $this->fields_form = array();
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitGenerar';
        $helper->currentIndex = self::$currentIndex;
        $helper->token = Tools::getAdminTokenLite('AdminTrsearch');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );

        return $helper->generateForm(array($fields_form));
    }


    public function getConfigFieldsValues()
    {
        $today = getdate();
        return array(
            'name' =>Tools::getValue('name')?Tools::getValue('name'):"",
            'surname' => Tools::getValue('surname')?Tools::getValue('surname'):"",
            'DNI' => Tools::getValue('DNI')?Tools::getValue('DNI'):"",
            'email' => Tools::getValue('email')?Tools::getValue('email'):"",
            'phone' => Tools::getValue('phone')?Tools::getValue('phone'):"",
            'invoice' => Tools::getValue('invoice')?Tools::getValue('invoice'):"",
            'ref' => Tools::getValue('ref')?Tools::getValue('ref'):"",
         /*   'csv_active' => true,
            'date_from' => $today,
            'date_to' => $today,
         */
        );
    }

    public function postProcess()
    { 
         $this->context->smarty->assign('module_dir', _MODULE_DIR_.$this->module->name.'/');
        if (Tools::isSubmit('submitGenerar')) {
            $link = $this->context->link->getAdminLink('AdminProducts');
            $url= explode('?', $link);      
            $this->context->smarty->assign('token', $url[1]);  
            if (Tools::getValue('invoice')) 
            {
            
            $sql = new DbQuery();
            $sql->select('id_order');
            $sql->select('reference');
            $sql->from('orders', 'o');            
            $sql->where('o.invoice_number = ' . Tools::getValue('invoice'));   
            $this->context->smarty->assign('invoice', "1");
            $this->context->smarty->assign('order', Db::getInstance()->getRow($sql));           
            }
            if (Tools::getValue('ref')) 
            {  
            $sql0 = new DbQuery();
            $sql0->select('distinct product_reference');
            $sql0->select('product_name');
            $sql0->select('product_id');
            $sql0->from('order_detail');                 
            $sql0->where("product_reference LIKE '%" . Tools::getValue('ref')."%'"); 
            $result = Db::getInstance()->executeS($sql0);      
            
           $this->context->smarty->assign('product', "1");
            $this->context->smarty->assign('ref', Db::getInstance()->executeS($sql0));
            }
            if (Tools::getValue('name') || Tools::getValue('surname') 
            || Tools::getValue('email') || Tools::getValue('phone')
             || Tools::getValue('DNI')) 
            {
            $sql = new DbQuery();
            $sql->select('a.id_customer');
            $sql->select('a.firstname');
            $sql->select('a.lastname');
            $sql->select('c.email');
            $sql->select('a.phone');
            $sql->select('a.phone_mobile');
            $sql->select('o.reference');
            $sql->select('o.id_order');
            $sql->select('MAX(o.date_add) AS date');
            $sql->select('osl.name');
            $sql->from('address', 'a');
            $sql->leftJoin('customer', 'c', 'a.id_customer = c.id_customer'); 
            $sql->innerJoin('orders', 'o', 'a.id_customer = o.id_customer'); 
            $sql->leftJoin('order_state_lang', 'osl', 'o.current_state = osl.id_order_state');            
            $sql->where("(a.firstname LIKE '%" . Tools::getValue('name')."%' OR c.firstname LIKE '%" . Tools::getValue('name')."%' OR a.company LIKE '%" . Tools::getValue('name')."%') AND (a.lastname LIKE '%" . Tools::getValue('surname')."%' OR c.lastname LIKE '%" . Tools::getValue('surname')."%') AND c.email LIKE '%" . Tools::getValue('email')."%' AND (a.phone LIKE '%" . Tools::getValue('phone')."%' OR a.phone_mobile LIKE '%" . Tools::getValue('phone')."%') AND (a.dni LIKE '%" . Tools::getValue('DNI')."%'
            OR a.vat_number LIKE '%" . Tools::getValue('DNI')."%')AND osl.id_lang=1"); 
             $sql->groupBy('a.id_customer');
            
            $sqlb = new DbQuery();
            $sqlb->select('a.id_customer');
            $sqlb->select('a.firstname');
            $sqlb->select('a.lastname');
            $sqlb->select('c.email');
            $sqlb->select('a.phone');
            $sqlb->select('a.phone_mobile');
            $sqlb->select('"0"');
            $sqlb->select('"0"');
            $sqlb->select('a.date_upd');
            $sqlb->select('a.deleted');
            $sqlb->from('address', 'a');
            $sqlb->leftJoin('customer', 'c', 'a.id_customer = c.id_customer'); 
            
            $sqlb->where("(a.firstname LIKE '%" . Tools::getValue('name')."%' OR c.firstname LIKE '%" . Tools::getValue('name')."%' OR a.company LIKE '%" . Tools::getValue('name')."%') AND (a.lastname LIKE '%" . Tools::getValue('surname')."%' OR c.lastname LIKE '%" . Tools::getValue('surname')."%') AND c.email LIKE '%" . Tools::getValue('email')."%' AND (a.phone LIKE '%" . Tools::getValue('phone')."%' OR a.phone_mobile LIKE '%" . Tools::getValue('phone')."%') AND (a.dni LIKE '%" . Tools::getValue('DNI')."%'
            OR a.vat_number LIKE '%" . Tools::getValue('DNI')."%')AND a.id_customer NOT IN (SELECT id_customer FROM ps_orders)"); 
             $sqlb->groupBy('a.id_customer');
            $exec=$sql." UNION ALL ".$sqlb;
            $result=Db::getInstance()->executeS($exec);
            
            $this->context->smarty->assign('customerfound', "1");
            $this->context->smarty->assign('name', $result);
            }
        }
    }
    public function initContent()
    {
        $this->content = $this->renderView();
        parent::initContent();
    }

}
