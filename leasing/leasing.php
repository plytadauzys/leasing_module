<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

class Leasing extends Module {
    public function __construct()
    {
        $this->name = 'leasing';
        $this->tab = 'pricing_promotion';
        $this->version = '1.0.0';
        $this->author = 'Vilius Krupavičius';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.6',
            'max' => _PS_VERSION_
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Leasing module');
        $this->description = $this->l('A module for calculating leasing amounts');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        if(!Configuration::get('LEASING_A')) {
            $this->warning = $this->l('No partner provided');
        }
    }

    public  function install()
    {
        if(Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }

        if (!parent::install() ||
            !$this->registerHook('displayProductAdditionalInfo') ||
            !Configuration::updateValue('LEASING_A','') ||
            !Configuration::updateValue('LEASING_B','') ||
            !Configuration::updateValue('LEASING_C','') ||
            !Configuration::updateValue('LEASING_D','') ||
            !Configuration::updateValue('LEASING_E','') ||
            !Configuration::updateValue('LEASING_F','') ||
            !Configuration::updateValue('LEASING_G','') ||
            !Configuration::updateValue('LEASING_H','') ||
            !Configuration::updateValue('LEASING_I','') ||
            !Configuration::updateValue('LEASING_J','') ||
            !Configuration::updateValue('LEASING_K','') ||
            !Configuration::updateValue('LEASING_L','') ||
            !Configuration::updateValue('LEASING_M','') ||
            !Configuration::updateValue('LEASING_N','') ||
            !Configuration::updateValue('LEASING_O','') ||
            !Configuration::updateValue('LEASING_P','') ||
            !Configuration::updateValue('LEASING_Q','') ||
            !Configuration::updateValue('LEASING_R','') ||
            !Configuration::updateValue('LEASING_S','') ||
            !Configuration::updateValue('LEASING_T','') ||
            !Configuration::updateValue('LEASING_T_AMOUNT','') ||
            !Configuration::updateValue('LEASING_T_PERIOD','') ||
            !Configuration::updateValue('LEASING_T_INTEREST','') ||
            !Configuration::updateValue('LEASING_T_COMMISSION','') ||
            !Configuration::updateValue('LEASING_T_ADMINFEE','') ||
            !Configuration::updateValue('LEASING_T_TOTAL','') ||
            !Configuration::updateValue('LEASING_T_APR','')
        ) {
            return false;
        }

        return true;
    }

    public function uninstall()
    {
        if (!parent::uninstall() ||
            !Configuration::deleteByName('LEASING_A') ||
            !Configuration::deleteByName('LEASING_B') ||
            !Configuration::deleteByName('LEASING_C') ||
            !Configuration::deleteByName('LEASING_D') ||
            !Configuration::deleteByName('LEASING_E') ||
            !Configuration::deleteByName('LEASING_F') ||
            !Configuration::deleteByName('LEASING_G') ||
            !Configuration::deleteByName('LEASING_H') ||
            !Configuration::deleteByName('LEASING_I') ||
            !Configuration::deleteByName('LEASING_J') ||
            !Configuration::deleteByName('LEASING_K') ||
            !Configuration::deleteByName('LEASING_L') ||
            !Configuration::deleteByName('LEASING_M') ||
            !Configuration::deleteByName('LEASING_N') ||
            !Configuration::deleteByName('LEASING_O') ||
            !Configuration::deleteByName('LEASING_P') ||
            !Configuration::deleteByName('LEASING_Q') ||
            !Configuration::deleteByName('LEASING_R') ||
            !Configuration::deleteByName('LEASING_S') ||
            !Configuration::deleteByName('LEASING_T') ||
            !Configuration::deleteByName('LEASING_T_AMOUNT') ||
            !Configuration::deleteByName('LEASING_T_PERIOD') ||
            !Configuration::deleteByName('LEASING_T_INTEREST') ||
            !Configuration::deleteByName('LEASING_T_COMMISSION') ||
            !Configuration::deleteByName('LEASING_T_ADMINFEE') ||
            !Configuration::deleteByName('LEASING_T_TOTAL') ||
            !Configuration::deleteByName('LEASING_T_APR')
        ) {
            return false;
        }

        return true;
    }

    public function getContent()
    {
        $output = null;

        if (Tools::isSubmit('submit'.$this->name)) {
            $a = strval(Tools::getValue('LEASING_A'));
            $b = Tools::getValue('LEASING_B');
            $c = Tools::getValue('LEASING_C');
            $d = Tools::getValue('LEASING_D');
            $e = Tools::getValue('LEASING_E');
            $f = Tools::getValue('LEASING_F');
            $g = Tools::getValue('LEASING_G');
            $h = Tools::getValue('LEASING_H');
            $i = Tools::getValue('LEASING_I');
            $j = Tools::getValue('LEASING_J');
            $k = Tools::getValue('LEASING_K');
            $l = Tools::getValue('LEASING_L');
            $m = Tools::getValue('LEASING_M');
            $n = Tools::getValue('LEASING_N');
            $o = Tools::getValue('LEASING_O');
            $p = Tools::getValue('LEASING_P');
            $q = Tools::getValue('LEASING_Q');
            $r = Tools::getValue('LEASING_R');
            $s = Tools::getValue('LEASING_S');
            $t = Tools::getValue('LEASING_T');
            $t_amount = Tools::getValue('LEASING_T_AMOUNT');
            $t_period = Tools::getValue('LEASING_T_PERIOD');
            $t_interest = Tools::getValue('LEASING_T_INTEREST');
            $t_comission = Tools::getValue('LEASING_T_COMMISSION');
            $t_adminfee = Tools::getValue('LEASING_T_ADMINFEE');
            $t_total = Tools::getValue('LEASING_T_TOTAL');
            $t_apr = Tools::getValue('LEASING_T_APR');

            if ($a == null) {
                $output .= $this->displayError($this->l('Partner must be defined'));
            } elseif (
                $this->validateText($a) || $this->validateText($r) ||
                $this->validateText($s)
            ) {
                $output .= $this->displayError($this->l('Invalid partner, disclaimer text or template value'));
            } elseif
            (
                $this->notANumber($b) || $this->notANumber($c) ||
                $this->notANumber($d) || $this->notANumber($e) ||
                $this->notANumber($f) || $this->notANumber($g) ||
                $this->notANumber($h) || $this->notANumber($q)
            ) {
                $output .= $this->displayError($this->l('Amounts, periods and zero downpayment maximum amount values must be numbers'));
            } elseif ($this->validateAmount($b, $c, $d)) {
                $output .= $this->displayError($this->l('All 3 amount fields or none have to be defined and the fields must be defined like this: Minimum amount <= Default amount <= Maximum amount'));
            } elseif ($this->validatePeriod($e, $f, $g, $h)) {
                $output .= $this->displayError($this->l('All 4 period fields or none have to be defined and the fields must be defined like this: Minimum period <= Default period <= Maximum period'.
                    ' and Step of period <= Maximum period / 2'));
            } elseif ($this->validateDownpayment($i, $j, $k, $l)) {
                $output .= $this->displayError($this->l('All 4 downpayment fields or none have to be defined and the fields must be defined like this: '.
                    'Minimum downpayment <= Default downpayment <= Maximum downpayment and Step of downpayment <= Maximum downpayment / 2'));
            } elseif
            (
                $this->notPercantage($i) || $this->notPercantage($j) ||
                $this->notPercantage($k) || $this->notPercantage($l) ||
                $this->notPercantage($m) || $this->notPercantage($n) ||
                $this->notPercantage($o) || $this->notPercantage($p)
            ) {
                $output .= $this->displayError($this->l('Value must a percentage ( 0 <= value <= 100)'));
            } else {
                Configuration::updateValue('LEASING_A', $a);
                Configuration::updateValue('LEASING_B', $b);
                Configuration::updateValue('LEASING_C', $c);
                Configuration::updateValue('LEASING_D', $d);
                Configuration::updateValue('LEASING_E', $e);
                Configuration::updateValue('LEASING_F', $f);
                Configuration::updateValue('LEASING_G', $g);
                Configuration::updateValue('LEASING_H', $h);
                Configuration::updateValue('LEASING_I', $i);
                Configuration::updateValue('LEASING_J', $j);
                Configuration::updateValue('LEASING_K', $k);
                Configuration::updateValue('LEASING_L', $l);
                Configuration::updateValue('LEASING_M', $m);
                Configuration::updateValue('LEASING_N', $n);
                Configuration::updateValue('LEASING_O', $o);
                Configuration::updateValue('LEASING_P', $p);
                Configuration::updateValue('LEASING_Q', $q);
                Configuration::updateValue('LEASING_R', $r);
                Configuration::updateValue('LEASING_S', $s);
                Configuration::updateValue('LEASING_T', $t);
                Configuration::updateValue('LEASING_T_AMOUNT', $t_amount);
                Configuration::updateValue('LEASING_T_PERIOD', $t_period);
                Configuration::updateValue('LEASING_T_INTEREST', $t_interest);
                Configuration::updateValue('LEASING_T_COMMISSION', $t_comission);
                Configuration::updateValue('LEASING_T_ADMINFEE', $t_adminfee);
                Configuration::updateValue('LEASING_T_TOTAL', $t_total);
                Configuration::updateValue('LEASING_T_APR', $t_apr);
                $output .= $this->displayConfirmation($this->l('Settings updated'));
            }
        }

        return $output.$this->displayForm();
    }

    public function displayForm()
    {
        // Get default language
        $defaultLang = (int)Configuration::get('PS_LANG_DEFAULT');

        // Init Fields form array
        $fieldsForm[0]['form'] = [
            'legend' => [
                'title' => $this->l('Settings'),
            ],
            'input' => [
                [
                    'type' => 'text', 'label' => $this->l('Partner'), 'name' => 'LEASING_A', 'required' => true, 'desc' => $this->l('partner if left blank')
                ],
                [
                    'type' => 'text', 'label' => $this->l('Minimum amount'), 'name' => 'LEASING_B', 'desc' => $this->l('50 if left blank')
                ],
                [
                    'type' => 'text', 'label' => $this->l('Maximum amount'), 'name' => 'LEASING_C', 'desc' => $this->l('5000 if left blank')
                ],
                [
                    'type' => 'text', 'label' => $this->l('Default amount'), 'name' => 'LEASING_D', 'desc' => $this->l('2000 if left blank')
                ],
                [
                    'type' => 'text', 'label' => $this->l('Minimum period'), 'name' => 'LEASING_E', 'desc' => $this->l('3 if left blank')
                ],
                [
                    'type' => 'text', 'label' => $this->l('Maximum period'), 'name' => 'LEASING_F', 'desc' => $this->l('48 if left blank')
                ],
                [
                    'type' => 'text', 'label' => $this->l('Default period'), 'name' => 'LEASING_G', 'desc' => $this->l('24 if left blank')
                ],
                [
                    'type' => 'text', 'label' => $this->l('Step of period'), 'name' => 'LEASING_H', 'desc' => $this->l('3 if left blank')
                ],
                [
                    'type' => 'text', 'label' => $this->l('Minimum downpayment (%)'), 'name' => 'LEASING_I', 'desc' => $this->l('10 if left blank')
                ],
                [
                    'type' => 'text', 'label' => $this->l('Maximum downpayment (%)'), 'name' => 'LEASING_J', 'desc' => $this->l('90 if left blank')
                ],
                [
                    'type' => 'text', 'label' => $this->l('Default downpayment (%)'), 'name' => 'LEASING_K', 'desc' => $this->l('10 if left blank')
                ],
                [
                    'type' => 'text', 'label' => $this->l('Step of downpayment (%)'), 'name' => 'LEASING_L', 'desc' => $this->l('10 if left blank')
                ],
                [
                    'type' => 'text', 'label' => $this->l('Interest (%)'), 'name' => 'LEASING_M', 'desc' => $this->l('20.9 if left blank')
                ],
                [
                    'type' => 'text', 'label' => $this->l('Contract fee (%)'), 'name' => 'LEASING_N', 'desc' => $this->l('5.5 if left blank')
                ],
                [
                    'type' => 'text', 'label' => $this->l('Contract fee min (%)'), 'name' => 'LEASING_O', 'desc' => $this->l('10 if left blank')
                ],
                [
                    'type' => 'text', 'label' => $this->l('Admin fee (%)'), 'name' => 'LEASING_P', 'desc' => $this->l('0 if left blank')
                ],
                [
                    'type' => 'text', 'label' => $this->l('Zero downpayment maximum amount'), 'name' => 'LEASING_Q', 'desc' => $this->l('1400 if left blank')
                ],
                [
                    'type' => 'text', 'label' => $this->l('Disclaimer text'), 'name' => 'LEASING_R'
                ],
                [
                    'type' => 'text', 'label' => $this->l('Template'), 'name' => 'LEASING_S'
                ],
                [
                    'type' => 'text', 'label' => $this->l('Complicated predefined disclaimer text'), 'name' => 'LEASING_T', 'desc' => $this->l('Disclaimer text will be shown if left blank')
                ],
                [
                    'type' => 'text', 'label' => $this->l('Disclaimer loan amount'), 'name' => 'LEASING_T_AMOUNT', 'desc' => $this->l('- if left blank')
                ],
                [
                    'type' => 'text', 'label' => $this->l('Disclaimer period'), 'name' => 'LEASING_T_PERIOD', 'desc' => $this->l('- if left blank')
                ],
                [
                    'type' => 'text', 'label' => $this->l('Disclaimer interest rate'), 'name' => 'LEASING_T_INTEREST', 'desc' => $this->l('- if left blank')
                ],
                [
                    'type' => 'text', 'label' => $this->l('Disclaimer comission fee'), 'name' => 'LEASING_T_COMMISSION', 'desc' => $this->l('- if left blank')
                ],
                [
                    'type' => 'text', 'label' => $this->l('Disclaimer admin fee'), 'name' => 'LEASING_T_ADMINFEE', 'desc' => $this->l('0 if left blank')
                ],
                [
                    'type' => 'text', 'label' => $this->l('Disclaimer total amount to repaid'), 'name' => 'LEASING_T_TOTAL', 'desc' => $this->l('- if left blank')
                ],
                [
                    'type' => 'text', 'label' => $this->l('Disclaimer APR'), 'name' => 'LEASING_T_APR', 'desc' => $this->l('- if left blank')
                ],
            ],
            'submit' => [
                'title' => $this->l('Save'),
                'class' => 'btn btn-default pull-right'
            ]
        ];

        $helper = new HelperForm();

        // Module, token and currentIndex
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;

        // Language
        $helper->default_form_language = $defaultLang;
        $helper->allow_employee_form_lang = $defaultLang;

        // Title and toolbar
        $helper->title = $this->displayName;
        $helper->show_toolbar = true;        // false -> remove toolbar
        $helper->toolbar_scroll = true;      // yes - > Toolbar is always visible on the top of the screen.
        $helper->submit_action = 'submit'.$this->name;
        $helper->toolbar_btn = [
            'save' => [
                'desc' => $this->l('Save'),
                'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.
                    '&token='.Tools::getAdminTokenLite('AdminModules'),
            ],
            'back' => [
                'href' => AdminController::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules'),
                'desc' => $this->l('Back to list')
            ]
        ];

        // Load current value
        $helper->fields_value['LEASING_A'] = Tools::getValue('LEASING_A', Configuration::get('LEASING_A'));
        $helper->fields_value['LEASING_B'] = Tools::getValue('LEASING_B', Configuration::get('LEASING_B'));
        $helper->fields_value['LEASING_C'] = Tools::getValue('LEASING_C', Configuration::get('LEASING_C'));
        $helper->fields_value['LEASING_D'] = Tools::getValue('LEASING_D', Configuration::get('LEASING_D'));
        $helper->fields_value['LEASING_E'] = Tools::getValue('LEASING_E', Configuration::get('LEASING_E'));
        $helper->fields_value['LEASING_F'] = Tools::getValue('LEASING_F', Configuration::get('LEASING_F'));
        $helper->fields_value['LEASING_G'] = Tools::getValue('LEASING_G', Configuration::get('LEASING_G'));
        $helper->fields_value['LEASING_H'] = Tools::getValue('LEASING_H', Configuration::get('LEASING_H'));
        $helper->fields_value['LEASING_I'] = Tools::getValue('LEASING_I', Configuration::get('LEASING_I'));
        $helper->fields_value['LEASING_J'] = Tools::getValue('LEASING_J', Configuration::get('LEASING_J'));
        $helper->fields_value['LEASING_K'] = Tools::getValue('LEASING_K', Configuration::get('LEASING_K'));
        $helper->fields_value['LEASING_L'] = Tools::getValue('LEASING_L', Configuration::get('LEASING_L'));
        $helper->fields_value['LEASING_M'] = Tools::getValue('LEASING_M', Configuration::get('LEASING_M'));
        $helper->fields_value['LEASING_N'] = Tools::getValue('LEASING_N', Configuration::get('LEASING_N'));
        $helper->fields_value['LEASING_O'] = Tools::getValue('LEASING_O', Configuration::get('LEASING_O'));
        $helper->fields_value['LEASING_P'] = Tools::getValue('LEASING_P', Configuration::get('LEASING_P'));
        $helper->fields_value['LEASING_Q'] = Tools::getValue('LEASING_Q', Configuration::get('LEASING_Q'));
        $helper->fields_value['LEASING_R'] = Tools::getValue('LEASING_R', Configuration::get('LEASING_R'));
        $helper->fields_value['LEASING_S'] = Tools::getValue('LEASING_S', Configuration::get('LEASING_S'));
        $helper->fields_value['LEASING_T'] = Tools::getValue('LEASING_T', Configuration::get('LEASING_T'));
        $helper->fields_value['LEASING_T_AMOUNT'] = Tools::getValue('LEASING_T_AMOUNT', Configuration::get('LEASING_T_AMOUNT'));
        $helper->fields_value['LEASING_T_PERIOD'] = Tools::getValue('LEASING_T_PERIOD', Configuration::get('LEASING_T_PERIOD'));
        $helper->fields_value['LEASING_T_INTEREST'] = Tools::getValue('LEASING_T_INTEREST', Configuration::get('LEASING_T_INTEREST'));
        $helper->fields_value['LEASING_T_COMMISSION'] = Tools::getValue('LEASING_T_COMMISSION', Configuration::get('LEASING_T_COMMISSION'));
        $helper->fields_value['LEASING_T_ADMINFEE'] = Tools::getValue('LEASING_T_ADMINFEE', Configuration::get('LEASING_T_ADMINFEE'));
        $helper->fields_value['LEASING_T_TOTAL'] = Tools::getValue('LEASING_T_TOTAL', Configuration::get('LEASING_T_TOTAL'));
        $helper->fields_value['LEASING_T_APR'] = Tools::getValue('LEASING_T_APR', Configuration::get('LEASING_T_APR'));

        return $helper->generateForm($fieldsForm);
    }

    public function hookdisplayProductAdditionalInfo($params) {
        $this->context->smarty->assign([
            'my_leasing_a' => Configuration::get('LEASING_A'),
            'my_leasing_b' => Configuration::get('LEASING_B'),
            'my_leasing_c' => Configuration::get('LEASING_C'),
            'my_leasing_d' => Configuration::get('LEASING_D'),
            'my_leasing_e' => Configuration::get('LEASING_E'),
            'my_leasing_f' => Configuration::get('LEASING_F'),
            'my_leasing_g' => Configuration::get('LEASING_G'),
            'my_leasing_h' => Configuration::get('LEASING_H'),
            'my_leasing_i' => Configuration::get('LEASING_I'),
            'my_leasing_j' => Configuration::get('LEASING_J'),
            'my_leasing_k' => Configuration::get('LEASING_K'),
            'my_leasing_l' => Configuration::get('LEASING_L'),
            'my_leasing_m' => Configuration::get('LEASING_M'),
            'my_leasing_n' => Configuration::get('LEASING_N'),
            'my_leasing_o' => Configuration::get('LEASING_O'),
            'my_leasing_p' => Configuration::get('LEASING_P'),
            'my_leasing_q' => Configuration::get('LEASING_Q'),
            'my_leasing_r' => Configuration::get('LEASING_R'),
            'my_leasing_s' => Configuration::get('LEASING_S'),
            'my_leasing_t' => Configuration::get('LEASING_T'),
            'my_leasing_t_amount' => Configuration::get('LEASING_T_AMOUNT'),
            'my_leasing_t_period' => Configuration::get('LEASING_T_PERIOD'),
            'my_leasing_t_interest' => Configuration::get('LEASING_T_INTEREST'),
            'my_leasing_t_comission' => Configuration::get('LEASING_T_COMMISSION'),
            'my_leasing_t_adminfee' => Configuration::get('LEASING_T_ADMINFEE'),
            'my_leasing_t_total' => Configuration::get('LEASING_T_TOTAL'),
            'my_leasing_t_apr' => Configuration::get('LEASING_T_APR'),
            'my_module_link' => $this->context->link->getModuleLink('leasing','display'),
            'my_module_message' => $this->l('This is a simple text message')
        ]);

        return $this->display(__FILE__, 'leasing.tpl');
    }

    public function validateText($param) {
        if($param != null)
            if(!$param || empty($param) || !Validate::isGenericName($param))
                return true;
        return false;
    }

    public function notANumber($param) {
        if($param != null)
            if(!is_numeric($param) || $param < 0)
                return true;
        return false;
    }

    public function validateAmount($b, $c, $d) {
        if($b != null && $c != null && $d != null) {
            if($b <= $c && $d >= $b && $d <= $c)
                return false;
        } elseif ($b == null && $c == null && $d == null) {
            return false;
        }
        return true;
    }

    public function validatePeriod($e, $f, $g, $h) {
        if($e != null && $f != null && $g != null && $h != null) {
            if($e <= $f && $g >= $e && $g <= $f && $h <= $f / 2)
                return false;
        } elseif ($e == null && $f == null && $g == null && $h == null) {
            return false;
        }
        return true;
    }

    public function validateDownpayment($i, $j, $k, $l) {
        if($i != null && $j != null && $k != null && $l != null) {
            if($i <= $j && $k >= $i && $k <= $j && $l <= $j / 2)
                return false;
        } elseif ($i == null && $j == null && $k == null && $l == null) {
            return false;
        }
        return true;
    }

    public function notPercantage($param) {
        if($param != null)
            if(!is_numeric($param) || $param < 0 || $param > 100)
                return true;
        return false;
    }
}