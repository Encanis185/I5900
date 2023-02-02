#include <cstring>

#ifndef USUARIO_H_INCLUDED
#define USUARIO_H_INCLUDED
#define TAMANIO_NOMBRE_USUARIO 50
#define TAMANIO_CLAVE_USUARIO 20
#define TAMANIO_PUESTO_USUARIO 30

class Usuario{
    private:
        char nombre[TAMANIO_NOMBRE_USUARIO+1];
        char clave[TAMANIO_CLAVE_USUARIO+1];
        char puesto[TAMANIO_PUESTO_USUARIO+1];
        int nivelAcceso;
    public:
        Usuario(char *n, char* c, char* p, int nA){
            setNombre(n);
            setClave(c);
            setPuesto(p);
            setNivelAcceso(nA);
        }

        void setNombre(char* n){
            strcpy(this->nombre, n);
        }
        char* getNombre(){
            return this->nombre;
        }

        void setClave(char* c){
            strcpy(this->clave, c);
        }
        char* getClave(){
            return this->clave;
        }

        void setPuesto(char* p){
            strcpy(this->puesto, p);
        }
        char* getPuesto(){
            return this->puesto;
        }
        void setNivelAcceso(int nA){
            this->nivelAcceso=nA;
        }
        int getNivelAcceso(){
            return this->nivelAcceso;
        }

};


#endif // USUARIO_H_INCLUDED
