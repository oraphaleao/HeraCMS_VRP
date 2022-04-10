<?php 

namespace HeraCMS\Model;

use HeraCMS;
use Xesau\SqlXS;
use Xesau\SqlXS\QueryBuilder as QB;

class Whitelist
{
	use SqlXS\XS;

	public static function SqlXS() {
		return new SqlXS\XsInfo('whitelist', 'id');
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

    /**
     * Now we add the record to avoid multiple requisitions
     * @param {string} We pick the Name of Person
     * @param {string} We pick the Steam Hex
     * @param {int} We pick the the number of hits
     */
    public static function insertWhitelist($name, $hex, $hits) {
        static::insert([
            'name' => $name,
            'steam' => $hex,
            'hits' => $hits,
            'date' => date('d/m/Y G:i', time()),
            'success' => '1'
        ]);
    }

    /**
	 * Here we gonna update the whitelist of Steam Hex
	 * @param {string}
	 */
	public static function updateWhitelist($hex) {
		$user = VrpInfos::ByID($hex);

        $user->setWhitelist('1');
	}

    /**
     * Now we add the record of blocked Steam Hex
     * @param {string} We pick the Name of Person
     */
    public static function insertBlockedWhitelist($hex, $hits, $name) {
        static::insert([
            'name' => $name,
            'steam' => $hex,
            'hits' => $hits,
            'date' => date('d/m/Y G:i', time()),
            'blocked' => '1'
        ]);
    }
}