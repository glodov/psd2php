<?php

final class File
{

	public static function url($Object, $index = '')
	{
		if ($index)
		{
			$index = '-'.$index;
		}
		return 'images/'.$Object->getImage().$index.'.jpg';
	}

	/**
	 * The function reads directory and returns files in array.
	 * 
	 * @static
	 * @access public
	 * @param $path The path of directory.
	 * @param bool $recursive The flag of recursive search or not.
	 * @param array $ignore The array of filenames which must not be in result.
	 * @param string $mask The pattern mask for search.
	 * @return array The array of fiels.
	 */
	public static function readDir( $path, $recursive = false, $ignore = null, $mask = null )
	{
		if ( !is_array( $ignore ) && $ignore !== null )
		{
			$ignore = array( $ignore );
		}
		if ( $ignore === null )
		{
			$ignore = array();
		}
		if ( !in_array( '.', $ignore ) )
		{
			$ignore[] = '.';
		}
		if ( !in_array( '..', $ignore ) )
		{
			$ignore[] = '..';
		}
		if ( !in_array( '.svn', $ignore ) )
		{
			$ignore[] = '.svn';
		}
		
		if ( $mask !== null )
		{
			$mask = strtr( preg_quote( $mask ), array(
				'\\*'	=> '.*',
				'\\?' 	=> '.{1}',
			) );
			$mask = '/^'.$mask.'$/i';
		}
		
		$result = array();
		
		$dh = opendir( $path );
		if ( $dh !== false )
		{
			while ( ( $file = readdir( $dh ) ) !== false )
			{
				if ( in_array( $file, $ignore ) )
				{
					continue;
				}
				if ( $mask === null || preg_match( $mask, $file ) )
				{
					$result[] = $path.'/'.$file;
				}
				if ( is_dir( $path.'/'.$file ) && $recursive )
				{
					$result = array_merge( $result, self::readDir( $path.'/'.$file, $recursive, $ignore ) );
				}
			}
			sort( $result );
			closedir( $dh );
		}
		
		return $result;
	}
}
