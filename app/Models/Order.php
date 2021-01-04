<?php

/**
 * 订单操作类
 */
namespace App\models;

class Order
{
    //

    protected function __construct(array $arr)
    {
        $this->init($arr);
    }

    /**
     * 所有初始化数据
     */
    private function init($array)
    {
        //生成订单初始化数据
        $this->initAddress();
        $this->initGoods();
        $this->initFee();
    }

    /**
     * 初始化订单用户地址
     */
    private function initAddress()
    {

    }

    /**
     * 初始化用户订单商品信息
     */
    private function initGoods()
    {

    }

    /**
     * 初始化用户费用信息
     */
    private function initFee()
    {

    }

    /**
     * 生成订单
     */
    public function createOrder()
    {

    }

}
