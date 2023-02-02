#include <iostream>
#include <clocale>
#include <ctime>
#include <sstream>
#include <fstream>
#include "helpers.h"
#include "usuario.h"
#include "producto.h"
#include "ventas.h"
#include "TextArt.h"

#define USUARIOS_MAXIMOS 2
#define MAX_PRODUCTOS 50
#define MAX_VENTAS 100

#define USUARIO "CristianH"
#define CLAVE "Abarrotes10"
#define PUESTO "Empleado"

#define USUARIO2 "Diosito"
#define CLAVE2 "controlTotal"
#define PUESTO2 "Jefe de empresa"

#define C_0 0
#define C_1 1

#define DELIMITADOR_CAMPOS "|"
#define DELIMITADOR_REGISTROS '\n'
#define NOMBRE_ARCHIVO_PRODUCTOS "Productos.txt"
#define NOMBRE_ARCHIVO_VENTAS "Ventas.txt"

using namespace std;
typedef enum {GESIONAR_INVENTARIO=1, GESTIONAR_VENTAS, CERRAR_SESION} opcionesMenuPrincipal; //Opciones del menu
typedef enum {AGREGAR=1, LISTAR, CONSULTAR, MODIFICAR, ELIMINAR, AUMENTAR, SALIR_INVENTARIO} opcionesMenuInventario; //Opciones del menu
typedef enum {VENDER=1, MOSTRAR_VENTA, SALIR_VENTAS} opcionesMenuVentas; //Opciones del menu
Usuario *usuarios[USUARIOS_MAXIMOS]; //Apuntador de arreglo de los usuarios

int indiceUsuarioAccedido; //Variable que indica con que usuario se accedio
int cantidadProductos, cantidadVentas;
Producto *productos[MAX_PRODUCTOS];
Venta *ventas[MAX_VENTAS];

//Prototipos de funciones
void inicializar();
void menuInicial();
void iniciarSesion();
int escogerMenu();
void gestionarInventario();
int menuProductos();
void agregarProducto();
void listarProductos();
void consultarProducto();
void imprimirProducto(int indice);
void modificarProducto();
bool buscarProducto(int &indice);
void capturarProducto(int indice);
string generarCodigo(string nombre, string descripcion, int precio);
void eliminarProducto();
void copiarProximoObjetoProducto(int indice);
void aumentarStock();
void menuVentas();
void vender();
void registrarVenta(int indice, int cantidadVendida);
void mostrarVentas();
void cerrarSesion();
void salirDeMenu();

void guardarProductos();
void cargarProductos();
void guardarVentas();
void cargarVentas();

int main(){
    int opcion;
    system ("COLOR 9F");
    setlocale(LC_ALL, ""); //Funcion para aceptar acentos
    inicializar(); //Llamada a funcion inicialiazar
    menuInicial(); //llamada a funcion menu inicial
    if(indiceUsuarioAccedido>=C_0){ //Si tenemos acceso entonces entramos
        do{
            system(CLEAR); //Limpiar pantalla
            opcion=escogerMenu(); //Funcion menu de los productos
            switch(opcion){
                case GESIONAR_INVENTARIO:   gestionarInventario();  break;  //Si la opcion es agregar entramos en su funcion correspondiente
                case GESTIONAR_VENTAS:      menuVentas();           break;  //Si la opcion es listar entramos en su funcion correspondiente
                case CERRAR_SESION:         cerrarSesion();         break; //Si la opcion es cerrar sesion entramos en su funcion correspondiente
                default:                    cout << "\t\t\t\t Opción no valida" << endl; //Mensaje indicando que la opcion no es valida
            }
            if(opcion!=CERRAR_SESION){
                guardarProductos();
                pausaSinBuffer(); //pausa mientras no se haya cerrado sesion
            }
        }while(indiceUsuarioAccedido>=C_0); //Mientras el usuario aun tenga acceso repetirse
    }
    tituloCerrarPrograma();
    return 0;
}

void inicializar(){
    usuarios[C_0]=new Usuario((char*)USUARIO, (char*)CLAVE, (char*)PUESTO, 1); //asignar en la primera posicion del arreglo los datos del usuario
    usuarios[C_1]=new Usuario((char*)USUARIO2, (char*)CLAVE2, (char*)PUESTO2, 2); //asignar en la segunda posicion del arreglo los datos del usuario
    cargarProductos();
    cargarVentas();
}

void menuInicial(){
    int opcion; //variable que recibira la opcion escogida
    //Mensajes con las opciones del menu
    tituloIniciarSesion();
    cout << "\t\t\t\t 1)Iniciar sesion" << endl;
    cout << "\t\t\t\t Otro numero) Salir" << endl;
    cout << "\t\t\t\t -> ";
    cin  >> opcion; //capturar opcion
    system(CLEAR);
    if(opcion==C_1){ //si la opcion es 1 entra
        cin.ignore();
        iniciarSesion(); //Entrar en la funcion de iniciar sesion
    }else{
        indiceUsuarioAccedido=-1; //como no accedimos damos un valor negativo al indice
    }

}

void iniciarSesion(){
    //Variables de entrada para el nombre de usuario y clave
    char usuario[TAMANIO_NOMBRE_USUARIO+1], clave[TAMANIO_CLAVE_USUARIO+1];
    int cantidadIntentos; //contador de intentos restantes para el inicio de sesion
    bool accesoConcedido; //Variable para permitir el acceso
    cantidadIntentos=3;
    do{
        accesoConcedido=false; //Negamos el acceso al inicio
        tituloIniciarSesion();
        cout << "\t\t\t\t Usuario: ";
        cin.getline(usuario, TAMANIO_NOMBRE_USUARIO+1); //capturamos el nombre del su usuario
        cout << "\t\t\t\t Contraseña: ";
        cin.getline(clave, TAMANIO_CLAVE_USUARIO+1); //capturas la clave del usuario
        for(int i=0; i<USUARIOS_MAXIMOS && !accesoConcedido; i++){ //Buscamos en todo el arreglo mientras aun no hayamos dado acceso
            if(!strcmpi(usuario, usuarios[i]->getNombre()) //comparamos el nombre recibido con los nombres de usuarios registrados
               && !strcmpi(clave, usuarios[i]->getClave())){ //comparamos la clave recibida con los claves de usuarios registrados
                accesoConcedido=true; //si son iguales damos el acceso
                indiceUsuarioAccedido=i; //asignamos el indice con el que se accedio
            }else{
                accesoConcedido=false;//si no son iguales entonces negamos el acceso
            }
        }
        if(accesoConcedido){ //si tenemos acceso imprimimos el mensaje de bienvenida
            cout << "\t\t\t\t Acceso concedido, bienvenido" << endl;
            pausaSinBuffer();
            system(CLEAR);
        }else{ //Si no enviamos mensaje de error y los intentos restantes
            cout << "\t\t\t\t Error, usuario y/o contraseña no validos" << endl;
            cout << "\t\t\t\t Intentos restantes " << cantidadIntentos-1 << endl;
            pausaSinBuffer();
            system(CLEAR);
            cantidadIntentos--; //Decrementamos la cantidad de intentos
            if(cantidadIntentos==C_0){ //si la cantidad de intentos es 0 entonces bloqueamos la entrada al sistema
                cout << "\t\t\t\t Limite de intentos alcanzado, inicio de sesión bloqueado\n";
                indiceUsuarioAccedido=-1; //como no tenemos acceso damos un indice negativo
            }
        }
    }while(!accesoConcedido && cantidadIntentos!=C_0); //Se repite mientras no demos acceso y aun tengamos intentos
}

int escogerMenu(){
    int opcion;
    //Mensajes con las opciones
    tituloAdministradorTienda();
    cout << "\t\t\t\t 1-Gestionar Inventario" << endl;
    cout << "\t\t\t\t 2-Gestionar Ventas" << endl;
    cout << "\t\t\t\t 3-Cerrar Sesión" << endl;
    cout << "\t\t\t\t -> ";
    cin >> opcion; //capturamos la opcion
    if(opcion!=CERRAR_SESION){
        system(CLEAR); //Limpiar pantalla
    }
    return opcion;
}

void gestionarInventario(){
    int opcion;
    do{
        system(CLEAR);
        opcion=menuProductos(); //Funcion menu de los productos
        switch(opcion){
            case AGREGAR:           agregarProducto();      break;  //Si la opcion es agregar entramos en su funcion correspondiente
            case LISTAR:            listarProductos();      break;  //Si la opcion es listar entramos en su funcion correspondiente
            case CONSULTAR:         consultarProducto();    break;  //Si la opcion es consultar entramos en su funcion correspondiente
            case MODIFICAR:         modificarProducto();    break;  //Si la opcion es modificar entramos en su funcion correspondiente
            case ELIMINAR:          eliminarProducto();     break;  //Si la opcion es eliminar entramos en su funcion correspondiente
            case AUMENTAR:          aumentarStock();        break;  //Si la opcion es eliminar entramos en su funcion correspondiente
            case SALIR_INVENTARIO:  cout << "\t\t\t\t Saliendo del menú del inventario" << endl;  break; //Si la opcion es cerrar sesion entramos en su funcion correspondiente
            default:                cout << "\t\t\t\t Opción no valida" << endl; //Mensaje indicando que la opcion no es valida
        }
        if(opcion!=SALIR_INVENTARIO){
            guardarProductos();
            pausaSinBuffer(); //pausa mientras no se haya cerrado sesion
        }else{
            cin.get(); //Limpiar el buffer
        }
    }while(opcion!=SALIR_INVENTARIO); //Mientras el usuario aun tenga acceso repetirse
}

int menuProductos(){
    int opcion;
    //Mensajes con las opciones
    tituloInventario();
    cout << "\t\t\t\t 1-Agregar un producto" << endl;
    cout << "\t\t\t\t 2-Listar productos" << endl;
    cout << "\t\t\t\t 3-Consultar un producto" << endl;
    cout << "\t\t\t\t 4-Modificar un producto" << endl;
    cout << "\t\t\t\t 5-Eliminar un producto" << endl;
    cout << "\t\t\t\t 6-Añadir Stock" << endl;
    cout << "\t\t\t\t 7-Salir" << endl;
    cout << "\t\t\t\t -> ";
    cin >> opcion; //capturamos la opcion
    if(opcion!=SALIR_INVENTARIO){
        system(CLEAR); //Limpiar pantalla
    }
    return opcion;
}

void agregarProducto(){
    tituloAgregarProducto();
    cin.get(); //Limpiar buffer
    capturarProducto(cantidadProductos); //Entrar a funcion para capturar un producto pasando la posicion del arreglo donde lo guardaremos
    cantidadProductos++; //aumentamos la cantidad de productos que tenemos registrados
    cin.get(); //Limpiar buffer
}

void listarProductos(){
    tituloListarProductos();
    if(cantidadProductos!=C_0){ //Si tenemos productos registrados entonces entra
        cout << "\t\t\t\t ________________________________________________" << endl;
        cout << "\t\t\t\t |Codigo\t\t|Nombre\t\t\t|" << endl; //Titulos de cada columna
        for(int i=0; i<cantidadProductos; i++){ //Imprimir todos los registros
            cout << "\t\t\t\t |----------------------------------------------|" << endl;
            cout << "\t\t\t\t |" << productos[i]->getCodigo(); //Imprimir el codigo
            espacios(productos[i]->getCodigo().length(), 24); //Tabuladores dependiendo del tamaño del codigo
            cout << productos[i]->getNombre(); //Imprimir el nombre
            espacios(productos[i]->getNombre() .length(), 24); //Tabuladores dependiendo del tamaño del nombre
            cout << endl; //Salto de linea
        }
        cout << "\t\t\t\t |----------------------------------------------|" << endl;
    }else{ //Si no tenemos ningun producto registrado entonces envia un mensaje avisando de eso
        cout << "\t\t\t\t No hay ningún producto registrado" << endl;
    }
    cin.get();
}

void consultarProducto(){
    int indice;
    cin.get(); //Limpiar el buffer
    tituloConsultarProducto();
    if(cantidadProductos!=C_0){ //Si tenemos productos registrados entonces entra
        if(buscarProducto(indice)){ //Entramos a funcion para buscar un producto y si lo encontramos entramos
            imprimirProducto(indice); //Funcion para imprimir el producto
        }else{ //Si no se encuentra entonces enviamos un mensaje avisando de ello
            cout << "\t\t\t\t No se encontro el producto" << endl;
        }
    }else{ //Si no tenemos ningun producto registrado entonces envia un mensaje avisando de eso
        cout << "\t\t\t\t No hay ningún producto registrado" << endl;
    }
}

void imprimirProducto(int indice){
    system(CLEAR); //Limpiar pantalla
    cout << "\t\t\t__________________________________________________________________" << endl;
    cout << "\t\t\t|Codigo            |" << productos[indice]->getCodigo() << endl; //Imprimir el codigo del producto
    cout << "\t\t\t------------------------------------------------------------------" << endl;
    cout << "\t\t\t|Nombre            |" << productos[indice]->getNombre() << endl; //Imprimir el nombre del producto
    cout << "\t\t\t------------------------------------------------------------------" << endl;
    cout << "\t\t\t|Precio            |" << productos[indice]->getPrecio() << endl; //Imprimir el precio del producto
    cout << "\t\t\t------------------------------------------------------------------" << endl;
    cout << "\t\t\t|Descripción       |" << productos[indice]->getDescripcion() << endl; //Imprimir la descripción del producto
    cout << "\t\t\t------------------------------------------------------------------" << endl;
    cout << "\t\t\t|Stock             |" << productos[indice]->getStock() << endl; //Imprimir el stock del producto
    cout << "\t\t\t------------------------------------------------------------------" << endl;
    cout << "\t\t\t|Descuentos        |" << productos[indice]->getDescuentos() << endl; //Imprimir el descuento del producto
    cout << "\t\t\t------------------------------------------------------------------" << endl;
    cout << "\t\t\t|Costos por surtir |" << productos[indice]->getCostoPorSurtir() << endl; //Imprimir el costo por surtir
    cout << "\t\t\t------------------------------------------------------------------" << endl;
    cout << endl;
}

void modificarProducto(){
    int indice;
    cin.get(); //Limpiar el buffer
    tituloModificarProducto();
    if(cantidadProductos!=C_0){ //Si tenemos productos registrados entonces entra
        if(buscarProducto(indice)){ //Entramos a funcion para buscar un producto y si lo encontramos entramos
            cout << "\t\t\t\t DATOS ORIGINALES" << endl;
            imprimirProducto(indice); //Funcion para imprimir el producto
            delete productos[indice]; //Eliminamos el registro del producto encontrado
            capturarProducto(indice);  //Entramos en la funcion de capturar producto en el indice del producto que vamos a modificar
            cout << "\t\t\t\t Producto modificado" << endl; //Mensaje avisando que se modifico
        }else{ //Si no se encuentra entonces enviamos un mensaje avisando de ello
            cout << "\t\t\t\t No se encontro el producto" << endl;
        }
    }else{ //Si no tenemos ningun producto registrado entonces envia un mensaje avisando de eso
        cout << "\t\t\t\t No hay ningún producto registrado" << endl;
    }
}

bool buscarProducto(int &indice){
    bool productoEncontrado=false; //Inicializamos la bandera en falso
    string codigoIngresado;
    cout << "\t\t\t\tIngresa el codigo del producto que quieres buscar-> ";
    getline(cin, codigoIngresado); //Capturando el codigo a buscar
    for(int i=0; i<cantidadProductos; i++){ //Recorremos todos los registros del producto
        if(productos[i]->getCodigo()==codigoIngresado){ //Si el codigo ingresado es igual a uno del registro entonces entra
            indice=i; //Guardamos el indice donde se encontró
            productoEncontrado=true; //La bandera la cambiamos a verdadero
            break; //Rompemos el for
        }
    }
    return productoEncontrado; //retornamos la bandera
}

void capturarProducto(int indice){
    string codigo, nombre, descripcion;
    float precio, descuento, costoPorSurtir;
    int stock;
    cout << "\t\t\t\t Ingresa el nombre del producto-> ";
    getline(cin, nombre); //Capturamos el nombre
    cout << "\t\t\t\t Ingresa el precio-> ";
    cin >> precio; //Capturamos el precio
    cout << "\t\t\t\t Ingresa la descripción-> ";
    cin.get(); //Limpiar buffer
    getline(cin, descripcion); //Capturamos la descripción
    cout << "\t\t\t\t Ingresa la cantidad que hay en el stock-> ";
    cin >> stock; //Capturamos el stock
    cout << "\t\t\t\t Ingresa el descuento que tiene(si no tiene ingrese 0)-> ";
    cin >> descuento; //Capturamos el descuento
    cout << "\t\t\t\t Ingresa el costo por surtir-> ";
    cin >> costoPorSurtir; //Capturamos el costo por surtir
    codigo=generarCodigo(nombre, descripcion, precio); //Generamos el codigo con una funcion
    //Creamos el producto en el registro correspondiente con los datos capturados
    productos[indice] = new Producto(codigo, nombre, precio, descripcion, stock, descuento, costoPorSurtir);
    cout << "\t\t\t\t Producto agregado" << endl;
}

string generarCodigo(string nombre, string descripcion, int precio){
    int numeroAleatorio;
    string codigo, cadenaPrecio;
    stringstream casteo; //Variable para castear otras variables
    srand(time(NULL)); //Iniciamos la semilla dependiendo de la hora del sistema
    numeroAleatorio=100+rand()%(1000-100); //Numeros aleatorios entre 100 y 999
    casteo << numeroAleatorio; //Convertimos el numero aleatorio en string
    codigo=casteo.str(); //Asignamos el numero al inicio del codgio
    casteo.str(std::string()); //Limpiamos la variable para castear variables
    codigo+=nombre.substr(0,3); //Al codigo le añadimos los tres primeros caracteres del nombre
    codigo+=descripcion.substr(0,2); //Al codigo le añadimos los dos primeros caracteres de la descripción
    casteo << precio; //Convertimos el precio a string
    cadenaPrecio=casteo.str(); //La variable de casteo lo pasamos a un string
    codigo+=cadenaPrecio.substr(0,2); //Al codigo le añadimos los 3 primeros digitos del precio
    return codigo; //Retornamos el codigo generado
}

void eliminarProducto(){
    int indice, opcion;
    cin.get();
    tituloEliminarProducto();
    if(cantidadProductos!=C_0){ //Si tenemos productos registrados entonces entra
        if(buscarProducto(indice)){ //Entramos a funcion para buscar un producto y si lo encontramos entramos
            imprimirProducto(indice); //Funcion para imprimir el producto
            cout << "\t\t\t\t Seguro que quieres eliminar el producto? 1)Si Otro numero)No" << endl;
            cout << "\t\t\t\t -> ";
            cin >> opcion; //Capturamos la opcion que escogeron
            cin.get(); //Limpiar el buffer
            if(opcion==1){
                for(cantidadProductos--; indice<cantidadProductos; indice++){ //Recorremos todo el registro despue de decrementarlo
                        copiarProximoObjetoProducto(indice); //Copiamos la informacion del registro siguiente al actual
                }
                delete productos[indice]; //Eliminamos el ultimo registro
                cout << "\t\t\t\t Producto eliminado" << endl; //Mensaje avisando que se eliminó
            }else{
                cout << "\t\t\t\t El producto no se eliminó" << endl; //Mensaje avisando que no se eliminó
            }
        }else{ //Si no se encuentra entonces enviamos un mensaje avisando de ello
            cout << "\t\t\t\t No se encontro el producto" << endl;
        }
    }else{ //Si no tenemos ningun producto registrado entonces envia un mensaje avisando de eso
        cout << "\t\t\t\t No hay ningún producto registrado" << endl;
    }
}

void copiarProximoObjetoProducto(int indice){
    productos[indice]->setCodigo(productos[indice+1]->getCodigo()); //Copiamos el codigo del registro siguiente
    productos[indice]->setNombre(productos[indice+1]->getNombre()); //Copiamos el nombre del registro siguiente
    productos[indice]->setPrecio(productos[indice+1]->getPrecio()); //Copiamos el codigo del registro siguiente
    productos[indice]->setDescripcion(productos[indice+1]->getDescripcion()); //Copiamos la descripcion del registro siguiente
    productos[indice]->setStock(productos[indice+1]->getStock()); //Copiamos el stock del registro siguiente
    productos[indice]->setDescuentos(productos[indice+1]->getDescuentos()); //Copiamos el descuento del registro siguiente
    productos[indice]->setCostoPorSurtir(productos[indice+1]->getCostoPorSurtir()); //Copiamos el costo por surtir del registro siguiente
}

void aumentarStock(){
    int cantidadExtra, indice;
    cin.get(); //Limpiar el buffer
    tituloStock();
    if(cantidadProductos!=C_0){ //Si tenemos productos registrados entonces entra
        if(buscarProducto(indice)){ //Entramos a funcion para buscar un producto y si lo encontramos entramos
            imprimirProducto(indice); //Funcion para imprimir el producto
            cout << "\t\t\t\t Cuantos productos desea añadir?-> ";
            cin >> cantidadExtra;
            if(cantidadExtra<0){
                cout << "\t\t\t\t Cantidad no valida" << endl;
            }else{
                productos[indice]->setStock(productos[indice]->getStock()+cantidadExtra);
                cout << "\t\t\t\t Cantidad añadida" << endl;
            }
        cin.get();
        }else{ //Si no se encuentra entonces enviamos un mensaje avisando de ello
            cout << "\t\t\t\t No se encontro el producto" << endl;
        }
    }else{ //Si no tenemos ningun producto registrado entonces envia un mensaje avisando de eso
        cout << "\t\t\t\t No hay ningún producto registrado" << endl;
    }
}

void menuVentas(){
    int opcion;
    do{
        tituloMenuVentas();
        cout << "\t\t\t\t 1-Hacer una venta" << endl;
        cout << "\t\t\t\t 2-Mostrar ventas" << endl;
        cout << "\t\t\t\t 3-Salir" << endl;
        cout << "\t\t\t\t -> ";
        cin >> opcion; //Capturamos la opción elegida
        if(opcion!=SALIR_VENTAS){
            system(CLEAR); //Limpiar pantalla
        }
        switch(opcion){
            case VENDER:            vender();           break; //Entramos a la funcion para vender
            case MOSTRAR_VENTA:     mostrarVentas();    break;
            case SALIR_VENTAS:      cout << "\t\t\t\t Saliendo del menú de ventas" << endl;  break;
            default:                cout << "\t\t\t\t Opcion no valida" << endl;
        }
        if(opcion!=SALIR_VENTAS){
            guardarVentas();
            pausaSinBuffer();
            system(CLEAR);
        }else{
            cin.get(); //Limpiar el buffer
        }
    }while(opcion!=SALIR_VENTAS); //Repetir mientras opcion sea diferente de salir
}

void vender(){
    int opcion, indice, cantidadAVender;
    cin.get();
    if(cantidadProductos!=C_0){ //Si la opcion es que si quiere realizar la venta entonces entramos
        do{
            system(CLEAR);
            tituloRegistrarVentas();
            if(buscarProducto(indice)){ //Entramos a funcion para buscar un producto y si lo encontramos entramos
                imprimirProducto(indice); //Funcion para imprimir el producto
                cout << "\t\t\t\t Cantidad de productos a vender?-> ";
                cin >> cantidadAVender; //Capturamos la cantidad que vamos a vender
                cin.get();
                if(cantidadAVender>productos[indice]->getStock()){ //Verificamos si la cantidad no es mayor a la que tenemos en el stock y si es mayor no se vende
                    cout << "\t\t\t\t No hay suficiente stock" << endl;
                    cout << "\t\t\t\t Venta no realizada" << endl;
                }else if(cantidadAVender<=0){
                    cout << "\t\t\t\t Cantidad no valida" << endl;
                    cout << "\t\t\t\t Venta no realizada" << endl;
                }else{ //Si no es mayor entonces se realiza la venta
                    registrarVenta(indice, cantidadAVender);
                    cout << "\t\t\t\t Venta realizada y registrada" << endl;
                }
            }else{ //Si no se encuentra entonces enviamos un mensaje avisando de ello
                cout << "\t\t\t\t No se encontro el producto" << endl;
            }
            cout << "\t\t\t\t Quieres hacer otra venta? 1)Si Otro numero)No" << endl;
            cout << "\t\t\t\t -> ";
            cin >> opcion; //Capturamos la opcion de si se quiere registrar otra venta
            cin.get();
        }while(opcion==C_1);
    }else{ //Si la opcion es que no quiere registrar la venta enviamos el mensaje indicando que no se realizó
        tituloRegistrarVentas();
        cout << "\t\t\t\t No hay productos regitrados" << endl;
    }
}

void registrarVenta(int indice, int cantidadVendida){
    string nombreProductoVendido;
    double costoTotal, gananciaTotal;
    ventas[cantidadVentas] = new Venta();
    nombreProductoVendido=productos[indice]->getNombre();
    costoTotal=cantidadVendida*productos[indice]->getCostoPorSurtir();
    if(int(productos[indice]->getDescuentos())!=C_0){
        gananciaTotal=productos[indice]->getPrecio()-(productos[indice]->getPrecio()*(productos[indice]->getDescuentos()*.01));
        gananciaTotal=cantidadVendida*gananciaTotal;
    }else{
        gananciaTotal=cantidadVendida*productos[indice]->getPrecio();
    }
    gananciaTotal=gananciaTotal-costoTotal;
    productos[indice]->setStock(productos[indice]->getStock()-cantidadVendida);
    ventas[cantidadVentas]->setNombreProductoV(nombreProductoVendido);
    ventas[cantidadVentas]->setCantidadTotal(cantidadVendida);
    ventas[cantidadVentas]->setCostoTotal(costoTotal);
    ventas[cantidadVentas]->setGananciaTotal(gananciaTotal);
    cantidadVentas++;
}

void mostrarVentas(){
    tituloMostrarVentas();
    if(indiceUsuarioAccedido==C_1){
        if(cantidadVentas!=C_0){
            cout << "\t\t\t ________________________________________________________________________________________" << endl;
            cout << "\t\t\t |Nombre\t\t\t|Cantidad vendida\t|Costo total\t|Ganancia total\t|" << endl; //Titulos de cada columna
            for(int i=0; i<cantidadVentas; i++){ //Imprimir todos los registros
                cout << "\t\t\t |--------------------------------------------------------------------------------------|" << endl;
                cout << "\t\t\t |" << ventas[i]->getNombreProductosV(); //Imprimir el nombre
                espacios(ventas[i]->getNombreProductosV().length(), 32); //Tabuladores dependiendo del tamaño del nombre
                cout << ventas[i]->getCantidadTotal(); //Imprimir la cantidad total vendida
                espacios(to_string(ventas[i]->getCantidadTotal()).length(), 21); //Tabuladores dependiendo del tamaño de la cantidad vendida
                cout << ventas[i]->getCostoTotal(); //Imprimir el costo total
                espacios(to_string(ventas[i]->getCostoTotal()).length(), 21); //Tabuladores dependiendo del tamaño del costo total
                cout << ventas[i]->getGananciaTotal(); //Imprimir la ganancia total
                espacios(to_string(ventas[i]->getGananciaTotal()).length(), 21); //Tabuladores dependiendo del tamaño de la ganancia total
                cout << endl; //Salto de linea
            }
            cout << "\t\t\t |--------------------------------------------------------------------------------------|" << endl;
        }else{
            cout << "\t\t\t\t No hay ventas registradas" << endl;
        }
    }else{
        cout << "\t\t\t\t No tienes permiso para ver este aparatado" << endl;
    }

    cin.get();
}

void cerrarSesion(){
    cout << "\t\t\t\t Cerrando sesion de " << usuarios[indiceUsuarioAccedido]->getNombre() << endl; //Mensaje cerrando sesion
    pausa();
    system(CLEAR); //Limpiar pantalla
    indiceUsuarioAccedido=-1; //Damos un indice negativo para indicar que no tenemos acceso
    menuInicial(); //Entramos al menu inicial
}

void salirDeMenu(){
    cout << "\t\t\t\t Cerrando programa" << endl; //Mensaje cerrando el programa
}

void guardarProductos(){
    ofstream archivo;
    archivo.open(NOMBRE_ARCHIVO_PRODUCTOS); //Abrimos el archivo de productos
    if(archivo.is_open()){ //Si está abierto entonces guarda los registros
        archivo << cantidadProductos; //Guardamos la cantidad de los productos guardados
        for(int i=0; i<cantidadProductos; i++){ //Repetir una vez por cada producto
            archivo << endl;
            archivo << productos[i]->getCodigo() << "|"; //Guardamos el codigo junto con el delimitador
            archivo << productos[i]->getNombre() << "|"; //Guardamos el nombre junto con el delimitador
            archivo << productos[i]->getPrecio() << "|"; //Guardamos el precio junto con el delimitador
            archivo << productos[i]->getDescripcion() << "|"; //Guardamos la descripción junto con el delimitador
            archivo << productos[i]->getStock() << "|"; //Guardamos el stock junto con el delimitador
            archivo << productos[i]->getDescuentos() << "|"; //Guardamos los descuentos junto con el delimitador
            archivo << productos[i]->getCostoPorSurtir(); //Guardamos el costo por surtir junto sin delimitador porque es el ultimo campo
        }
        archivo.close();
    }else{ //Si no está abierto entonces envia mensaje de error
        cout << "Error al abrir el archivo" << endl;
    }
}

void cargarProductos(){
    ifstream archivo;
    int posInicio, posFinal;
    string cadena;
    string codigo, nombre, descripcion;
    float precio, descuento, costoPorSurtir;
    int stock;
    archivo.open(NOMBRE_ARCHIVO_PRODUCTOS); //Abrimos el archivo productos
    if(archivo.is_open()){ //Si está abierto entonces recuperamos la información
        archivo >> cantidadProductos; //Recibimos la cantidad de productos
        //archivo >> primerSaltoDeLinea; //Quitamos el salto de linea
        getline(archivo, cadena, DELIMITADOR_REGISTROS);
        for(int i=0; i<cantidadProductos; i++){
            getline(archivo, cadena, DELIMITADOR_REGISTROS); //Extraemos un registo a una cadena
            posInicio=0; //Indicamos desde donde substraeremos de la cadena
            posFinal=cadena.find_first_of(DELIMITADOR_CAMPOS, posInicio); //buscamos la posicion final del campo antes del delimitador
            codigo=cadena.substr(posInicio, posFinal-posInicio); //Substraemos la cadena con las posiciones obtenidas

            posInicio=posFinal+1; //Nos ponemos una posicion delante del delimitador para extraer el siguiente campo
            posFinal=cadena.find_first_of(DELIMITADOR_CAMPOS, posInicio); //buscamos la posicion final del campo antes del delimitador
            nombre=cadena.substr(posInicio, posFinal-posInicio); //Substraemos la cadena con las posiciones obtenidas

            posInicio=posFinal+1; //Nos ponemos una posicion delante del delimitador para extraer el siguiente campo
            posFinal=cadena.find_first_of(DELIMITADOR_CAMPOS, posInicio); //buscamos la posicion final del campo antes del delimitador
            precio=stof(cadena.substr(posInicio, posFinal-posInicio)); //Substraemos la cadena con las posiciones obtenidas y en este caso convertimos lo que obtengamos a flotante

            posInicio=posFinal+1; //Nos ponemos una posicion delante del delimitador para extraer el siguiente campo
            posFinal=cadena.find_first_of(DELIMITADOR_CAMPOS, posInicio); //buscamos la posicion final del campo antes del delimitador
            descripcion=cadena.substr(posInicio, posFinal-posInicio); //Substraemos la cadena con las posiciones obtenidas

            posInicio=posFinal+1; //Nos ponemos una posicion delante del delimitador para extraer el siguiente campo
            posFinal=cadena.find_first_of(DELIMITADOR_CAMPOS, posInicio); //buscamos la posicion final del campo antes del delimitador
            stock=stoi(cadena.substr(posInicio, posFinal-posInicio)); //Substraemos la cadena con las posiciones obtenidas y en este caso convertimos lo que obtengamos a entero

            posInicio=posFinal+1; //Nos ponemos una posicion delante del delimitador para extraer el siguiente campo
            posFinal=cadena.find_first_of(DELIMITADOR_CAMPOS, posInicio); //buscamos la posicion final del campo antes del delimitador
            descuento=stof(cadena.substr(posInicio, posFinal-posInicio)); //Substraemos la cadena con las posiciones obtenidas y en este caso convertimos lo que obtengamos a flotante

            posInicio=posFinal+1; //Nos ponemos una posicion delante del delimitador para extraer el siguiente campo
            posFinal=cadena.find_first_of(DELIMITADOR_CAMPOS, posInicio); //buscamos la posicion final del campo antes del delimitador
            costoPorSurtir=stof(cadena.substr(posInicio, posFinal-posInicio)); //Substraemos la cadena con las posiciones obtenidas y en este caso convertimos lo que obtengamos a flotante
            productos[i]=new Producto(codigo, nombre, precio, descripcion, stock, descuento, costoPorSurtir); //Creamos un objetos con los datos obtenidos
        }
        archivo.close(); //Cerramos el archivo
    }
}

void guardarVentas(){
    ofstream archivo;
    archivo.open(NOMBRE_ARCHIVO_VENTAS); //Abrimos el archivo de productos
    if(archivo.is_open()){ //Si está abierto entonces guarda los registros
        archivo << cantidadVentas; //Guardamos la cantidad de los productos guardados
        for(int i=0; i<cantidadVentas; i++){ //Repetir una vez por cada producto
            archivo << endl;
            archivo << ventas[i]->getNombreProductosV() << "|"; //Guardamos el nombre junto con el delimitador
            archivo << ventas[i]->getCantidadTotal() << "|"; //Guardamos la cantidad total junto con el delimitador
            archivo << ventas[i]->getCostoTotal() << "|"; //Guardamos el costo total junto con el delimitador
            archivo << ventas[i]->getGananciaTotal(); //Guardamos la ganancia total junto sin delimitador porque es el ultimo campo
        }
        archivo.close();
    }else{ //Si no está abierto entonces envia mensaje de error
        cout << "Error al abrir el archivo" << endl;
    }
}

void cargarVentas(){
    ifstream archivo;
    int posInicio, posFinal;
    string cadena, nombre;
    double costoTotal, gananciaTotal;
    int cantidadTotal;
    archivo.open(NOMBRE_ARCHIVO_VENTAS); //Abrimos el archivo productos
    if(archivo.is_open()){ //Si está abierto entonces recuperamos la información
        archivo >> cantidadVentas; //Recibimos la cantidad de productos
        //archivo >> primerSaltoDeLinea; //Quitamos el salto de linea
        getline(archivo, cadena, DELIMITADOR_REGISTROS);
        for(int i=0; i<cantidadVentas; i++){
            getline(archivo, cadena, DELIMITADOR_REGISTROS); //Extraemos un registo a una cadena
            posInicio=0; //Indicamos desde donde substraeremos de la cadena
            posFinal=cadena.find_first_of(DELIMITADOR_CAMPOS, posInicio); //buscamos la posicion final del campo antes del delimitador
            nombre=cadena.substr(posInicio, posFinal-posInicio); //Substraemos la cadena con las posiciones obtenidas

            posInicio=posFinal+1; //Nos ponemos una posicion delante del delimitador para extraer el siguiente campo
            posFinal=cadena.find_first_of(DELIMITADOR_CAMPOS, posInicio); //buscamos la posicion final del campo antes del delimitador
            cantidadTotal=stoi(cadena.substr(posInicio, posFinal-posInicio)); //Substraemos la cadena con las posiciones obtenidas y en este caso convertimos lo que obtengamos a entero

            posInicio=posFinal+1; //Nos ponemos una posicion delante del delimitador para extraer el siguiente campo
            posFinal=cadena.find_first_of(DELIMITADOR_CAMPOS, posInicio); //buscamos la posicion final del campo antes del delimitador
            costoTotal=atof(cadena.substr(posInicio, posFinal-posInicio).c_str()); //Substraemos la cadena con las posiciones obtenidas y en este caso convertimos lo que obtengamos a flotante

            posInicio=posFinal+1; //Nos ponemos una posicion delante del delimitador para extraer el siguiente campo
            posFinal=cadena.find_first_of(DELIMITADOR_CAMPOS, posInicio); //buscamos la posicion final del campo antes del delimitador
            gananciaTotal=atof(cadena.substr(posInicio, posFinal-posInicio).c_str()); //Substraemos la cadena con las posiciones obtenidas y en este caso convertimos lo que obtengamos a flotante

            ventas[i] = new Venta();
            ventas[i]->setNombreProductoV(nombre);
            ventas[i]->setCantidadTotal(cantidadTotal);
            ventas[i]->setCostoTotal(costoTotal);
            ventas[i]->setGananciaTotal(gananciaTotal);
        }
        archivo.close(); //Cerramos el archivo
    }
}
