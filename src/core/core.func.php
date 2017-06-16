<?php

/**
 * Main functions
 */

/**
 * Prcess request
 */
require_once 'RequestHandler.php';
function addRequestHandler(){
    $requestUriInfo = parse_url($_SERVER['REQUEST_URI']);
    $requestPaths = explode('/', $requestUriInfo['path']);
    $requestHandler = new RequestHandler($requestPaths);
    $requestHandler->registerAction('login','User', 'login_page');
    $requestHandler->registerAction('logout','User', 'logout');
    $requestHandler->registerAction('post','Post', 'get_post');
    $requestHandler->registerAction('posts','Post', 'get_posts');
    $requestHandler->registerAction('profile','Post', 'get_user_info');
    $requestHandler->registerAction('registration','User', 'registration');
    return $requestHandler->callController();
}


function process_request() {
    $responseData = addRequestHandler();
    if( !isset($responseData['view']) || !isset($responseData['data']) ){
    if(!isset($responseData['redirect'])){
      exit('Action "' . $requestHandler->getActionName() . '" doesn\'t return proper response!.'); //ToDo: make proper low-level error handling
    }
    else{
      header('Location:'.$responseData['redirect']);
      exit();
    }
  }
  load_view($responseData['view'], $responseData['data']);
}
/**
 * Makes scope for view data, shows base template frame
 * and adds globals view variables (for all actions).
 * 
 * @param string $view_name
 * @param array $data
 */
function load_view($view_name, $data) {
  /* ? Check $view_name ? */
  if (file_exists(SITE_PATH . '/views/' . $view_name . '.inc.php')) {
    // Add global view variabls to this scope
    $user = get_authorized_user();
    // Make response
    require SITE_PATH . '/views/_blocks/header.inc.php';
    require SITE_PATH . '/views/' . $view_name . '.inc.php';
    require SITE_PATH . '/views/_blocks/footer.inc.php';
  } else {
    // In more complex system better use exceptions.
    exit('No such template: ' . $view_name . '.inc.php');
  }
}