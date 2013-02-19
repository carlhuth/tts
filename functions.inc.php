<?php /* $Id: $ */
if (!defined('FREEPBX_IS_AUTH')) { die('No direct script access allowed');}
//This program is free software; you can redistribute it and/or
//modify it under the terms of the GNU General Public License
//as published by the Free Software Foundation; either version 2
//of the License, or (at your option) any later version.
//
//This program is distributed in the hope that it will be useful,
//but WITHOUT ANY WARRANTY; without even the implied warranty of
//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//GNU General Public License for more details.
//
// Original texttospeech Author: Xavier Ourciere xourciere[at]propolys[dot]com


if ( (isset($amp_conf['ASTVARLIBDIR'])?$amp_conf['ASTVARLIBDIR']:'') == '') {
	$astlib_path = "/var/lib/asterisk";
} else {
	$astlib_path = $amp_conf['ASTVARLIBDIR'];
}
$tts_astsnd_path = $astlib_path."/sounds/tts/";


if ( $tts_agi = file_exists($astlib_path."/agi-bin/propolys-tts.agi") ) {
	//tts_findengines();
} else {
	$tts_agi_error = _("AGI script not found");
}

// returns a associative arrays with keys 'destination' and 'description'
function tts_destinations() {
	$results = tts_list();

	// return an associative array with destination and description
	if (isset($results) && $results){
		foreach($results as $result){
				$extens[] = array('destination' => 'ext-tts,'.$result['id'].',1', 'description' => $result['name']);
		}

		return $extens;
	} else {
		return null;
	}
}

function tts_get_config($p_var) {
	global $ext;

	switch($p_var) {
		case "asterisk":
			$contextname = 'ext-tts';
			if ( is_array($tts_list = tts_list()) ) {
				foreach($tts_list as $item) {
					$tts = tts_get($item['id']);
					$ttsid = $tts['id'];
					$ttsname= $tts['name'];
					$ttstext = $tts['text'];
					$ttsgoto = $tts['goto'];
					$ttsengine = $tts['engine'];
					$ttspath = ttsengines_get_engine_path($ttsengine);
					$ext->add($contextname, $ttsid, '', new ext_noop('TTS: '.$ttsname));
					$ext->add($contextname, $ttsid, '', new ext_noop('Using: '.$ttsengine));
					$ext->add($contextname, $ttsid, '', new ext_answer());
					$ext->add($contextname, $ttsid, '', new ext_agi('propolys-tts.agi|'.$ttstext.'|'.$ttsengine.'|'.$ttspath['path']));
					$ext->add($contextname, $ttsid, '', new ext_goto($ttsgoto));
				}
			}
		break;
	}
}

function tts_list() {
	global $db;
	$sql = "SELECT id, name FROM tts ORDER BY name";
	$res = $db->getAll($sql, DB_FETCHMODE_ASSOC);
	if(DB::IsError($res)) {
		return null;
	}
	return $res;
}

function tts_get($p_id) {
	global $db;
	$sql = "SELECT id, name, text, goto, engine FROM tts WHERE id=$p_id";
	$res = $db->getRow($sql, DB_FETCHMODE_ASSOC);
	return $res;
}

function tts_del($p_id) {
	$results = sql("DELETE FROM tts WHERE id=$p_id","query");
}

function tts_add($p_name, $p_text, $p_goto, $p_engine) {
	$tts_list = tts_list();
	if (is_array($tts_list)) {
		foreach ($tts_list as $tts) {
			if ($tts['name'] === $p_name) {
				echo "<script>javascript:alert('"._("This name already exists")."');</script>";
				return false;
			}
		}
	}
	$results = sql("INSERT INTO tts SET name=".sql_formattext($p_name)." , text=".sql_formattext($p_text).", goto=".sql_formattext($p_goto).", engine=".sql_formattext($p_engine));
}

function tts_update($p_id, $p_name, $p_text, $p_goto, $p_engine) {
	$results = sql("UPDATE tts SET name=".sql_formattext($p_name).", text=".sql_formattext($p_text).", goto=".sql_formattext($p_goto).", engine=".sql_formattext($p_engine)." WHERE id=".$p_id);
}

?>
