package Sucursales;

public class Sucursal {
    private int idSucursal;
    private String nombreSucursal;
    private int telefono;
    private String direccion;

    public Sucursal(String nombreSucursal, int telefono, String direccion) {
        this.nombreSucursal = nombreSucursal;
        this.telefono = telefono;
        this.direccion = direccion;
    }

    public int getIdSucursal() {
        return idSucursal;
    }

    public void setIdSucursal(int idSucursal) {
        this.idSucursal = idSucursal;
    }

    public String getNombreSucursal() {
        return nombreSucursal;
    }

    public void setNombreSucursal(String nombreSucursal) {
        this.nombreSucursal = nombreSucursal;
    }

    public int getTelefono() {
        return telefono;
    }

    public void setTelefono(int telefono) {
        this.telefono = telefono;
    }

    public String getDireccion() {
        return direccion;
    }

    public void setDireccion(String direccion) {
        this.direccion = direccion;
    }
}
