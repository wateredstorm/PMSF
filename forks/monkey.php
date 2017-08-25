<?php>

class MonkeyFork{
	public function get_gyms($swLat, $swLng, $neLat, $neLng, $tstamp = 0, $oSwLat = 0, $oSwLng = 0, $oNeLat = 0, $oNeLng = 0) {
       t3.lat, 
       t3.lon, 
       t1.last_modified, 
       t1.team, 
       t1.slots_available, 
       t1.guard_pokemon_id 
FROM   (SELECT fort_id, 
               Max(last_modified) AS MaxLastModified 
        FROM   fort_sightings 
        GROUP  BY fort_id) t2 
       LEFT JOIN fort_sightings t1 
              ON t2.fort_id = t1.fort_id 
                 AND t2.maxlastmodified = t1.last_modified 
       LEFT JOIN forts t3 
              ON t1.fort_id = t3.id")->fetchAll();
        } elseif ($tstamp > 0) {
            $datas = $db->query("SELECT t3.external_id, 
       t3.lat, 
       t3.lon, 
       t1.last_modified, 
       t1.team, 
       t1.slots_available, 
       t1.guard_pokemon_id 
FROM   (SELECT fort_id, 
               Max(last_modified) AS MaxLastModified 
        FROM   fort_sightings 
        GROUP  BY fort_id) t2 
       LEFT JOIN fort_sightings t1 
              ON t2.fort_id = t1.fort_id 
                 AND t2.maxlastmodified = t1.last_modified 
       LEFT JOIN forts t3 
              ON t1.fort_id = t3.id 
WHERE  t3.lat > :swLat 
       AND t3.lon > :swLng 
       AND t3.lat < :neLat 
       AND t3.lon < :neLng",[':swLat' => $swLat, ':swLng' => $swLng, ':neLat' => $neLat, ':neLng' => $neLng])->fetchAll();
        } elseif ($oSwLat != 0) {
            $datas = $db->query("SELECT t3.external_id, 
       t3.lat, 
       t3.lon, 
       t1.last_modified, 
       t1.team, 
       t1.slots_available, 
       t1.guard_pokemon_id 
FROM   (SELECT fort_id, 
               Max(last_modified) AS MaxLastModified 
        FROM   fort_sightings 
        GROUP  BY fort_id) t2 
       LEFT JOIN fort_sightings t1 
              ON t2.fort_id = t1.fort_id 
                 AND t2.maxlastmodified = t1.last_modified 
       LEFT JOIN forts t3 
              ON t1.fort_id = t3.id 
WHERE  t3.lat > :swLat 
       AND t3.lon > :swLng
       AND t3.lat < :neLat
       AND t3.lon < :neLng
       AND NOT( t3.lat > :oSwLat
                AND t3.lon > :oSwLng
                AND t3.lat < :oNeLat
                AND t3.lon < :oNeLng)", [':swLat' => $swLat, ':swLng' => $swLng, ':neLat' => $neLat, ':neLng' => $neLng,  ':oSwLat' => $oSwLat, ':oSwLng' => $oSwLng, ':oNeLat' => $oNeLat, ':oNeLng' => $oNeLng])->fetchAll();
        } else {
            $datas = $db->query("SELECT    t3.external_id, 
          t3.lat, 
          t3.lon, 
          t1.last_modified, 
          t1.team, 
          t1.slots_available, 
          t1.guard_pokemon_id 
FROM      ( 
                   SELECT   fort_id, 
                            Max(last_modified) AS maxlastmodified 
                   FROM     fort_sightings 
                   GROUP BY fort_id) t2 
LEFT JOIN fort_sightings t1 
ON        t2.fort_id = t1.fort_id 
AND       t2.maxlastmodified = t1.last_modified 
LEFT JOIN forts t3 
ON        t1.fort_id = t3.id 
WHERE     t3.lat > :swLat
AND       t3.lon > :swLng 
AND       t3.lat < :neLat 
AND       t3.lon < :neLng",[':swLat' => $swLat, ':swLng' => $swLng, ':neLat' => $neLat, ':neLng' => $neLng])->fetchAll();
		$gyms = array();
		return $gyms;
	}
}
