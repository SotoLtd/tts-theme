<?php
//  Event Table
//
class AdministrateWidgetEventTable2 extends AdministrateEventWidget2 {
    public $wurl;
    public $wpath;
    public function __construct($service) {
		parent::__construct($service, 'event_table_2');
		$this->wpath = untrailingslashit(get_stylesheet_directory()) . '/courses/adminstrate/shortcodes/event_table_2/';
		$this->wurl = untrailingslashit(get_stylesheet_directory_uri()) . '/courses/adminstrate/shortcodes/event_table_2/';
		add_action( 'wp_enqueue_scripts', array($this, 'assets') );
	}
	public function assets(){
		wp_enqueue_style( 'administrate_event_table' );
		wp_enqueue_script( 'administrate_tablesorter', $this->service->get_url('/js/jquery.tablesorter.js'), array('jquery'), false, true );
		//wp_enqueue_script( 'administrate_event_table', plugins_url('event_table.js', __FILE__), array('jquery'), false, true);
		wp_enqueue_script( 'administrate_tablesorter_pager', $this->service->get_url('/js/jquery.tablesorter.pager.js'), array('jquery', 'administrate_tablesorter'), false, true );
		wp_enqueue_script( 'administrate_event_table', $this->service->get_url('/js/jquery.administrate_event_table.js'), array('jquery', 'administrate_tablesorter', 'administrate_tablesorter_pager'), false, true );
	}
	public function run($widget_params = array()) {
		parent::run($widget_params);
		if( $this->params['show_categories'] ) {
			$this->params['categories_list'] = Administrate::api()->get_category_list( $this->params['event_filter'] );
		}
		
		$this->params['locations_list'] = Administrate::api()->get_events_locations( $this->params['event_list'] );
		$this->params['num_saved_months'] = 6;
                ob_start();
                extract($this->params);
                include($this->wpath . 'views/event_table_2.php');
                $contents = ob_get_contents();
                ob_end_clean();
                return $contents;
	}
}