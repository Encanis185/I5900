#ifndef VENTAS_H_INCLUDED
#define VENTAS_H_INCLUDED

class Venta{
    private:
        string nombreProductoVendido;
        int cantidadTotal;
        double costoTotal;
        double gananciaTotal;
    public:
        Venta(){
            costoTotal=0;
            cantidadTotal=0;
            gananciaTotal=0;
        }
        void setNombreProductoV(string nPV){
            this->nombreProductoVendido=nPV;
        }
        string getNombreProductosV(){
            return this->nombreProductoVendido;
        }
        void setCantidadTotal(int cT){
            this->cantidadTotal=cT;
        }
        int getCantidadTotal(){
            return this->cantidadTotal;
        }
        void setCostoTotal(double cosT){
            this->costoTotal=cosT;
        }
        double getCostoTotal(){
            return this->costoTotal;
        }
        void setGananciaTotal(double gT){
            this->gananciaTotal=gT;
        }
        double getGananciaTotal(){
            return this->gananciaTotal;
        }
};

#endif // VENTAS_H_INCLUDED
