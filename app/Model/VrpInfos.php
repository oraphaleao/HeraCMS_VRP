<?php 

namespace HeraCMS\Model;

use HeraCMS;
use Xesau\SqlXS;
use Xesau\SqlXS\QueryBuilder as QB;

class VrpInfos
{
	use SqlXS\XS;

	public static function SqlXS() {
		return new SqlXS\XsInfo('vrp_infos', 'steam');
	}
	
	/**
	 * Here we gonna consult if exist
	 * @param {string} Pass the value of Steam Hex
	 * 
	 * @return {boolean} true|false
	 */
	public static function verifyHex($hex) {
		return static::count()->where('steam', QB::EQ, $hex)->count() > 0 ? true : false;
	}

	/**
     * Here we gonna verify if the Steam has success
     * @param {string} We pick the Steam Hex
     * 
     * @return {boolean} true|false
     */
    public static function verifyStatus($hex) {
        return static::count()->where('steam', QB::EQ, $hex)->where('success', QB::EQ, 1)->count() > 0 ? true : false;
    }

    /**
     * Here we gonna verify if the Steam it's blocked
     * @param {string} We pick the Steam Hex
     * 
     * @return {boolean} true|false
     */
    public static function verifyBlocked($hex) {
        return static::count()->where('steam', QB::EQ, $hex)->where('blocked', QB::EQ, 1)->count() > 0 ? true : false;
    }
}