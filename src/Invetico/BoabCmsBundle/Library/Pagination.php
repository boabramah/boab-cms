<?php

namespace Invetico\BoabCmsBundle\Library;

class Pagination 
{
	private $rows_per_page; //Number of records to display per page
	private $total_rows; //Total number of rows returned by the query
	private $links_per_page; //Number of links to display per page
	private $append = ""; //Paremeters to append to pagination links
	private $page;
	private $max_pages;
	

	function __construct(array $config)
	{
		$this->links_per_page 	=  $config['links_per_page'];
		$this->rows_per_page 	=  $config['rows_per_page'];
	}
	
	
	function generate( array $option = [] ) 
	{
		$this->total_rows 	=  $option['page_total_rows'];
		$this->append 		=  $option['page_url'];
		$this->page 		=  $option['page_number'];

		if ($this->total_rows < 1){
			return FALSE;
		}
		
		//Max number of pages
		$this->max_pages = ceil($this->total_rows / $this->rows_per_page );
		if ($this->links_per_page > $this->max_pages) {
			$this->links_per_page = $this->max_pages;
		}
		
		//Check the page value just in case someone is trying to input an aribitrary value
		if ($this->page > $this->max_pages || $this->page <= 0) {
			$this->page = 1;
		}
		
		return $this->renderFullNav();
	}
	
	
	/**
	 * Display the link to the first page
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to 'First'
	 * @return string
	 */
	function renderFirst($tag = 'First') 
	{
		if ($this->page == 1) {
			return '<li><a class="previous-off">' . $tag .'</a></li>';
		} else {
			return '<li><a href="' . $this->formateLink(1) .'">' . $tag . '</a></li>';
		}
	}
	
	/**
	 * Display the link to the last page
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to 'Last'
	 * @return string
	 */
	function renderLast($tag = 'Last') 
	{
		if ($this->page == $this->max_pages) {
			return '<li><a class="previous-off">' . $tag .'</a></li>';
		} else {
			return '<li><a href="' . $this->formateLink( $this->max_pages ) .'" class="next">' . $tag . '</a></li>';
		}
	}
	
	/**
	 * Display the next link
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to '>>'
	 * @return string
	 */
	function renderNext($tag = 'next &raquo;') 
	{
		if ($this->page < $this->max_pages) {
			return '<li><a href="' . $this->formateLink( $this->page + 1 ) .'" class="next">' . $tag . '</a></li>';
		} else {
			return '<li><a class="previous-off">' . $tag .'</a></li>';
		}
	}
	
	/**
	 * Display the previous link
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to '<<'
	 * @return string
	 */
	function renderPrev($tag = '&laquo; previous') 
	{
		if ($this->page > 1) {
			return '<li><a href="' . $this->formateLink($this->page - 1) .'" class="next">' . $tag . '</a></li>';
		} else {
			return '<li><a class="previous-off">' . $tag .'</a></li>';
		}
	}
	
	/**
	 * Display the page links
	 *
	 * @access public
	 * @return string
	 */
	function renderRange($prefix = '<a class="page_link">', $suffix = '</a>') 
	{
		
		$batch = ceil($this->page / $this->links_per_page );
		$end = $batch * $this->links_per_page;
		if ($end > $this->max_pages) {
			$end = $this->max_pages;
		}
		$start = $end - $this->links_per_page + 1;
		$links = '';
		
		for($i = $start; $i <= $end; $i ++) {
			if ($i == $this->page) {
				$links .= '<li class="active"><a >' . $i . '</a></li>';
			} else {
				$links .= '<li><a href="' . $this->formateLink($i) . '">' . $i . '</a></li>';
			}
		}
		
		return $links;
	}
	
	
	function formateLink($pageNumber)
	{		
		return $this->append . (strpos($this->append,'?') ? '&':'?') . 'page='. $pageNumber;
	}
	
	/**
	 * Display full pagination navigation
	 *
	 * @access public
	 * @return string
	 */
	function renderFullNav() 
	{
		return '<ul class="pagination">'.$this->renderFirst().$this->renderPrev() .  $this->renderRange() . $this->renderNext() . $this->renderLast().'</ul>';
	}
	
}
