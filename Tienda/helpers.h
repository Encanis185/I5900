//Limpiar portable ependiendo del sistema operativo
#ifndef HELPERS_H_INCLUDED
#define HELPERS_H_INCLUDED
#ifdef _WIN32
    #define CLEAR "cls"
#elif defined(unix)
    #define CLEAR "clear"
#else
    #error "S0 no soportado para limpiar pantalla"
#endif

using namespace std;

void pausa(){
    cin.get(); //Eliminamos buffer
    cout << "\t\t\t\t Presione enter para continuar...";
    cin.get(); //Detenemos el programa hasta recibir un enter
}

void pausaSinBuffer(){
    cout << "\t\t\t\t Presione enter para continuar...";
    cin.get(); //Detenemos el programa hasta recibir un enter
}

void espacios(int longitudPalabra, int limite){
    while(longitudPalabra<limite){ //repetir hsata que la longitud alcance al limite
        cout << "\t"; //Tabulador
        longitudPalabra=longitudPalabra+8; //Aumentar el tamaño de un tabulador
    }
    cout << "|"; //Imprimir limitador
}

#endif // HELPERS_H_INCLUDED
