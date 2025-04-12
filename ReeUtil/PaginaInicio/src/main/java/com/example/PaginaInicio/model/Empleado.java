package com.example.PaginaInicio.model;
import java.sql.Date;

import jakarta.persistence.*;

@Entity
public class Empleado {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    
    private Long id_empleado; // Id Empleado

    private String nombre_empleado;
    
    @Column(name = "correo")
    private String correo;
    
    private Long celular;
    
    private String contrasena;

    private Date fecha_registro;

    private Long Sucursal_id_sucursal;  

    
    // Getters y Setters
    public Long getId() { return id_empleado; }
    public void setId(Long id) { this.id_empleado = id; }

    public String getNombre() { return nombre_empleado; }
    public void setNombre(String nombre_empleado) { this.nombre_empleado = nombre_empleado;}

    public void setCorreo(String correo) { this.correo = correo; }
    public String getCorreo() { return correo; }

    public void setCelular(Long celular) { this.celular = celular;}
    public Long getCelular() {return celular;}

    public void setFechaRegistro(Date fecha_registro) { this.fecha_registro = fecha_registro;}
    public Date getFechaRegistro() {return fecha_registro;}

    public String getContrasena() { return contrasena; }
    public void setContrasena(String contrasena) { this.contrasena = contrasena; }

    public void setId_sucursal(Long Sucursal_id_sucursal) { this.Sucursal_id_sucursal = Sucursal_id_sucursal;}
    public Long getId_sucursal() { return Sucursal_id_sucursal;}

    
}