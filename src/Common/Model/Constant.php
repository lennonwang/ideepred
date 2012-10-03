<?php
/**
 * Common Constant Config
 *
 * @version $Id$
 * @author purpen
 */
class Common_Model_Constant {
	
	/**
	 * 默认存储域
	 * 
	 * @var string
	 */
	const DEFAULT_DOMAIN = 'asset';
	
	/**
     * 资讯附件的存储域
     * @var string
     */
    const ARTICLE_DOMAIN = 'article';
    
    /**
     * 设计作品的存储域
     * @var string
     */
    const WORK_DOMAIN = 'work';
    
    /**
     * 申请设计师作品存储域
     * @var string
     */
    const DESIGNER_TEMP_DOMAIN = 'dtemp';
    
    /**
     * 产品的存储域
     * @var string
     */
    const PRODUCT_DOMAIN = 'product';
    
    /**
     * 广告的存储域
     * @var string
     */
    const ADVERTISE_DOMAIN = 'advertise';
    
    /**
     * 店铺图片存储域
     * @var string
     */
    const STORE_DOMAIN = 'store';
    
    /**
     * 头像附件类型
     */
    const ASSET_HEADPIC = 1;
    
	/**
	 * 第三方供图
	 * 
	 * @var int
	 */
	const ASSET_THIRD_PIC = 18;
	/**
	 * 设计师头像
	 */
	const DESIGN_HEADPIC = 9;
	
	/**
	 * 资讯的附件
	 * 
	 * @var int
	 */
	const ARTICLE_SOURCE = 8;
	/**
	 * 设计作品的缩略图
	 * @var int
	 */
	const WORK_THUMB = 10;
	/**
	 * 设计作品展示图
	 * @var int
	 */
	const WORK_SHOW = 2;
	/**
	 * 设计作品源文件
	 * @var int
	 */
	const WORK_SOURCE = 3;
	
	/**
     * 申请设计师作品
     * 
     * @var int
     */
    const DESIGNER_TEMP_WORK = 18;
    
    /**
     * 广告展示图
     * 
     * @var int
     */
    const ADVERTISE = 66;
    
    /**
     * 主题缩略图
     * 
     * @var int
     */
    const TOPIC_THUMB = 30;
    
    /**
     * 主题头图
     * 
     * @var int
     */
    const TOPIC_SHOW = 31;
    
    const PRODUCT_PHOTO = 32;
    
    /**
     * 产品正面大图
     * @var int
     */
    const PRODUCT_THUMB = 4;
    /**
     * 产品细节图片
     * @var int
     */
    const PRODUCT_WHOLE = 5;
    /**
     * 产品内容图片
     * @var int
     */
    const PRODUCT_SOURCE = 7;
    
    /**
     * 礼品的缩略图
     * @var int
     */
    const GIFT_THUMB = 12;
    /**
     * 礼品展示图
     * @var int
     */
    const GIFT_SHOW = 13;
    
    /**
     * 类别缩略图
     * 
     * @var int
     */
    const CATEGORY_THUMB = 33;
    
    /**
     * 店铺缩略图
     * @var int
     */
    const STORE_THUMB = 44;
    /**
     * 店铺展示图
     * @var int
     */
    const STORE_SHOW = 45;
    
    /**
     * 首页大图
     * 
     * @var int
     */
    const BIGIMG_THUMB = 14;
    
	/**
	 * 设计作品的标签关联类型
	 * @var int
	 */
	const TAG_REF_WORK = 1;
	
	/**
     * 产品的标签关联类型
     * @var int
     */
    const TAG_REF_PRODUCT = 2;
    
    /**
     * 已过期订单
     * 
     * @var int
     */
    const ORDER_EXPIRED = -1;
    
    /**
     * 已取消的订单
     * 
     * @var int
     */
    const ORDER_CANCELED = 0;
    
    /**
     * 等待付款状态
     * 
     * @var int
     */
    const ORDER_WAIT_PAYMENT = 1;
    /**
     * 等待审核状态
     * 
     * @var int
     */
    const ORDER_WAIT_CHECK = 5;
    /**
     * 正在配货状态
     * 
     * @var int
     */
    const ORDER_READY_GOODS = 10;
    /**
     * 订单已发货状态
     * 
     * @var int
     */
    const ORDER_SENDED_GOODS = 15;
    /**
     * 订单已完成状态
     * 
     * @var int
     */
    const ORDER_PUBLISHED = 20;
     
    
}
/**vim:sw=4 et ts=4 **/
?>