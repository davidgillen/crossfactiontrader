<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */


	public function index()
	{
		$this->load->view('header');
		$this->load->view('data_default');
		$this->load->view('footer');
	}

	public function aca_boundaries()
	{
		$data['locations'] = $this->loadData( 'ACA_Boundaries.xml', 'ACA_Boundaries-table', 'ACA_Boundaries');
		$data['dataType'] = 'Architectural Conversation Area';
		$data['pageTitle'] = $data['dataTypes'] = 'Architectural Conversation Areas';
		$this->loadViews($data);
	}

	public function arts_centres()
	{
		$data['locations'] = $this->loadData( 'Arts_Centres.xml', 'Arts_Centres-table', 'Arts_Centres');
		$data['dataType'] = 'Arts Centre';
		$data['pageTitle'] = $data['dataTypes'] = 'Arts Centres';
		$this->loadViews($data);
	}

	public function beaches()
	{
		$data['locations'] = $this->loadData( 'Beaches.xml', 'Beaches-table', 'Beaches');
		$data['dataType'] = 'Beach';
		$data['pageTitle'] = $data['dataTypes'] = 'Beaches';
		$this->loadViews($data);
	}

	public function bring_banks()
	{
		$data['locations'] = $this->loadData( 'Bring_Banks.xml', 'Bring_Banks-table', 'Bring_Banks', 'Location');
		$data['dataType'] = 'Bring Bank';
		$data['pageTitle'] = $data['dataTypes'] = 'Bring Banks';
		$this->loadViews($data);
	}

	public function burial_grounds()
	{
		$data['locations'] = $this->loadData( 'Burial_Grounds.xml', 'Burial_Grounds-table', 'Burial_Grounds');
		$data['dataType'] = 'Burial Ground';
		$data['pageTitle'] = $data['dataTypes'] = 'Burial Grounds';
		$this->loadViews($data);
	}

	public function christmas_trees()
	{
		$data['locations'] = $this->loadData( 'christmas_trees.xml', 'Christmas_Trees-table', 'Christmas_Trees');
		$data['dataType'] = 'Christmas Tree Collection Point';
		$data['pageTitle'] = $data['dataTypes'] = 'Christmas Tree Collection Points';
		$this->loadViews($data);
	}

	public function cinemas()
	{
		$data['locations'] = $this->loadData( 'Cinemas.xml', 'Cinemas-table', 'Cinemas');
		$data['dataType'] = 'Cinema';
		$data['pageTitle'] = $data['dataTypes'] = 'Cinemas';
		$this->loadViews($data);
	}

	public function citizens_information_centres()
	{
		$data['locations'] = $this->loadData( 'Citizens_Information_Centres.xml', 'Citizens_Information_Centres-table', 'Citizens_Information_Centres');
		$data['dataType'] = 'Citizens Information Centre';
		$data['pageTitle'] = $data['dataTypes'] = 'Citizens Information Centres';
		$this->loadViews($data);
	}

	public function council_offices()
	{
		$data['locations'] = $this->loadData( 'Council_Offices.xml', 'Council_Offices00-table', 'Council_Offices00');
		$data['dataType'] = 'Council Office';
		$data['pageTitle'] = $data['dataTypes'] = 'Council Offices';
		$this->loadViews($data);
	}

	public function disabled_parking()
	{
		$data['locations'] = $this->loadData( 'Disabled_Parking.xml', 'Disabled_Parking-table', 'Disabled_Parking', 'Area_desc');
		$data['dataType'] = 'Disabled Parking';
		$data['pageTitle'] = $data['dataTypes'] = 'Disabled Parking';
		$this->loadViews($data);
	}

	public function enterprise_centres()
	{
		$data['locations'] = $this->loadSimple('Enterprise_Centres');
		$data['dataType'] = 'Enterprise Centre';
		$data['pageTitle'] = $data['dataTypes'] = 'Enterprise Centres';
		$this->loadViews($data);
	}

	public function fire_stations()
	{
		$data['locations'] = $this->loadSimple('Fire_Stations');
		$data['dataType'] = 'Fire Station';
		$data['pageTitle'] = $data['dataTypes'] = 'Fire Stations';
		$this->loadViews($data);
	}

	public function garda_stations()
	{
		$data['locations'] = $this->loadSimple('Garda_Stations');
		$data['dataType'] = 'Garda Station';
		$data['pageTitle'] = $data['dataTypes'] = 'Garda Stations';
		$this->loadViews($data);
	}

	public function health_centres()
	{
		$data['locations'] = $this->loadSimple('Health_Centres');
		$data['dataType'] = 'Health Centre';
		$data['pageTitle'] = $data['dataTypes'] = 'Health Centres';
		$this->loadViews($data);
	}

	public function leisure_facilities() // Modified the original XML slightly
	{
		$data['locations'] = $this->loadSimple('Leisure_Facilities', 'Organisation');
		$data['dataType'] = 'Health Centre';
		$data['pageTitle'] = $data['dataTypes'] = 'Health Centres';
		$this->loadViews($data);
	}

	public function libraries()
	{
		$data['locations'] = $this->loadData( 'Libraries.xml', 'Libraries-table', 'Libraries');
		$data['dataType'] = 'Library';
		$data['pageTitle'] = $data['dataTypes'] = 'Libraries';
		$this->loadViews($data);
	}

	public function mobile_libraries()
	{
		$data['locations'] = $this->loadData( 'Mobile_Library.xml', 'Mobile_Library-table', 'Mobile_Library');
		$data['dataType'] = 'Mobile Library';
		$data['pageTitle'] = $data['dataTypes'] = 'Mobile Libraries';
		$this->loadViews($data);
	}
	
	public function play_areas()
	{
		$data['locations'] = $this->loadSimple('Play_Areas');
		$data['dataType'] = 'Play Area';
		$data['pageTitle'] = $data['dataTypes'] = 'Play Areas';
		$this->loadViews($data);
	}

	public function playing_pitches()
	{
		$data['locations'] = $this->loadSimple('Playing_Pitches', 'Facility_name');
		$data['dataType'] = 'Playing Pitch';
		$data['pageTitle'] = $data['dataTypes'] = 'Playing Pitches';
		$this->loadViews($data);
	}

	public function protected_structures()
	{
		$data['locations'] = $this->loadSimple('RPS', 'Structurename');
		$data['dataType'] = 'Protected Structure';
		$data['pageTitle'] = $data['dataTypes'] = 'Protected Structures';
		$this->loadViews($data);
	}

	public function schools()
	{
		$data['locations'] = $this->loadSimple('Schools');
		$data['dataType'] = 'School';
		$data['pageTitle'] = $data['dataTypes'] = 'Schools';
		$this->loadViews($data);
	}

	public function tourist_information()
	{
		$data['locations'] = $this->loadSimple('Tourist_Information');
		$data['dataType'] = 'Tourist Information';
		$data['pageTitle'] = $data['dataTypes'] = 'Tourist Information';
		$this->loadViews($data);
	}

	public function traffic_cameras()
	{
		$data['locations'] = $this->loadSimple('Traffic_Cameras');
		$data['dataType'] = 'Traffic Camera';
		$data['pageTitle'] = $data['dataTypes'] = 'Traffic Cameras';
		$this->loadViews($data);
	}

	public function train_stations()
	{
		$data['locations'] = $this->loadSimple('Train_Stations');
		$data['dataType'] = 'Train Station';
		$data['pageTitle'] = $data['dataTypes'] = 'Train Stations';
		$this->loadViews($data);
	}

	public function trees()
	{
		$data['locations'] = $this->loadSimple('Trees');
		$data['dataType'] = 'Tree';
		$data['pageTitle'] = $data['dataTypes'] = 'Trees';
		$this->loadViews($data);
	}

	public function weather_stations()
	{
		$data['locations'] = $this->loadSimple('Weather_Stations');
		$data['dataType'] = 'Weather Station';
		$data['pageTitle'] = $data['dataTypes'] = 'Weather Stations';
		$this->loadViews($data);
	}

	private function loadViews( $data )
	{
		$this->load->view('mappingHeader', $data);
	#	$this->load->view('data_locations', $data);
		$this->load->view('footer');
	}

	private function loadSimple( $str, $titleField = 'Name' )
	{
		return $this->loadData($str.".xml", $str."-table", $str, $titleField);
	}

	private function loadData( $file, $outerTag, $individualTag, $titleField = 'Name' )
	{
		$locations = array();
		$xml = simplexml_load_file( 'xml/'.$file );
		foreach( $xml->$outerTag->$individualTag as $node )
		{
			$loc = array();
			foreach( $node as $key=>$val)
			{
				if( 'ID' == $key || 'Id' == $key ) { // We're not interested in IDs
					continue;
				}
				if( 'LAT' == $key ) {
					$loc['latitude'] = trim($val);
				}
				else if ( 'LONG' == $key ) {
					$loc['longitude'] = trim($val);
				}
				else if ( strlen(trim($val)) > 0 ) {
					$loc['fields'][ucwords(strtolower($key))] = htmlentities(trim($val));
				}	
			}
			$loc['title'] = $loc['fields'][$titleField];
			if(!isset($loc['latitude']) || !isset($loc['longitude'])){
				continue;
			}
			$locations[] = $loc;
		}
		return $locations;
	}
}
