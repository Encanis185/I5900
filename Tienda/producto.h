#ifndef PRODUCTO_H_INCLUDED
#define PRODUCTO_H_INCLUDED

class Producto{
    private:
        string codigo;
        string nombre;
        float precio;
        string descripcion;
        int stock;
        float descuentos;
        float costoPorSurtir;
    public:
        Producto(string c, string n, float p, string d, int s, float dc, float cS){
            setCodigo(c);
            setNombre(n);
            setPrecio(p);
            setDescripcion(d);
            setStock(s);
            setDescuentos(dc);
            setCostoPorSurtir(cS);
        }
        void setCodigo(string c){
            this->codigo=c;
        }
        string getCodigo(){
            return this->codigo;
        }
        void setNombre(string n){
            this->nombre=n;
        }
        string getNombre(){
            return this->nombre;
        }
        void setPrecio(float p){
            this->precio=p;
        }
        float getPrecio(){
            return this->precio;
        }
        void setDescripcion(string d){
            this->descripcion=d;
        }
        string getDescripcion(){
            return this->descripcion;
        }
        void setStock(int s){
            this->stock=s;
        }
        int getStock(){
            return this->stock;
        }
        void setDescuentos(float dc){
            this->descuentos=dc;
        }
        float getDescuentos(){
            return this->descuentos;
        }
        void setCostoPorSurtir(float cS){
            this->costoPorSurtir=cS;
        }
        float getCostoPorSurtir(){
            return this->costoPorSurtir;
        }
};


#endif // PRODUCTO_H_INCLUDED
