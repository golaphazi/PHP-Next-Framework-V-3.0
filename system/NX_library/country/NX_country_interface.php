<?php
namespace NX\Country\InterfaceApps;
interface NX_Country_interface{
	
	public function get_country_info($ip= '', $type='code');
	
	public function geoipaddrfrom();
	
	public function geoipaddrupto();
	
	public function geoipctry();
	
	public function geoipcntry();
	
	public function geoipcountry();
	
	public function geoipcache();
}
?>