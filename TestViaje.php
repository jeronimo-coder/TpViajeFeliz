<?php

include_once('ViajeFeliz.php');
include_once('pasajero.php');
include_once('responsable.php');

echo "Sea bienvenido a Viaje Feliz! \n";
echo "Ingrese los datos correspondientes al viaje\n";
echo "Ingrese el codigo del viaje: \n";
$codigoViaje = trim(fgets(STDIN));
echo "Ingrese el destino del viaje: \n";
$destinoViaje = trim(fgets(STDIN));
echo "Ingrese la cantidad max de pasajeros: \n";
$maxPasajerosViaje = trim(fgets(STDIN));
echo "Responsable del viaje: \n";
$responsable = obtenerDatos("responsable");

$viaje1 = new Viaje($codigoViaje, $destinoViaje, $maxPasajerosViaje, $responsable);
$inicializar = true;

do{
    echo menu();
    $opcion = trim(fgets(STDIN));
    switch($opcion){
        case '1':
            echo $viaje1;
            break;
        
        case '2':
            if($viaje1->quedaLugar()){
                echo "Ingrese los datos del pasajero: \n";
                $pasajero = obtenerDatos("pasajero");
                if($viaje1->agregarPasajero($pasajero)){
                    echo "Agregado con exito!";
                }else{
                    echo "El pasajero ya se encuentra agendado.";
                }
            } else{
                echo "No queda más lugar.";
            }
            break;

        case '3':
            echo "Ingrese los datos del pasajero que quiere modificar: \n";
            $pasajero = obtenerDatos("pasajero");
            echo "Ingrese los nuevo datos: \n";
            $nuevosDatos = obtenerDatos("pasajero");
            if($viaje1->modificarPasajero($pasajero, $nuevosDatos)){
                echo "Modificado con exito.";
            } else {
                echo "Este pasajero no se encuentra agendado.";
            }
            break;
        
        case '4':
            echo "Ingrese los datos del pasajero que desea sacar: \n";
            $pasajeroQuitar = obtenerDatos("pasajero");
            if($viaje1->quitarPasajero($pasajeroQuitar)){
                echo "Quitado del viaje con exito.";
            }else{
                echo "Este pasajero no se encuentra agendado.";
            }
            break;
        
        case '5':
            echo "Ingrese el nuevo destino: \n";
            $destinoNuevo = trim(fgets(STDIN));
            $viaje1->setDestino($destinoNuevo);
            break;

        case '6':
            echo "Ingrese el nuevo codigo del viaje: \n";
            $codigoNuevo = trim(fgets(STDIN));
            $viaje1->setCodigo($codigoNuevo);
            break;

        case '7':
            echo "Modificar cantidad de asientos disponibles: \n";
            $nuevoMax = trim(fgets(STDIN));
            $nuevoMax = intval($nuevoMax);
            $viaje1->setMaxPasajeros($nuevoMax);
            break;
        
        case '8':
            echo "Datos del responsable: ";
            $responsableV = obtenerDatos("responsable");
            $viaje1->setResponsable($responsableV);
            break;    

        case '9':
            $inicializar = false;
           
    }
}while($inicializar);

function menu(){
    $menu = "
    1 - Informacion sobre el viaje.\n
    2 - Agregar pasajero.\n
    3 - Modificar datos del pasajero.\n
    4 - Eliminar pasajero.\n
    5 - Modificar destino del viaje.\n
    6 - Modificar codigo del viaje.\n
    7 - Modificar la cantidad de asientos habilitados.\n
    8 - Modificar datos del responsable.\n
    9 - Salir.\n";
    return $menu;
}

/** Función que obtiene los datos de cada uno de los pasajeros o responsable
 * @param string $deQuien
 * @return object
 */

function obtenerDatos($deQuien){
    if($deQuien == "pasajero"){
        echo "Nombre: \n";
        $nombre = trim(fgets(STDIN));
        echo "Apellido: \n";
        $apellido = trim(fgets(STDIN));
        echo "DNI: \n";
        $dni = intval(fgets(STDIN));
        echo "Telefono: \n";
        $telefono = trim(fgets(STDIN));
        $objeto = new Pasajero($nombre, $apellido, $dni, $telefono);
    } elseif($deQuien == "responsable"){
        echo "Número Empleado: \n";
        $numEmpleado = trim(fgets(STDIN));
        echo "Número Licencia: \n";
        $numLicencia = trim(fgets(STDIN));
        echo "Nombre: \n";
        $nombre = trim(fgets(STDIN));
        echo "Apellido: \n";
        $apellido = trim(fgets(STDIN));
        $objeto = new ResponsableV($numEmpleado, $numLicencia, $nombre, $apellido);
    }
    
    return $objeto;
}