<?php

if (!function_exists('textile')) {
	function textile($markup) {
		return app('textile')->parse($markup);
	}
}

if (!function_exists('objectify')) {
	function objectify($data) {
		return json_decode(json_encode($data));
	}
}