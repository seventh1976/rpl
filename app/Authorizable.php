<?php

namespace App;

/**
 * A trait to handle authorization on users permissions for given Controller
 */
trait Authorizable
{
  /**
   * Abilities
   * @var array
   */
  private $abilities = [
    'index' => 'view',
    'edit' => 'edit',
    'show' => 'view',
    'update' => 'edit',
    'create' => 'add',
    'store' => 'add',
    'destroy' => 'delete'
  ];
  /**
   * Override of callAction to perform the authorization before it calls the action
   * @param $method
   * @param $parameters
   * @return mixed
   */
  function callAction($method, $parameters)
  {
    if($ability = $this->getAbility($method)) {
      $this->authorize($ability);
    }

    return parent::callAction($method, $parameters);
  }

  /**
   * getAbility
   * @param $method
   * @return null|string
   */
  public function getAbility($method)
  {
    $routeName = explode('.', \Request::route()->getName());
    $action = array_get($this->getAbilities(),$method);

    return $action ? $action . '_' . $routeName[0] : null;
  }

  /**
   * [getAbilities description]
   * @return array
   */
  private function getAbilities()
  {
    return $this->abilities;
  }

  /**
   * [setAbilities description]
   * @param array $abilities
   */
  public function setAbilities($abilities)
  {
    $this->abilities = $abilities;
  }
}
