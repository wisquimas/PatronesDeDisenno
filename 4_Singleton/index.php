<?php
/**
 * Singleton
 *
 */


/*************************************
 * Arranque
 ************************************/

try {
    $fabrica = AbstractFactory::GetFactory('vw');

    $deportivo = $fabrica->FabricarCarro('SportCar');
    var_dump($deportivo);

    $familiar = $fabrica->FabricarCarro('FamilyCar');
    var_dump($familiar);
} catch (Error $e) {
    var_dump($e);
} catch (Exception $e) {
    var_dump($e);
}