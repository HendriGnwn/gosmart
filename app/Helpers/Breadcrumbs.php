<?php

namespace App\Helpers;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Breadcrumbs
{
	/**
	 * render breadcrumbs
	 * 
	 * @param type $attributes
	 * @param type $firstAttribute
	 * @return string
	 */
	public static function render($attributes = [], $firstAttribute = [])
	{
		if (count($firstAttribute) == 0) {
			$firstAttribute = [
				'title' => 'Home',
				'url' => url('/home'),
			];
		}
		
		$html = "<ol class='breadcrumb'>";
		
		$title = isset($firstAttribute['title']) ? $firstAttribute['title'] : null;
		$url = isset($firstAttribute['url']) ? "<a href='" . $firstAttribute['url'] . "'>$title</a>" : $title;
		$html .= "<li>$url</li>";
		$count = count($attributes);
		if ($count > 0) {
			foreach ($attributes as $key => $attribute) {
				$active = ($count - 1) == $key ? "class='active'" : '';

				if (is_array($attribute)) {
					$title = isset($attribute['title']) ? $attribute['title'] : null;
					$url = isset($attribute['url']) ? "<a href='" . $attribute['url'] . "'>$title</a>" : $title;
					$html .= "<li $active>$url</li>";
				} else {
					$html .= "<li $active>$attribute</li>";
				}
			}
		}
		$html .= '</ol>';
		
		return $html;
	}
}