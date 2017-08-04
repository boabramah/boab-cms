<?php


	function currency($amount, $symbol='')
	{
		$defaultSymbol = empty($symbol) ? '$':$symbol;
		$amount = number_format($amount, 2, '.', ',');
		return sprintf('%s%s',$defaultSymbol,$amount);
	}

	function word_limiter($str,$lenght)
	{
		if(strlen($str) < $lenght){
			return $str;
		}
		$str = substr($str,0,$lenght);
		$exploded = explode(' ',$str);
		unset($exploded[count($exploded)-1]);
		
		return implode(' ',$exploded) .' ...';
	}

	function cur_date()
	{
		return strftime("%Y-%m-%d %H:%M:%S" , time());
	}
	
	function gender($gid = '')
	{
		$gender = array('m'=>'Male','f'=>'female');		
		$option = '';	
			foreach($gender as $key=>$value) {
				$option .= '<option value="' . $key . '"';	
				if ($gid == $key) {
					$option .= ' selected = "selected"';
				}	
				$option .= '>' .$value . '</option>';		
			}			
		return $option;	
	}
	
	function option($options,$id)
	{
		$option = '';	
			foreach($options as $key=>$value) {
				$option .= '<option value="' . $key . '"';	
				if ($id == $key) {
					$option .= ' selected = "selected"';
				}	
				$option .= '>' .$value . '</option>';		
			}			
		return $option;	
	}
	
	function statusOption($arg)
	{
		$status = array('Draft'=>2,'Publish'=>1);		
		$option = '';	
			foreach($status as $key=>$value) {
					$option .= '<option value="' . $value . '"';	
				if ($arg != '' && $arg == $value) {
					$option .= ' selected = "selected">';
				}else{
					$option .= '>';			
				}	
			$option .= $key . '</option>';		
			}			
		return $option;	
	}
	
	function status($status)
	{
		if($status == 2){
			$approve = "<font color=\"red\">Draft</font>";				
		}else{
			$approve = "<font color=\"green\">Published</font>";
		}
		return $approve;
	}

	function clean_url($str, $replace=array(), $delimiter='-') 
	{
		if( !empty($replace) ) {
			$str = str_replace((array)$replace, ' ', $str);
		}

		$clean = @iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

		//return str_replace('--',$delimiter, $clean);
		return $clean;
	}
	
	function checkBoxStatus($status, $idValue)
	{
		if($status == 1){
			$approve = "<input type = \"checkbox\" checked name =\"options[]\" value =\"$idValue\">";				
		}else{ 
			$approve = "<input type = \"checkbox\" name = \"options[]\" value = \"$idValue\">";
		}
		return $approve;
	}
	
	function rmdir_r( $dir, $DeleteMe = TRUE )
	{
		if ( ! $dh = opendir ( $dir ) ) return;
		while ( false !== ( $obj = readdir ( $dh ) ) )
		{
			if ( $obj == '.' || $obj == '..') continue;
			if ( ! unlink ( $dir . '/' . $obj ) ) rmdir_r ( $dir . '/' . $obj, true );
		}
		
		closedir ( $dh );
		if ( $DeleteMe )
		{
			rmdir ( $dir );
		}
	}

	function getMonths($month_id = null){
		$months = array(
			  'January' =>1,
			  'February'=>2,
			  'March' =>3,
			  'April'=>4,
              'May' => 5,
              'June' => 6,
              'July' => 7,
              'August' => 8,
              'September' => 9,
              'October' => 10,
              'November' => 11,
              'December' => 12
              );
	
		$monthList = '';
		foreach($months as $month =>$value) 
		{
			$monthList .= '<option value="' . $value. '"';				
				if ($month_id == $value) 
				{
					$monthList .= ' selected = "selected"';
				}	
			$monthList .= '>' . $month . '</option>';	
		}
		return $monthList;
	}
	
	// A function that will traverse a directory tree, looking for files
	// that match a given regular expression, and returns all files:
	function find_files($dir,$recursive=false) 
	{
		$regex = '/(\.jpg|\.png)$/';
		$matches = array();

		// Ok, open up the directory and prepare to start looping:
		$d = dir($dir);

		// Loop through all the files:
		while (false !== ($file = $d->read())) {
			// Skip . and .., we don't want to deal with them.
			if (($file == '.') || ($file == '..')) { continue; }

			// If this is a directory, then:
			if (is_dir("{$dir}/{$file}") AND $recursive == true) {
				// Call this function recursively to look in that subdirectory:
				$submatches = find($regex,     "{$dir}/{$file}");
				// Add them to the current match list:
				$matches = array_merge($matches, $submatches);
			} else {
				// It's a file, so check to see if it is a match:
				if (preg_match($regex, $file)) {
					// Add it to our array:
					$matches[] = "{$dir}/{$file}";
				}
			}
		}

		// Ok, that's it, return the array now:
		return $matches;
	}

	function readableFileSize($bytes, $decimals = 2) 
	{
    	$size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
    	$factor = floor((strlen($bytes) - 1) / 3);
    	return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
	}

	function addClass($string, $index)
	{
		return ($index % 2) ? $string : '';
	}