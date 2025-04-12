package Tipo_dispositivos;

public class TipoDispositivo {
    private int idTipo;
    private String nombreTipo;
    private boolean aceptado;

    public TipoDispositivo(String nombreTipo, boolean aceptado) {
        this.nombreTipo = nombreTipo;
        this.aceptado = aceptado;
    }

    public int getIdTipo() {
        return idTipo;
    }

    public void setIdTipo(int idTipo) {
        this.idTipo = idTipo;
    }

    public String getNombreTipo() {
        return nombreTipo;
    }

    public void setNombreTipo(String nombreTipo) {
        this.nombreTipo = nombreTipo;
    }

    public boolean isAceptado() {
        return aceptado;
    }

    public void setAceptado(boolean aceptado) {
        this.aceptado = aceptado;
    }
}
