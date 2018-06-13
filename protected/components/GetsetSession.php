<?php

if (!defined('YII_PATH'))
    exit('No direct script access allowed');

class GetsetSession extends CApplicationComponent
{

    private $session;

    public function getSession()
    {
        return $this->session;
    }

    public function setSession($value)
    {
        $this->session = $value;
    }

    public function getOutletId()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['Outlet_id'])) {
            $this->setOutletId(array());
        }
        return $this->session['Outlet_id'];
    }

    public function setOutletId($Outlet_id)
    {
        $this->setSession(Yii::app()->session);
        $this->session['Outlet_id'] = $Outlet_id;
    }

    public function getOutletCode()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['Outlet_code'])) {
            $this->setOutletId(array());
        }
        return $this->session['Outlet_code'];
    }

    public function setOutletCode($Outlet_id)
    {
        $this->setSession(Yii::app()->session);
        $this->session['Outlet_code'] = $Outlet_id;
    }

    public function getOutletName()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['Outlet_name'])) {
            $this->setOutletName(array('Not Set'));
        }
        return $this->session['Outlet_name'];
    }

    public function setOutletName($Outlet_data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['Outlet_name'] = $Outlet_data;
    }

    public function getOutletNameKH()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['Outlet_namekh'])) {
            $this->setOutletName(array());
        }
        return $this->session['Outlet_namekh'];
    }

    public function setOutletNameKH($Outlet_data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['Outlet_namekh'] = $Outlet_data;
    }

    public function getOutletPhone()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['Outlet_phone'])) {
            $this->setOutletPhone(array());
        }
        return $this->session['Outlet_phone'];
    }

    public function setOutletPhone($Outlet_data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['Outlet_phone'] = $Outlet_data;
    }

    public function getOutletPhone1()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['Outlet_phone1'])) {
            $this->setOutletPhone1(array());
        }
        return $this->session['Outlet_phone1'];
    }

    public function setOutletPhone1($Outlet_data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['Outlet_phone1'] = $Outlet_data;
    }

    public function getOutletAddress()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['Outlet_address'])) {
            $this->setOutletAddress(array());
        }
        return $this->session['Outlet_address'];
    }

    public function setOutletAddress($Outlet_data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['Outlet_address'] = $Outlet_data;
    }

    public function getOutletAddress1()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['Outlet_address1'])) {
            $this->setOutletAddress(array());
        }
        return $this->session['Outlet_address1'];
    }

    public function setOutletAddress1($Outlet_data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['Outlet_address1'] = $Outlet_data;
    }

    public function getOutletAddress2()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['Outlet_address2'])) {
            $this->setOutletAddress(array());
        }
        return $this->session['Outlet_address2'];
    }

    public function setOutletAddress2($Outlet_data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['Outlet_address2'] = $Outlet_data;
    }


    public function setOutletWifi($Outlet_data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['Outlet_wifi'] = $Outlet_data;
    }

    public function getOutletWifi()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['Outlet_wifi'])) {
            $this->setOutletAddress(array());
        }
        return $this->session['Outlet_wifi'];
    }

    public function getOutletEmail()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['Outlet_email'])) {
            $this->setOutletEmail(array());
        }
        return $this->session['Outlet_email'];
    }

    public function setOutletEmail($Outlet_data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['Outlet_email'] = $Outlet_data;
    }

    public function getOutletPrinterFood()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['printer_food'])) {
            $this->setOutletPrinterFood(array());
        }
        return $this->session['printer_food'];
    }

    public function setOutletPrinterFood($data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['printer_food'] = $data;
    }

    public function getOutletPrinterBeverage()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['printer_beverage'])) {
            $this->setOutletPrinterFood(array());
        }
        return $this->session['printer_beverage'];
    }

    public function setOutletPrinterBeverage($data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['printer_beverage'] = $data;
    }

    public function getOutletPrinterReceipt()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['printer_receipt'])) {
            $this->setOutletPrinterFood(array());
        }
        return $this->session['printer_receipt'];
    }

    public function setOutletPrinterReceipt($data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['printer_receipt'] = $data;
    }

    public function getOutletVat()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['Outlet_vat'])) {
            $this->setOutletVat(array());
        }
        return $this->session['Outlet_vat'];
    }

    public function setOutletVat($data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['Outlet_vat'] = $data;
    }

}

