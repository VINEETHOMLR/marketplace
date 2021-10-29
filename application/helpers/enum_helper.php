<?php
abstract class BasicEnum {
    private static $constCacheArray = NULL;

    private static function getConstants() {
        if (self::$constCacheArray == NULL) {
            self::$constCacheArray = [];
        }
        $calledClass = get_called_class();
        if (!array_key_exists($calledClass, self::$constCacheArray)) {
            $reflect = new ReflectionClass($calledClass);
            self::$constCacheArray[$calledClass] = $reflect->getConstants();
        }
        return sehttps;//www.youtube.com/watch?v=S9DsCP9Th7Ylf::$constCacheArray[$calledClass];
    }
	
	public static function getDropDown() {
        if (self::$constCacheArray == NULL) {
            self::$constCacheArray = [];
        }
        $calledClass = get_called_class();
        if (!array_key_exists($calledClass, self::$constCacheArray)) {
            $reflect = new ReflectionClass($calledClass);
            self::$constCacheArray[$calledClass] = $reflect->getConstants();
        }
        $array	=	self::$constCacheArray[$calledClass];
		foreach( $array as $k => $v )
		{
			$result[ $v ]	=	str_ireplace( '_' , ' ' , $k );
		
		}
		return $result;
    }
	
	public static function xEditArray() {
        if (self::$constCacheArray == NULL) {
            self::$constCacheArray = [];
        }
        $calledClass = get_called_class();
        if (!array_key_exists($calledClass, self::$constCacheArray)) {
            $reflect = new ReflectionClass($calledClass);
            self::$constCacheArray[$calledClass] = $reflect->getConstants();
        }
        $array	=	self::$constCacheArray[$calledClass];
		foreach( $array as $k => $v )
		{
			$result[ ]	=	array('value'=>$v,'text'=>str_ireplace( '_' , ' ' , $k ));
		
		}
		return json_encode($result);
    }
	
	
	public static function getName($value, $strict = true)
	{
		$values =  self::getConstants();
		return array_search ($value, $values);
	}
	
	public static function getKey($value, $strict = true)
	{
		$values =  self::getConstants();
		return $values[$value];
	}
	
    public static function isValidName($name, $strict = false) {
        $constants = self::getConstants();

        if ($strict) {
            return array_key_exists($name, $constants);
        }

        $keys = array_map('strtolower', array_keys($constants));
        return in_array(strtolower($name), $keys);
    }

    public static function isValidValue($value, $strict = true) {
        $values = array_values(self::getConstants());
        return in_array($value, $values, $strict);
    }
}


/*-----------------------------------------------------------------------------------*/
/*
abstract class UserGroups extends BasicEnum {
    const ADMIN = 1;
    const MANAGER = 2;
}*/



abstract class UserGroups extends BasicEnum {
    const ADMIN = 1;
    const STOREADMIN = 2;
    //const STORESTAFF = 3;
}

abstract class CommonStatus extends BasicEnum {
    const ACTIVE = 1;
	const HOLD = 2;
}


abstract class LoginStatus extends BasicEnum {
    const ACTIVE = 1;
	const HOLD = 2;
    const BLOCKED = 3;
}

abstract class ContentTypes extends BasicEnum {
    const PAGE = 1;
	const PRODUCT = 2;
	const BLOG = 3;
	const PROJECT = 4;
	const EVENT = 5;
	const SERVICE = 6;
    const SLIDER = 7;
    const CATEGORY = 8;
}

abstract class imageType extends BasicEnum {
    const PRODUCT = 1;
	const GALLERY = 2;	
	const LOGOS = 3;	
	const SCULPTERS = 4;
	const MEDIA = 5;
	const PROJECT = 6;	
    const SERVICES = 7; 
    const CATEGORY = 7;
    const DESTINATION = 8;
    const HOTEL = 9;
    const TOUR = 10;
    const SUBCATEGORY = 10;
}

abstract class videoType extends BasicEnum {
    const PRODUCT = 1;
    const GALLERY = 2;  
    const SCULPTERS = 4;
    const MEDIA = 5;
    const PROJECT = 6;
    const DESTINATION = 7;  
}


abstract class ContactTypes extends BasicEnum {
    const BASIC = 1;
	const TYPE1 = 2;
	const TYPE2 = 3;
	
	
}


abstract class Socialmedia extends BasicEnum {
   
   const FACEBOOK = 1;
   const TWITTER = 2;
   const LINKEDIN = 3;
   const GOOGLEPLUS = 4;
   const PINTEREST = 5;

  

}
abstract class SocialmediaStatus extends BasicEnum {
   
   const ACTIVE = 1;
   const HOLD = 2;
  

}
abstract class ClientStatus extends BasicEnum {
   
   const ACTIVE = 1;
   const HOLD = 2;
  

}
abstract class PostStatus extends BasicEnum {
   
   const ACTIVE = 1;
   const HOLD = 2;
  

}


abstract class OfferStatus extends BasicEnum {
    const OFFER = 1;
    const NOOFFER = 0;
}

abstract class SizeList extends BasicEnum {
    const S = 1;
    const M = 2;
    const L = 3;
    const XL = 4;
    const XXL = 5;
}

abstract class StaffType extends BasicEnum {
    const STOREADMIN = 2;
    const STORESTAFF = 3;
}

abstract class OrderStatus extends BasicEnum {
    //const PENDING = 0;
    const ORDERPLACED = 1;
    const PACKED = 2;
    const AGENTCOLLECTED = 3;
    const OUTFORDELIVERY = 4;
    const DELIVERED = 5;
}

abstract class PaymentStatus extends BasicEnum {
    //const PENDING = 0;
    const NOTPAID = 0;
    const PAID = 1;
    
}