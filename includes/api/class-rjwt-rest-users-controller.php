<?php

class RJWT_REST_Users_Controller extends WP_REST_Controller {

  /**
   * Register the routes for the objects of the controller.
   */
  public function register_routes() {
    $version = '1';
    $namespace = 'rjwt/v' . $version;
    $base = 'user';
    register_rest_route( $namespace, '/' . $base, array(
      array(
        'methods'               => WP_REST_Server::CREATABLE,
        'callback'              => array( $this, 'create_item' ),
        'permission_callback'   => array( $this, 'create_item_permissions_check' ),
        'args' => array(
          'username' => array(
            'description' => 'Username',
            'required'    => true,
            'type'        => 'string',
            'sanitize_callback'  => 'sanitize_text_field',
          ),
          'email' => array(
            'description' => 'E-mail',
            'required'    => true,
            'type'        => 'string',
            'sanitize_callback'  => 'sanitize_text_field',
            'validate_callback'	 => 'is_email',
          ),
          'password' => array(
            'description' => 'Password',
            'required'    => true,
            'type'        => 'string',
            'sanitize_callback'  => 'sanitize_text_field',
          ),
          'first_name' => array(
            'description' => 'First name',
            'required'    => false,
            'type'        => 'string',
            'sanitize_callback'  => 'sanitize_text_field',
          ),
          'last_name' => array(
            'description' => 'Last name',
            'required'    => false,
            'type'        => 'string',
            'sanitize_callback'  => 'sanitize_text_field',
          )
        )
      )
    ));

  }

  /**
   * Create user
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|WP_REST_Response
   */
  public function create_item( $request ) {
    if ( !class_exists('Jwt_Auth_Public') ) {
        return new WP_Error( 'rjwt_rest_no_jwt_plugin', __( 'Please install JWT Authentication Plugin', 'rjwt' ), array() );
    }
    try {
  		$user_data = array(
  			'user_login' 	=> $request['username'],
  			'user_pass' 	=> $request['password'],
  			'user_email'	=> $request['email'],
  			'first_name'	=> $request['first_name'],
  			'last_name'		=> $request['last_name'],
  			'display_name'	=> $request['first_name'] . ' ' . $request['last_name']
  		);

  		$user_id = wp_insert_user( $user_data );

  		if ( is_wp_error( $user_id ) ) {
  		    return $user_id;
  		}

  		return $this->generate_jwt_token( $request );
  	} catch (Exception $err) {
  		return new WP_Error( 'rjwt_rest_cannot_register_user', __( 'Could not register new user', 'rjwt' ), array() );
  	}
  }
  
  /**
   * Generate JWT token after registration
   */
  public function generate_jwt_token($request) {
  	$jwt = new Jwt_Auth_Public( 'jwt-auth', '1.1.0' );
  	return $jwt->generate_token($request);
  }

  /**
   * Check if a given request has access to get items
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|bool
   */
  public function create_item_permissions_check( $request ) {
    return true;
  }

  /**
   * Prepare the item for create or update operation
   *
   * @param WP_REST_Request $request Request object
   * @return WP_Error|object $prepared_item
   */
  protected function prepare_item_for_database( $request ) {
    return array();
  }

  /**
   * Prepare the item for the REST response
   *
   * @param mixed $item WordPress representation of the item.
   * @param WP_REST_Request $request Request object.
   * @return mixed
   */
  public function prepare_item_for_response( $item, $request ) {
    return array();
  }

}