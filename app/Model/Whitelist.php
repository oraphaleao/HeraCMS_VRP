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
     * Now we add the record to avoid multiple requisitions
     * @param {string} We pick the Name of Person
     * @param {string} We pick the Steam Hex
     * @param {int} We pick the the number of hits
     */
    public static function insertWhitelist($name, $hex, $hits, $type) {
        // Here we update the Whitelist of User
        $user = VrpInfos::ByID($hex);
        $user->setWhitelist('1');

        // Here we verify the type of consult and insert the into our Whitelist table to control
        if ($type == 'success') {
            static::insert([
                'name' => $name,
                'steam' => $hex,
                'hits' => $hits,
                'date' => date('d/m/Y G:i', time()),
                'success' => '1'
            ]);
        } elseif ($type == 'blocked') {
            static::insert([
                'name' => $name,
                'steam' => $hex,
                'hits' => $hits,
                'date' => date('d/m/Y G:i', time()),
                'blocked' => '1'
            ]);
        }
    }

    /**
     * Here we gonna update the Whitelist of Steam Hex
     * @param {string} Here we gonna pick the Steam Hex
     */
    public static function updateWhitelist($hex) {
        // Here we update the Whitelist of User
        $user = VrpInfos::ByID($hex);
        $user->setWhitelist('1');

        $white = static::select()->where('steam', QB::EQ, $hex)->find();
        
        return $white->setSuccess('1');
    }
}